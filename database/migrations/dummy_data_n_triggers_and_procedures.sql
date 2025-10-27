DELIMITER $$

CREATE PROCEDURE CreateAuditTrigger(
    IN table_name VARCHAR(64),
    IN primary_key_column VARCHAR(64)
)
BEGIN
    SET @insert_trigger = CONCAT('
        CREATE TRIGGER ', table_name, '_audit_insert
        AFTER INSERT ON ', table_name, '
        FOR EACH ROW
        BEGIN
            INSERT INTO audit_log (table_name, record_id, action_type, new_values, user_id, ip_address)
            VALUES (''', table_name, ''', NEW.', primary_key_column, ', ''INSERT'', 
                   JSON_OBJECT(', 
                   (SELECT GROUP_CONCAT(CONCAT('''', COLUMN_NAME, ''', NEW.', COLUMN_NAME)) 
                    FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE TABLE_NAME = table_name AND TABLE_SCHEMA = DATABASE()), '),
                   @current_user_id, @current_ip_address);
        END');
    
    SET @update_trigger = CONCAT('
        CREATE TRIGGER ', table_name, '_audit_update
        AFTER UPDATE ON ', table_name, '
        FOR EACH ROW
        BEGIN
            INSERT INTO audit_log (table_name, record_id, action_type, old_values, new_values, user_id, ip_address)
            VALUES (''', table_name, ''', NEW.', primary_key_column, ', ''UPDATE'',
                   JSON_OBJECT(', 
                   (SELECT GROUP_CONCAT(CONCAT('''', COLUMN_NAME, ''', OLD.', COLUMN_NAME)) 
                    FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE TABLE_NAME = table_name AND TABLE_SCHEMA = DATABASE()), '),
                   JSON_OBJECT(', 
                   (SELECT GROUP_CONCAT(CONCAT('''', COLUMN_NAME, ''', NEW.', COLUMN_NAME)) 
                    FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE TABLE_NAME = table_name AND TABLE_SCHEMA = DATABASE()), '),
                   @current_user_id, @current_ip_address);
        END');
    
    PREPARE stmt1 FROM @insert_trigger;
    EXECUTE stmt1;
    DEALLOCATE PREPARE stmt1;
    
    PREPARE stmt2 FROM @update_trigger;
    EXECUTE stmt2;
    DEALLOCATE PREPARE stmt2;
END$$


CREATE PROCEDURE CalculateCommission(
    IN p_policy_id BIGINT,
    OUT p_commission_amount DECIMAL(10,2),
    OUT p_calculation_id BIGINT
)
BEGIN
    DECLARE v_premium_amount DECIMAL(12,2);
    DECLARE v_agent_id BIGINT;
    DECLARE v_company_id BIGINT;
    DECLARE v_policy_type_id BIGINT;
    DECLARE v_commission_structure_id BIGINT;
    DECLARE v_commission_type VARCHAR(20);
    DECLARE v_base_percentage DECIMAL(5,2);
    DECLARE v_fixed_amount DECIMAL(10,2);
    DECLARE v_tier_structure JSON;
    DECLARE v_calculated_amount DECIMAL(10,2) DEFAULT 0;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    
    SELECT premium_amount, agent_id, company_id, policy_type_id
    INTO v_premium_amount, v_agent_id, v_company_id, v_policy_type_id
    FROM policies
    WHERE id = p_policy_id;
    
    
    SELECT id, commission_type, base_percentage, fixed_amount, tier_structure
    INTO v_commission_structure_id, v_commission_type, v_base_percentage, v_fixed_amount, v_tier_structure
    FROM commission_structures
    WHERE company_id = v_company_id
      AND policy_type_id = v_policy_type_id
      AND is_active = TRUE
      AND effective_date <= CURDATE()
      AND (expiry_date IS NULL OR expiry_date >= CURDATE())
    ORDER BY effective_date DESC
    LIMIT 1;
    
    
    IF v_commission_type = 'FLAT_PERCENTAGE' THEN
        SET v_calculated_amount = (v_premium_amount * v_base_percentage) / 100;
    ELSEIF v_commission_type = 'FIXED_AMOUNT' THEN
        SET v_calculated_amount = v_fixed_amount;
    ELSEIF v_commission_type = 'TIERED' THEN
        
        SET v_calculated_amount = (v_premium_amount * v_base_percentage) / 100;
    END IF;
    
    
    INSERT INTO commission_calculations (
        policy_id, agent_id, company_id, commission_structure_id,
        calculation_date, premium_amount, commission_rate,
        commission_amount, calculation_method
    ) VALUES (
        p_policy_id, v_agent_id, v_company_id, v_commission_structure_id,
        CURDATE(), v_premium_amount, COALESCE(v_base_percentage, 0),
        v_calculated_amount, v_commission_type
    );
    
    SET p_calculation_id = LAST_INSERT_ID();
    SET p_commission_amount = v_calculated_amount;
    
    COMMIT;
END$$


CREATE PROCEDURE SendRenewalReminders()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_policy_id BIGINT;
    DECLARE v_client_name VARCHAR(101);
    DECLARE v_policy_number VARCHAR(50);
    DECLARE v_expiry_date DATE;
    DECLARE v_agent_id BIGINT;
    DECLARE v_days_to_expiry INT;

    DECLARE renewal_cursor CURSOR FOR
        SELECT 
            p.id, 
            c.full_name, 
            p.policy_number, 
            p.expiry_date, 
            p.agent_id, 
            DATEDIFF(p.expiry_date, CURDATE()) AS days_to_expiry
        FROM policies p
        JOIN clients c ON p.client_id = c.id
        WHERE p.policy_status = 'ACTIVE'
          AND DATEDIFF(p.expiry_date, CURDATE()) BETWEEN 1 AND 30
          AND p.renewal_notice_sent = FALSE;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN renewal_cursor;

    renewal_loop: LOOP
        FETCH renewal_cursor INTO v_policy_id, v_client_name, v_policy_number, v_expiry_date, v_agent_id, v_days_to_expiry;

        IF done THEN
            LEAVE renewal_loop;
        END IF;

        
        INSERT INTO notifications (
            notification_type, title, message, target_user_id,
            related_table, related_record_id, priority
        ) VALUES (
            'POLICY_EXPIRY',
            CONCAT('Policy Expiry Alert - ', v_policy_number),
            CONCAT('Policy for client ', v_client_name, ' expires in ', v_days_to_expiry, ' days on ', v_expiry_date),
            v_agent_id,
            'policies',
            v_policy_id,
            CASE 
                WHEN v_days_to_expiry <= 7 THEN 'HIGH'
                WHEN v_days_to_expiry <= 15 THEN 'MEDIUM'
                ELSE 'LOW'
            END
        );

        
        UPDATE policies 
        SET renewal_notice_sent = TRUE, renewal_notice_date = NOW()
        WHERE id = v_policy_id;

    END LOOP;

    CLOSE renewal_cursor;
END$$


CREATE PROCEDURE CalculateDailyMetrics(IN p_date DATE)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    
    DELETE FROM performance_metrics WHERE metric_date = p_date;
    
    
    INSERT INTO performance_metrics (
        metric_date, agent_id, total_policies_sold, total_premium_amount,
        total_commission_earned, average_policy_value, client_acquisition_count
    )
    SELECT 
        p_date,
        p.agent_id,
        COUNT(*) as total_policies,
        SUM(p.premium_amount) as total_premium,
        COALESCE(SUM(cc.commission_amount), 0) as total_commission,
        AVG(p.premium_amount) as avg_policy_value,
        COUNT(DISTINCT p.client_id) as unique_clients
    FROM policies p
    LEFT JOIN commission_calculations cc ON p.id = cc.policy_id
    WHERE DATE(p.created_at) = p_date
    GROUP BY p.agent_id;
    
    
    INSERT INTO performance_metrics (
        metric_date, company_id, total_policies_sold, total_premium_amount,
        total_commission_earned, average_policy_value
    )
    SELECT 
        p_date,
        p.company_id,
        COUNT(*) as total_policies,
        SUM(p.premium_amount) as total_premium,
        COALESCE(SUM(cc.commission_amount), 0) as total_commission,
        AVG(p.premium_amount) as avg_policy_value
    FROM policies p
    LEFT JOIN commission_calculations cc ON p.id = cc.policy_id
    WHERE DATE(p.created_at) = p_date
    GROUP BY p.company_id
    ON DUPLICATE KEY UPDATE
        total_policies_sold = VALUES(total_policies_sold),
        total_premium_amount = VALUES(total_premium_amount),
        total_commission_earned = VALUES(total_commission_earned),
        average_policy_value = VALUES(average_policy_value);
    
    COMMIT;
END$$

DELIMITER ;






CREATE EVENT IF NOT EXISTS daily_renewal_reminders
ON SCHEDULE EVERY 1 DAY
STARTS TIMESTAMP(CURDATE(), '09:00:00')
DO
  CALL SendRenewalReminders();


CREATE EVENT IF NOT EXISTS daily_metrics_calculation
ON SCHEDULE EVERY 1 DAY
STARTS TIMESTAMP(CURDATE(), '23:30:00')
DO
  CALL CalculateDailyMetrics(CURDATE());






INSERT INTO user_roles (role_name, description, permissions) VALUES
('Super Admin', 'Full system access', JSON_ARRAY('*')),
('Admin', 'Administrative access', JSON_ARRAY('user_management', 'system_settings', 'reports')),
('Agent', 'Insurance agent access', JSON_ARRAY('client_management', 'policy_management', 'commission_view')),
('Accountant', 'Financial and commission management', JSON_ARRAY('commission_management', 'payment_processing', 'financial_reports'));

INSERT INTO users (
    username, email, password, first_name, last_name,
    phone, role_id, employee_id, is_active, last_login
)
VALUES

('superadmin', 'superadmin@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'John', 'Maina', '+254700000001', 1, 'EMP0001', TRUE, NULL),
('root', 'root@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Mary', 'Otieno', '+254700000002', 1, 'EMP0002', TRUE, NULL),


('admin_jane', 'jane.admin@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Jane', 'Mutiso', '+254700000003', 2, 'EMP0003', TRUE, NULL),
('admin_peter', 'peter.admin@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Peter', 'Kamau', '+254700000004', 2, 'EMP0004', TRUE, NULL),
('admin_kariuki', 'kariuki.admin@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Joseph', 'Kariuki', '+254700000005', 2, 'EMP0005', TRUE, NULL),


('agent_anne', 'anne.agent@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Anne', 'Wambui', '+254700000006', 3, 'EMP0006', TRUE, NULL),
('agent_musa', 'musa.agent@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Musa', 'Abdallah', '+254700000007', 3, 'EMP0007', TRUE, NULL),
('agent_lucy', 'lucy.agent@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Lucy', 'Njeri', '+254700000008', 3, 'EMP0008', TRUE, NULL),
('agent_dan', 'dan.agent@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Dan', 'Mutua', '+254700000009', 3, 'EMP0009', TRUE, NULL),
('agent_sarah', 'sarah.agent@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Sarah', 'Kilonzo', '+254700000010', 3, 'EMP0010', TRUE, NULL),
('agent_john', 'john.agent@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'John', 'Omondi', '+254700000011', 3, 'EMP0011', TRUE, NULL),
('agent_kate', 'kate.agent@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Kate', 'Mwangi', '+254700000012', 3, 'EMP0012', TRUE, NULL),


('accountant_alex', 'alex.accountant@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Alex', 'Mugo', '+254700000013', 4, 'EMP0013', TRUE, NULL),
('accountant_ruth', 'ruth.accountant@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Ruth', 'Cherono', '+254700000014', 4, 'EMP0014', TRUE, NULL),
('accountant_kevin', 'kevin.accountant@example.com', '$2y$10$KUuTbdpIrXOVpErY1zNy2ecJrpGiN/BFdxN38MdPdBOvPz.fuyFqq', 'Kevin', 'Otieno', '+254700000015', 4, 'EMP0015', TRUE, NULL);



INSERT INTO policy_types (type_name, type_code, description) VALUES
('Life Insurance', 'LIFE', 'Life insurance policies'),
('Motor Vehicle', 'MOTOR', 'Vehicle insurance policies'),
('Health Insurance', 'HEALTH', 'Medical and health insurance'),
('Property Insurance', 'PROPERTY', 'Home and property insurance'),
('General Insurance', 'GENERAL', 'General insurance policies'),
('Business Insurance', 'BUSINESS', 'Business insurance policies'),
('Home Insurance', 'HOME', 'Home insurance policies'),
('Marine Insurance', 'MARINE', 'Marine insurance policies'),
('Travel Insurance', 'TRAVEL', 'Travel and vacation insurance');


INSERT INTO insurance_companies (company_name, company_code, contact_person, email, phone, city, postal_code, country, website, is_active, created_at, updated_at) VALUES
('APA Insurance', 'APA001', 'John Mwangi', 'contact@apainsurance.co.ke', '+254700111222', 'Nairobi', '00100', 'Kenya', 'https://apainsurance.co.ke', 1, NOW(), NOW()),
('Old Mutual Kenya', 'OMK002', 'Grace Wanjiru', 'info@oldmutual.co.ke', '+254700333444', 'Nairobi', '00101', 'Kenya', 'https://oldmutual.co.ke', 1, NOW(), NOW()),
('CIC Insurance Group', 'CIC003', 'Michael Otieno', 'support@cic.co.ke', '+254700555666', 'Nairobi', '00102', 'Kenya', 'https://cic.co.ke', 1, NOW(), NOW()),
('GA Insurance', 'GA004', 'Alice Njeri', 'contact@ga.co.ke', '+254700777888', 'Nairobi', '00103', 'Kenya', 'https://ga.co.ke', 1, NOW(), NOW()),
('Britam Insurance', 'BRIT005', 'David Kimani', 'info@britam.co.ke', '+254700999000', 'Nairobi', '00104', 'Kenya', 'https://britam.co.ke', 1, NOW(), NOW()),
('Jubilee Insurance', 'JUB006', 'Mary Achieng', 'help@jubilee.co.ke', '+254701111222', 'Nairobi', '00105', 'Kenya', 'https://jubilee.co.ke', 1, NOW(), NOW()),
('AAR Insurance', 'AAR007', 'Paul Omondi', 'contact@aar.co.ke', '+254701333444', 'Nairobi', '00106', 'Kenya', 'https://aar.co.ke', 1, NOW(), NOW()),
('ICEA Lion', 'ICEA008', 'Catherine Wambui', 'info@icealion.co.ke', '+254701555666', 'Nairobi', '00107', 'Kenya', 'https://icealion.co.ke', 1, NOW(), NOW()),
('Madison Insurance', 'MAD009', 'Samuel Kariuki', 'support@madison.co.ke', '+254701777888', 'Nairobi', '00108', 'Kenya', 'https://madison.co.ke', 1, NOW(), NOW()),
('Heritage Insurance', 'HER010', 'Esther Mwende', 'info@heritage.co.ke', '+254701999000', 'Nairobi', '00109', 'Kenya', 'https://heritage.co.ke', 1, NOW(), NOW());


INSERT INTO commission_structures (
 company_id, policy_type_id, structure_name, commission_type,
 base_percentage, fixed_amount, tier_structure,
 minimum_premium, maximum_premium, effective_date, expiry_date, is_active
) VALUES

(1, 1, 'Life Standard Commission', 'TIERED',
NULL, NULL, JSON_ARRAY(JSON_OBJECT('min_amount', 0, 'max_amount', 50000, 'rate', 5.00), JSON_OBJECT('min_amount', 50001, 'max_amount', 200000, 'rate', 3.50), JSON_OBJECT('min_amount', 200001, 'max_amount', NULL, 'rate', 2.00)
),
 0, NULL, CURDATE(), NULL, TRUE
),


(1, 2, 'Motor Vehicle Flat Commission', 'FLAT_PERCENTAGE', 10.00,
NULL, NULL,
 0, NULL, CURDATE(), NULL, TRUE
),


(1, 3, 'Health Insurance Commission', 'TIERED',
NULL, NULL, JSON_ARRAY(JSON_OBJECT('min_amount', 0, 'max_amount', 10000, 'rate', 8.00), JSON_OBJECT('min_amount', 10001, 'max_amount', 50000, 'rate', 6.00), JSON_OBJECT('min_amount', 50001, 'max_amount', NULL, 'rate', 4.50)
),
 0, NULL, CURDATE(), NULL, TRUE
),


(1, 4, 'Property Standard Commission', 'FLAT_PERCENTAGE', 7.50,
NULL, NULL,
 0, NULL, CURDATE(), NULL, TRUE
),


(1, 5, 'General Commission Flat', 'FLAT_PERCENTAGE', 6.00,
NULL, NULL,
 0, NULL, CURDATE(), NULL, TRUE
),


(1, 6, 'Business Tiered Commission', 'TIERED',
NULL, NULL, JSON_ARRAY(JSON_OBJECT('min_amount', 0, 'max_amount', 100000, 'rate', 4.50), JSON_OBJECT('min_amount', 100001, 'max_amount', 500000, 'rate', 3.00), JSON_OBJECT('min_amount', 500001, 'max_amount', NULL, 'rate', 2.00)
),
 0, NULL, CURDATE(), NULL, TRUE
),


(1, 7, 'Home Flat Commission', 'FLAT_PERCENTAGE', 8.00,
NULL, NULL,
 0, NULL, CURDATE(), NULL, TRUE
),


(1, 8, 'Marine Fixed Commission', 'FIXED_AMOUNT',
NULL, 1500.00, NULL,
 10000, NULL, CURDATE(), NULL, TRUE
),


(1, 9, 'Travel Insurance Flat', 'FLAT_PERCENTAGE', 12.00,
NULL, NULL,
 0, NULL, CURDATE(), NULL, TRUE
);

INSERT INTO commission_structures (company_id, policy_type_id, structure_name, commission_type, base_percentage, fixed_amount, tier_structure, minimum_premium, maximum_premium, effective_date, expiry_date, is_active, created_at, updated_at) VALUES
(1, 3, 'Standard Commission', 'FLAT_PERCENTAGE', 7.5, NULL, NULL, 1000, 500000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),
(1, 5, 'Premium Commission', 'TIERED', NULL, NULL, '[{"min":0,"max":50000,"percentage":5},{"min":50001,"max":200000,"percentage":8},{"min":200001,"max":null,"percentage":10}]', 500, NULL, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),

(2, 2, 'Standard Commission', 'FLAT_PERCENTAGE', 6.0, NULL, NULL, 1200, 400000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),
(2, 7, 'Fixed Amount Commission', 'FIXED_AMOUNT', NULL, 3500, NULL, 1500, 600000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),

(3, 1, 'Standard Commission', 'FLAT_PERCENTAGE', 8.0, NULL, NULL, 800, 450000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),
(3, 6, 'Tiered Commission', 'TIERED', NULL, NULL, '[{"min":0,"max":75000,"percentage":6},{"min":75001,"max":150000,"percentage":9},{"min":150001,"max":null,"percentage":11}]', 750, NULL, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),

(4, 4, 'Standard Commission', 'FLAT_PERCENTAGE', 7.0, NULL, NULL, 1000, 550000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),
(4, 8, 'Fixed Amount Commission', 'FIXED_AMOUNT', NULL, 4000, NULL, 2000, 700000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),

(5, 3, 'Standard Commission', 'FLAT_PERCENTAGE', 7.8, NULL, NULL, 900, 480000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),
(5, 3, 'Tiered Commission', 'TIERED', NULL, NULL, '[{"min":0,"max":60000,"percentage":5.5},{"min":60001,"max":180000,"percentage":8.5},{"min":180001,"max":null,"percentage":10.5}]', 600, NULL, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),

(6, 2, 'Standard Commission', 'FLAT_PERCENTAGE', 6.5, NULL, NULL, 1100, 520000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),
(6, 1, 'Fixed Amount Commission', 'FIXED_AMOUNT', NULL, 3200, NULL, 1000, 450000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),

(7, 9, 'Standard Commission', 'FLAT_PERCENTAGE', 7.2, NULL, NULL, 1300, 440000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),
(7, 4, 'Tiered Commission', 'TIERED', NULL, NULL, '[{"min":0,"max":40000,"percentage":5},{"min":40001,"max":120000,"percentage":7.5},{"min":120001,"max":null,"percentage":9.5}]', 400, NULL, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),

(8, 4, 'Standard Commission', 'FLAT_PERCENTAGE', 6.8, NULL, NULL, 950, 460000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),
(8, 7, 'Fixed Amount Commission', 'FIXED_AMOUNT', NULL, 2900, NULL, 850, 410000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),

(9, 6, 'Standard Commission', 'FLAT_PERCENTAGE', 7.7, NULL, NULL, 1050, 490000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),
(9, 8, 'Tiered Commission', 'TIERED', NULL, NULL, '[{"min":0,"max":50000,"percentage":6},{"min":50001,"max":150000,"percentage":9},{"min":150001,"max":null,"percentage":11}]', 500, NULL, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),

(10, 5, 'Standard Commission', 'FLAT_PERCENTAGE', 7.3, NULL, NULL, 1000, 500000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW()),
(10, 2, 'Fixed Amount Commission', 'FIXED_AMOUNT', NULL, 3600, NULL, 1200, 550000, DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 365) DAY), NULL, 1, NOW(), NOW());

INSERT INTO system_settings (setting_key, setting_value, setting_type, description, is_system_setting) VALUES
('company_name', 'Dwin Insurance Agency', 'STRING', 'Company name', TRUE),
('renewal_reminder_days', '30,15,7,3,1', 'STRING', 'Days before expiry to send reminders', TRUE),
('default_currency', 'KES', 'STRING', 'Default currency for transactions', TRUE),
('commission_payment_frequency', 'MONTHLY', 'STRING', 'Default commission payment frequency', TRUE),
('system_email', 'system@dwininsurance.com', 'STRING', 'System email for notifications', TRUE),
('backup_retention_days', '90', 'INTEGER', 'Days to retain database backups', TRUE),
('session_timeout_minutes', '60', 'INTEGER', 'User session timeout in minutes', TRUE),
('max_file_upload_size_mb', '10', 'INTEGER', 'Maximum file upload size in MB', TRUE),
('enable_email_notifications', 'true', 'BOOLEAN', 'Enable email notifications', TRUE),
('enable_sms_notifications', 'false', 'BOOLEAN', 'Enable SMS notifications', TRUE);







DELIMITER $

CREATE TRIGGER users_audit_insert
AFTER INSERT ON users
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, new_values, user_id)
    VALUES ('users', NEW.id, 'INSERT', 
           JSON_OBJECT('id', NEW.id, 'username', NEW.username, 'email', NEW.email, 
                      'first_name', NEW.first_name, 'last_name', NEW.last_name,
                      'role_id', NEW.role_id, 'is_active', NEW.is_active),
           @audit_user_id);
END$

CREATE TRIGGER users_audit_update
AFTER UPDATE ON users
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, old_values, new_values, user_id)
    VALUES ('users', NEW.id, 'UPDATE',
           JSON_OBJECT('username', OLD.username, 'email', OLD.email, 
                      'first_name', OLD.first_name, 'last_name', OLD.last_name,
                      'role_id', OLD.role_id, 'is_active', OLD.is_active),
           JSON_OBJECT('username', NEW.username, 'email', NEW.email, 
                      'first_name', NEW.first_name, 'last_name', NEW.last_name,
                      'role_id', NEW.role_id, 'is_active', NEW.is_active),
           @audit_user_id);
END$


CREATE TRIGGER clients_audit_insert
AFTER INSERT ON clients
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, new_values, user_id)
    VALUES ('clients', NEW.id, 'INSERT',
           JSON_OBJECT('id', NEW.id, 'client_code', NEW.client_code, 
                      'first_name', NEW.first_name, 'last_name', NEW.last_name,
                      'phone_primary', NEW.phone_primary, 'email', NEW.email,
                      'client_status', NEW.client_status),
           @audit_user_id);
END$

CREATE TRIGGER clients_audit_update
AFTER UPDATE ON clients
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, old_values, new_values, user_id)
    VALUES ('clients', NEW.id, 'UPDATE',
           JSON_OBJECT('client_code', OLD.client_code, 'first_name', OLD.first_name, 
                      'last_name', OLD.last_name, 'phone_primary', OLD.phone_primary,
                      'email', OLD.email, 'client_status', OLD.client_status),
           JSON_OBJECT('client_code', NEW.client_code, 'first_name', NEW.first_name, 
                      'last_name', NEW.last_name, 'phone_primary', NEW.phone_primary,
                      'email', NEW.email, 'client_status', NEW.client_status),
           @audit_user_id);
END$


CREATE TRIGGER policies_audit_insert
AFTER INSERT ON policies
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, new_values, user_id)
    VALUES ('policies', NEW.id, 'INSERT',
           JSON_OBJECT('id', NEW.id, 'policy_number', NEW.policy_number,
                      'client_id', NEW.client_id, 'company_id', NEW.company_id,
                      'policy_type_id', NEW.policy_type_id, 'agent_id', NEW.agent_id,
                      'premium_amount', NEW.premium_amount, 'policy_status', NEW.policy_status),
           @audit_user_id);
END$

CREATE TRIGGER policies_audit_update
AFTER UPDATE ON policies
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, old_values, new_values, user_id)
    VALUES ('policies', NEW.id, 'UPDATE',
           JSON_OBJECT('policy_number', OLD.policy_number, 'client_id', OLD.client_id,
                      'premium_amount', OLD.premium_amount, 'policy_status', OLD.policy_status),
           JSON_OBJECT('policy_number', NEW.policy_number, 'client_id', NEW.client_id,
                      'premium_amount', NEW.premium_amount, 'policy_status', NEW.policy_status),
           @audit_user_id);
END$


CREATE TRIGGER commission_calculations_audit_insert
AFTER INSERT ON commission_calculations
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, new_values, user_id)
    VALUES ('commission_calculations', NEW.id, 'INSERT',
           JSON_OBJECT('id', NEW.id, 'policy_id', NEW.policy_id, 'agent_id', NEW.agent_id,
                      'commission_amount', NEW.commission_amount, 'payment_status', NEW.payment_status),
           @audit_user_id);
END$

CREATE TRIGGER commission_calculations_audit_update
AFTER UPDATE ON commission_calculations
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, old_values, new_values, user_id)
    VALUES ('commission_calculations', NEW.id, 'UPDATE',
           JSON_OBJECT('commission_amount', OLD.commission_amount, 'payment_status', OLD.payment_status),
           JSON_OBJECT('commission_amount', NEW.commission_amount, 'payment_status', NEW.payment_status),
           @audit_user_id);
END$

DELIMITER ;





DELIMITER $


CREATE PROCEDURE GetClientPolicySummary(IN p_client_id BIGINT)
BEGIN
    SELECT 
        p.id,
        p.policy_number,
        pt.type_name as policy_type,
        ic.company_name,
        p.premium_amount,
        p.sum_insured,
        p.effective_date,
        p.expiry_date,
        DATEDIFF(p.expiry_date, CURDATE()) AS days_to_expiry,
        p.policy_status,
        CONCAT(u.first_name, ' ', u.last_name) as agent_name
    FROM policies p
    JOIN policy_types pt ON p.policy_type_id = pt.id
    JOIN insurance_companies ic ON p.company_id = ic.id
    JOIN users u ON p.agent_id = u.id
    WHERE p.client_id = p_client_id
    ORDER BY p.effective_date DESC;
END$


CREATE PROCEDURE GetAgentPerformanceReport(
    IN p_agent_id BIGINT,
    IN p_start_date DATE,
    IN p_end_date DATE
)
BEGIN
    SELECT 
        DATE(p.created_at) as sale_date,
        COUNT(*) as policies_sold,
        SUM(p.premium_amount) as total_premium,
        AVG(p.premium_amount) as avg_premium,
        SUM(COALESCE(cc.commission_amount, 0)) as total_commission,
        COUNT(DISTINCT p.client_id) as unique_clients
    FROM policies p
    LEFT JOIN commission_calculations cc ON p.id = cc.policy_id
    WHERE p.agent_id = p_agent_id
      AND DATE(p.created_at) BETWEEN p_start_date AND p_end_date
    GROUP BY DATE(p.created_at)
    ORDER BY sale_date DESC;
END$


CREATE PROCEDURE GenerateClientCode(OUT p_client_code VARCHAR(20))
BEGIN
    DECLARE v_counter INT;
    DECLARE v_year VARCHAR(4);
    
    SET v_year = YEAR(CURDATE());
    
    SELECT COALESCE(MAX(CAST(SUBSTRING(client_code, -4) AS UNSIGNED)), 0) + 1
    INTO v_counter
    FROM clients
    WHERE client_code LIKE CONCAT('CL', v_year, '%');
    
    SET p_client_code = CONCAT('CL', v_year, LPAD(v_counter, 4, '0'));
END$


CREATE PROCEDURE GeneratePolicyNumber(
    IN p_company_code VARCHAR(20),
    IN p_policy_type_code VARCHAR(20),
    OUT p_policy_number VARCHAR(50)
)
BEGIN
    DECLARE v_counter INT;
    DECLARE v_year VARCHAR(4);
    DECLARE v_prefix VARCHAR(50);
    
    SET v_year = YEAR(CURDATE());
    SET v_prefix = CONCAT(p_company_code, '-', p_policy_type_code, '-', v_year, '-');
    
    SELECT COALESCE(MAX(CAST(SUBSTRING(policy_number, -4) AS UNSIGNED)), 0) + 1
    INTO v_counter
    FROM policies
    WHERE policy_number LIKE CONCAT(v_prefix, '%');
    
    SET p_policy_number = CONCAT(v_prefix, LPAD(v_counter, 4, '0'));
END$


CREATE PROCEDURE GetAgentCommissionSummary(
    IN p_agent_id BIGINT,
    IN p_year INT
)
BEGIN
    SELECT 
        MONTH(cc.calculation_date) as month,
        MONTHNAME(cc.calculation_date) as month_name,
        COUNT(*) as total_calculations,
        SUM(cc.commission_amount) as total_commission,
        SUM(CASE WHEN cc.payment_status = 'PAID' THEN cc.commission_amount ELSE 0 END) as paid_commission,
        SUM(CASE WHEN cc.payment_status = 'PENDING' THEN cc.commission_amount ELSE 0 END) as pending_commission,
        AVG(cc.commission_amount) as avg_commission
    FROM commission_calculations cc
    WHERE cc.agent_id = p_agent_id
      AND YEAR(cc.calculation_date) = p_year
    GROUP BY MONTH(cc.calculation_date), MONTHNAME(cc.calculation_date)
    ORDER BY MONTH(cc.calculation_date);
END$


CREATE PROCEDURE GetExpiringPoliciesReport(IN p_days_ahead INT)
BEGIN
    SELECT 
        p.policy_number,
        c.full_name as client_name,
        c.phone_primary,
        c.email,
        pt.type_name as policy_type,
        ic.company_name,
        p.premium_amount,
        p.expiry_date,
        DATEDIFF(p.expiry_date, CURDATE()) AS days_to_expiry,
        CONCAT(u.first_name, ' ', u.last_name) as agent_name,
        u.phone as agent_phone,
        p.renewal_notice_sent
    FROM policies p
    JOIN clients c ON p.client_id = c.id
    JOIN policy_types pt ON p.policy_type_id = pt.id
    JOIN insurance_companies ic ON p.company_id = ic.id
    JOIN users u ON p.agent_id = u.id
    WHERE p.policy_status = 'ACTIVE'
      AND days_to_expiry BETWEEN 0 AND p_days_ahead
    ORDER BY days_to_expiry ASC, c.full_name;
END$


CREATE PROCEDURE GetOutstandingCommissions()
BEGIN
    SELECT 
        u.employee_id,
        CONCAT(u.first_name, ' ', u.last_name) as agent_name,
        COUNT(*) as pending_calculations,
        SUM(cc.commission_amount) as total_outstanding,
        MIN(cc.calculation_date) as oldest_calculation,
        MAX(cc.calculation_date) as newest_calculation
    FROM commission_calculations cc
    JOIN users u ON cc.agent_id = u.id
    WHERE cc.payment_status = 'PENDING'
    GROUP BY cc.agent_id, u.employee_id, agent_name
    ORDER BY total_outstanding DESC;
END$


CREATE PROCEDURE UpdateExpiredPolicies()
BEGIN
    UPDATE policies 
    SET policy_status = 'EXPIRED',
        updated_at = NOW()
    WHERE policy_status = 'ACTIVE' 
      AND expiry_date < CURDATE();
    
    SELECT ROW_COUNT() as policies_updated;
END$

DELIMITER ;






CREATE VIEW v_active_policies AS
SELECT 
    p.id,
    p.policy_number,
    c.full_name as client_name,
    c.phone_primary as client_phone,
    pt.type_name as policy_type,
    ic.company_name,
    p.premium_amount,
    p.sum_insured,
    p.effective_date,
    p.expiry_date,
    DATEDIFF(p.expiry_date, CURDATE()) AS days_to_expiry,
    CONCAT(u.first_name, ' ', u.last_name) as agent_name
FROM policies p
JOIN clients c ON p.client_id = c.id
JOIN policy_types pt ON p.policy_type_id = pt.id
JOIN insurance_companies ic ON p.company_id = ic.id
JOIN users u ON p.agent_id = u.id
WHERE p.policy_status = 'ACTIVE';


CREATE VIEW v_commission_summary AS
SELECT 
    cc.agent_id,
    CONCAT(u.first_name, ' ', u.last_name) as agent_name,
    u.employee_id,
    ic.company_name,
    pt.type_name as policy_type,
    DATE(cc.calculation_date) as calculation_date,
    COUNT(*) as commission_count,
    SUM(cc.commission_amount) as total_commission,
    AVG(cc.commission_amount) as avg_commission,
    cc.payment_status
FROM commission_calculations cc
JOIN users u ON cc.agent_id = u.id
JOIN insurance_companies ic ON cc.company_id = ic.id
JOIN policies p ON cc.policy_id = p.id
JOIN policy_types pt ON p.policy_type_id = pt.id
GROUP BY cc.agent_id, agent_name, u.employee_id, ic.company_name, 
         pt.type_name, DATE(cc.calculation_date), cc.payment_status;


CREATE VIEW v_client_summary AS
SELECT 
    c.id,
    c.client_code,
    c.full_name,
    c.phone_primary,
    c.email,
    c.client_status,
    c.kyc_status,
    COUNT(p.id) as total_policies,
    SUM(CASE WHEN p.policy_status = 'ACTIVE' THEN 1 ELSE 0 END) as active_policies,
    SUM(CASE WHEN p.policy_status = 'ACTIVE' THEN p.premium_amount ELSE 0 END) as total_active_premium,
    MAX(p.created_at) as last_policy_date,
    CONCAT(u.first_name, ' ', u.last_name) as assigned_agent
FROM clients c
LEFT JOIN policies p ON c.id = p.client_id
LEFT JOIN users u ON c.assigned_agent_id = u.id
GROUP BY c.id, c.client_code, c.full_name, c.phone_primary, c.email, 
         c.client_status, c.kyc_status, assigned_agent;

CREATE INDEX idx_policies_created_at ON policies(created_at);
CREATE INDEX idx_policies_company_type ON policies(company_id, policy_type_id);
CREATE INDEX idx_commission_calc_date ON commission_calculations(calculation_date);
CREATE INDEX idx_commission_agent_date ON commission_calculations(agent_id, calculation_date);
CREATE INDEX idx_clients_agent ON clients(assigned_agent_id);
CREATE INDEX idx_audit_log_table_date ON audit_log(table_name, created_at);