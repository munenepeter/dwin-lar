-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for dwin
CREATE DATABASE IF NOT EXISTS `dwin` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dwin`;

-- Dumping structure for table dwin.audit_log
CREATE TABLE IF NOT EXISTS `audit_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `table_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `record_id` bigint unsigned NOT NULL,
  `action_type` enum('INSERT','UPDATE','DELETE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `audit_log_table_name_record_id_index` (`table_name`,`record_id`),
  KEY `audit_log_created_at_index` (`created_at`),
  KEY `audit_log_user_id_index` (`user_id`),
  KEY `idx_audit_log_table_date` (`table_name`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for procedure dwin.CalculateCommission
DELIMITER //
CREATE PROCEDURE `CalculateCommission`(
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
END//
DELIMITER ;

-- Dumping structure for procedure dwin.CalculateDailyMetrics
DELIMITER //
CREATE PROCEDURE `CalculateDailyMetrics`(IN p_date DATE)
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
END//
DELIMITER ;

-- Dumping structure for table dwin.clients
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('MALE','FEMALE','OTHER') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_primary` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_secondary` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `county` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Kenya',
  `occupation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employer` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annual_income` decimal(12,2) DEFAULT NULL,
  `marital_status` enum('SINGLE','MARRIED','DIVORCED','WIDOWED') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_of_kin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_of_kin_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_of_kin_relationship` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_agent_id` bigint unsigned DEFAULT NULL,
  `client_status` enum('ACTIVE','INACTIVE','SUSPENDED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `kyc_status` enum('PENDING','VERIFIED','REJECTED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `kyc_verified_date` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `full_name` varchar(101) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (concat(`first_name`,_utf8mb4' ',`last_name`)) VIRTUAL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_client_code_unique` (`client_code`),
  UNIQUE KEY `clients_id_number_unique` (`id_number`),
  KEY `clients_client_code_id_number_phone_primary_index` (`client_code`,`id_number`,`phone_primary`),
  KEY `idx_clients_agent` (`assigned_agent_id`),
  CONSTRAINT `clients_assigned_agent_id_foreign` FOREIGN KEY (`assigned_agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.client_documents
CREATE TABLE IF NOT EXISTS `client_documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `document_type` enum('ID_COPY','PASSPORT_COPY','KRA_PIN','PROOF_OF_INCOME','BANK_STATEMENT','OTHER') COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int DEFAULT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_by` bigint unsigned NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verified_by` bigint unsigned DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_documents_client_id_foreign` (`client_id`),
  KEY `client_documents_uploaded_by_foreign` (`uploaded_by`),
  KEY `client_documents_verified_by_foreign` (`verified_by`),
  CONSTRAINT `client_documents_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `client_documents_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `client_documents_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.commission_calculations
CREATE TABLE IF NOT EXISTS `commission_calculations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `policy_id` bigint unsigned NOT NULL,
  `agent_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `commission_structure_id` bigint unsigned NOT NULL,
  `calculation_date` date NOT NULL,
  `premium_amount` decimal(12,2) NOT NULL,
  `commission_rate` decimal(5,2) NOT NULL,
  `commission_amount` decimal(10,2) NOT NULL,
  `calculation_method` enum('FLAT_PERCENTAGE','TIERED','FIXED_AMOUNT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `calculation_details` json DEFAULT NULL,
  `payment_status` enum('PENDING','PAID','CANCELLED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `payment_date` date DEFAULT NULL,
  `payment_reference` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commission_calculations_policy_id_foreign` (`policy_id`),
  KEY `commission_calculations_company_id_foreign` (`company_id`),
  KEY `commission_calculations_commission_structure_id_foreign` (`commission_structure_id`),
  KEY `idx_commission_calc_date` (`calculation_date`),
  KEY `idx_commission_agent_date` (`agent_id`,`calculation_date`),
  CONSTRAINT `commission_calculations_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `commission_calculations_commission_structure_id_foreign` FOREIGN KEY (`commission_structure_id`) REFERENCES `commission_structures` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `commission_calculations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `insurance_companies` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `commission_calculations_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `policies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.commission_payments
CREATE TABLE IF NOT EXISTS `commission_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `payment_batch_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent_id` bigint unsigned NOT NULL,
  `payment_period_start` date NOT NULL,
  `payment_period_end` date NOT NULL,
  `total_commission_amount` decimal(12,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` enum('BANK_TRANSFER','CHEQUE','CASH','MOBILE_MONEY') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_reference` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_details` json DEFAULT NULL,
  `status` enum('PENDING','PROCESSED','FAILED','CANCELLED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `processed_by` bigint unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `commission_payments_payment_batch_number_unique` (`payment_batch_number`),
  KEY `commission_payments_agent_id_foreign` (`agent_id`),
  KEY `commission_payments_processed_by_foreign` (`processed_by`),
  CONSTRAINT `commission_payments_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `commission_payments_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.commission_payment_items
CREATE TABLE IF NOT EXISTS `commission_payment_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `commission_payment_id` bigint unsigned NOT NULL,
  `commission_calculation_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_comm_payment_calc` (`commission_payment_id`,`commission_calculation_id`),
  KEY `commission_payment_items_commission_calculation_id_foreign` (`commission_calculation_id`),
  CONSTRAINT `commission_payment_items_commission_calculation_id_foreign` FOREIGN KEY (`commission_calculation_id`) REFERENCES `commission_calculations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commission_payment_items_commission_payment_id_foreign` FOREIGN KEY (`commission_payment_id`) REFERENCES `commission_payments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.commission_structures
CREATE TABLE IF NOT EXISTS `commission_structures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `policy_type_id` bigint unsigned NOT NULL,
  `structure_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commission_type` enum('FLAT_PERCENTAGE','TIERED','FIXED_AMOUNT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `base_percentage` decimal(5,2) DEFAULT NULL,
  `fixed_amount` decimal(10,2) DEFAULT NULL,
  `tier_structure` json DEFAULT NULL,
  `minimum_premium` decimal(10,2) NOT NULL DEFAULT '0.00',
  `maximum_premium` decimal(10,2) DEFAULT NULL,
  `effective_date` date NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_commission_structure` (`company_id`,`policy_type_id`,`effective_date`),
  KEY `commission_structures_policy_type_id_foreign` (`policy_type_id`),
  CONSTRAINT `commission_structures_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `insurance_companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commission_structures_policy_type_id_foreign` FOREIGN KEY (`policy_type_id`) REFERENCES `policy_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for procedure dwin.CreateAuditTrigger
DELIMITER //
CREATE PROCEDURE `CreateAuditTrigger`(
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
END//
DELIMITER ;

-- Dumping structure for event dwin.daily_metrics_calculation
DELIMITER //
CREATE EVENT `daily_metrics_calculation` ON SCHEDULE EVERY 1 DAY STARTS '2025-10-16 23:30:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL CalculateDailyMetrics(CURDATE())//
DELIMITER ;

-- Dumping structure for event dwin.daily_renewal_reminders
DELIMITER //
CREATE EVENT `daily_renewal_reminders` ON SCHEDULE EVERY 1 DAY STARTS '2025-10-16 09:00:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL SendRenewalReminders()//
DELIMITER ;

-- Dumping structure for table dwin.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for procedure dwin.GenerateClientCode
DELIMITER //
CREATE PROCEDURE `GenerateClientCode`(OUT p_client_code VARCHAR(20))
BEGIN
    DECLARE v_counter INT;
    DECLARE v_year VARCHAR(4);
    
    SET v_year = YEAR(CURDATE());
    
    SELECT COALESCE(MAX(CAST(SUBSTRING(client_code, -4) AS UNSIGNED)), 0) + 1
    INTO v_counter
    FROM clients
    WHERE client_code LIKE CONCAT('CL', v_year, '%');
    
    SET p_client_code = CONCAT('CL', v_year, LPAD(v_counter, 4, '0'));
END//
DELIMITER ;

-- Dumping structure for procedure dwin.GeneratePolicyNumber
DELIMITER //
CREATE PROCEDURE `GeneratePolicyNumber`(
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
END//
DELIMITER ;

-- Dumping structure for procedure dwin.GetAgentCommissionSummary
DELIMITER //
CREATE PROCEDURE `GetAgentCommissionSummary`(
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
END//
DELIMITER ;

-- Dumping structure for procedure dwin.GetAgentPerformanceReport
DELIMITER //
CREATE PROCEDURE `GetAgentPerformanceReport`(
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
END//
DELIMITER ;

-- Dumping structure for procedure dwin.GetClientPolicySummary
DELIMITER //
CREATE PROCEDURE `GetClientPolicySummary`(IN p_client_id BIGINT)
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
END//
DELIMITER ;

-- Dumping structure for procedure dwin.GetExpiringPoliciesReport
DELIMITER //
CREATE PROCEDURE `GetExpiringPoliciesReport`(IN p_days_ahead INT)
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
END//
DELIMITER ;

-- Dumping structure for procedure dwin.GetOutstandingCommissions
DELIMITER //
CREATE PROCEDURE `GetOutstandingCommissions`()
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
END//
DELIMITER ;

-- Dumping structure for table dwin.insurance_companies
CREATE TABLE IF NOT EXISTS `insurance_companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Kenya',
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `insurance_companies_company_name_unique` (`company_name`),
  UNIQUE KEY `insurance_companies_company_code_unique` (`company_code`),
  KEY `insurance_companies_company_code_is_active_index` (`company_code`,`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `notification_type` enum('POLICY_EXPIRY','RENEWAL_DUE','COMMISSION_READY','KYC_PENDING','PAYMENT_DUE','SYSTEM_ALERT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_user_id` bigint unsigned DEFAULT NULL,
  `target_role_id` bigint unsigned DEFAULT NULL,
  `related_table` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `related_record_id` bigint unsigned DEFAULT NULL,
  `priority` enum('LOW','MEDIUM','HIGH','URGENT') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MEDIUM',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_sent` tinyint(1) NOT NULL DEFAULT '0',
  `send_email` tinyint(1) NOT NULL DEFAULT '0',
  `send_sms` tinyint(1) NOT NULL DEFAULT '0',
  `email_sent_at` timestamp NULL DEFAULT NULL,
  `sms_sent_at` timestamp NULL DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_target_user_id_foreign` (`target_user_id`),
  KEY `notifications_target_role_id_foreign` (`target_role_id`),
  CONSTRAINT `notifications_target_role_id_foreign` FOREIGN KEY (`target_role_id`) REFERENCES `user_roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notifications_target_user_id_foreign` FOREIGN KEY (`target_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.performance_metrics
CREATE TABLE IF NOT EXISTS `performance_metrics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `metric_date` date NOT NULL,
  `agent_id` bigint unsigned DEFAULT NULL,
  `company_id` bigint unsigned DEFAULT NULL,
  `policy_type_id` bigint unsigned DEFAULT NULL,
  `total_policies_sold` int NOT NULL DEFAULT '0',
  `total_premium_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_commission_earned` decimal(12,2) NOT NULL DEFAULT '0.00',
  `average_policy_value` decimal(12,2) NOT NULL DEFAULT '0.00',
  `renewal_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  `client_acquisition_count` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_metric_date_agent_company_policy_type` (`metric_date`,`agent_id`,`company_id`,`policy_type_id`),
  KEY `performance_metrics_agent_id_foreign` (`agent_id`),
  KEY `performance_metrics_company_id_foreign` (`company_id`),
  KEY `performance_metrics_policy_type_id_foreign` (`policy_type_id`),
  CONSTRAINT `performance_metrics_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `performance_metrics_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `insurance_companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `performance_metrics_policy_type_id_foreign` FOREIGN KEY (`policy_type_id`) REFERENCES `policy_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.policies
CREATE TABLE IF NOT EXISTS `policies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `policy_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `policy_type_id` bigint unsigned NOT NULL,
  `agent_id` bigint unsigned NOT NULL,
  `policy_status` enum('ACTIVE','EXPIRED','CANCELLED','SUSPENDED','PENDING') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `premium_amount` decimal(12,2) NOT NULL,
  `sum_insured` decimal(15,2) NOT NULL,
  `coverage_details` json DEFAULT NULL,
  `issue_date` date NOT NULL,
  `effective_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `payment_frequency` enum('MONTHLY','QUARTERLY','SEMI_ANNUAL','ANNUAL') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` enum('CASH','CHEQUE','BANK_TRANSFER','MOBILE_MONEY','CARD') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CASH',
  `renewal_notice_sent` tinyint(1) NOT NULL DEFAULT '0',
  `renewal_notice_date` timestamp NULL DEFAULT NULL,
  `cancellation_date` date DEFAULT NULL,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `policies_policy_number_unique` (`policy_number`),
  KEY `policies_client_id_foreign` (`client_id`),
  KEY `policies_policy_type_id_foreign` (`policy_type_id`),
  KEY `policies_agent_id_foreign` (`agent_id`),
  KEY `idx_policies_created_at` (`created_at`),
  KEY `idx_policies_company_type` (`company_id`,`policy_type_id`),
  CONSTRAINT `policies_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `policies_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `policies_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `insurance_companies` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `policies_policy_type_id_foreign` FOREIGN KEY (`policy_type_id`) REFERENCES `policy_types` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.policy_renewals
CREATE TABLE IF NOT EXISTS `policy_renewals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `original_policy_id` bigint unsigned NOT NULL,
  `new_policy_id` bigint unsigned DEFAULT NULL,
  `renewal_date` date NOT NULL,
  `old_premium_amount` decimal(12,2) NOT NULL,
  `new_premium_amount` decimal(12,2) NOT NULL,
  `renewal_status` enum('PENDING','COMPLETED','DECLINED','LAPSED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `agent_id` bigint unsigned NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `policy_renewals_original_policy_id_foreign` (`original_policy_id`),
  KEY `policy_renewals_new_policy_id_foreign` (`new_policy_id`),
  KEY `policy_renewals_agent_id_foreign` (`agent_id`),
  CONSTRAINT `policy_renewals_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `policy_renewals_new_policy_id_foreign` FOREIGN KEY (`new_policy_id`) REFERENCES `policies` (`id`) ON DELETE SET NULL,
  CONSTRAINT `policy_renewals_original_policy_id_foreign` FOREIGN KEY (`original_policy_id`) REFERENCES `policies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.policy_types
CREATE TABLE IF NOT EXISTS `policy_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `policy_types_type_name_unique` (`type_name`),
  UNIQUE KEY `policy_types_type_code_unique` (`type_code`),
  KEY `policy_types_type_code_index` (`type_code`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for procedure dwin.SendRenewalReminders
DELIMITER //
CREATE PROCEDURE `SendRenewalReminders`()
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
END//
DELIMITER ;

-- Dumping structure for table dwin.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.system_settings
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_type` enum('STRING','INTEGER','DECIMAL','BOOLEAN','JSON') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'STRING',
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_system_setting` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_settings_setting_key_unique` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for procedure dwin.UpdateExpiredPolicies
DELIMITER //
CREATE PROCEDURE `UpdateExpiredPolicies`()
BEGIN
    UPDATE policies 
    SET policy_status = 'EXPIRED',
        updated_at = NOW()
    WHERE policy_status = 'ACTIVE' 
      AND expiry_date < CURDATE();
    
    SELECT ROW_COUNT() as policies_updated;
END//
DELIMITER ;

-- Dumping structure for table dwin.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint unsigned NOT NULL,
  `employee_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_reset_expires` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `full_name` varchar(101) COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (concat(`first_name`,_utf8mb4' ',`last_name`)) VIRTUAL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_employee_id_unique` (`employee_id`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_username_email_role_id_index` (`username`,`email`,`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table dwin.user_roles
CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `permissions` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_roles_role_name_unique` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for view dwin.v_active_policies
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_active_policies` (
	`id` BIGINT UNSIGNED NOT NULL,
	`policy_number` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`client_name` VARCHAR(1) NULL COLLATE 'utf8mb4_unicode_ci',
	`client_phone` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`policy_type` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`company_name` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`premium_amount` DECIMAL(12,2) NOT NULL,
	`sum_insured` DECIMAL(15,2) NOT NULL,
	`effective_date` DATE NOT NULL,
	`expiry_date` DATE NOT NULL,
	`days_to_expiry` INT NULL,
	`agent_name` VARCHAR(1) NULL COLLATE 'utf8mb4_unicode_ci'
) ENGINE=MyISAM;

-- Dumping structure for view dwin.v_client_summary
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_client_summary` (
	`id` BIGINT UNSIGNED NOT NULL,
	`client_code` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`full_name` VARCHAR(1) NULL COLLATE 'utf8mb4_unicode_ci',
	`phone_primary` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`email` VARCHAR(1) NULL COLLATE 'utf8mb4_unicode_ci',
	`client_status` ENUM('ACTIVE','INACTIVE','SUSPENDED') NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`kyc_status` ENUM('PENDING','VERIFIED','REJECTED') NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`total_policies` BIGINT NOT NULL,
	`active_policies` DECIMAL(23,0) NULL,
	`total_active_premium` DECIMAL(34,2) NULL,
	`last_policy_date` TIMESTAMP NULL,
	`assigned_agent` VARCHAR(1) NULL COLLATE 'utf8mb4_unicode_ci'
) ENGINE=MyISAM;

-- Dumping structure for view dwin.v_commission_summary
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_commission_summary` (
	`agent_id` BIGINT UNSIGNED NOT NULL,
	`agent_name` VARCHAR(1) NULL COLLATE 'utf8mb4_unicode_ci',
	`employee_id` VARCHAR(1) NULL COLLATE 'utf8mb4_unicode_ci',
	`company_name` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`policy_type` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`calculation_date` DATE NULL,
	`commission_count` BIGINT NOT NULL,
	`total_commission` DECIMAL(32,2) NULL,
	`avg_commission` DECIMAL(14,6) NULL,
	`payment_status` ENUM('PENDING','PAID','CANCELLED') NOT NULL COLLATE 'utf8mb4_unicode_ci'
) ENGINE=MyISAM;

-- Dumping structure for trigger dwin.clients_audit_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `clients_audit_insert` AFTER INSERT ON `clients` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, new_values, user_id)
    VALUES ('clients', NEW.id, 'INSERT',
           JSON_OBJECT('id', NEW.id, 'client_code', NEW.client_code, 
                      'first_name', NEW.first_name, 'last_name', NEW.last_name,
                      'phone_primary', NEW.phone_primary, 'email', NEW.email,
                      'client_status', NEW.client_status),
           @audit_user_id);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger dwin.clients_audit_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `clients_audit_update` AFTER UPDATE ON `clients` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, old_values, new_values, user_id)
    VALUES ('clients', NEW.id, 'UPDATE',
           JSON_OBJECT('client_code', OLD.client_code, 'first_name', OLD.first_name, 
                      'last_name', OLD.last_name, 'phone_primary', OLD.phone_primary,
                      'email', OLD.email, 'client_status', OLD.client_status),
           JSON_OBJECT('client_code', NEW.client_code, 'first_name', NEW.first_name, 
                      'last_name', NEW.last_name, 'phone_primary', NEW.phone_primary,
                      'email', NEW.email, 'client_status', NEW.client_status),
           @audit_user_id);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger dwin.commission_calculations_audit_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `commission_calculations_audit_insert` AFTER INSERT ON `commission_calculations` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, new_values, user_id)
    VALUES ('commission_calculations', NEW.id, 'INSERT',
           JSON_OBJECT('id', NEW.id, 'policy_id', NEW.policy_id, 'agent_id', NEW.agent_id,
                      'commission_amount', NEW.commission_amount, 'payment_status', NEW.payment_status),
           @audit_user_id);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger dwin.commission_calculations_audit_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `commission_calculations_audit_update` AFTER UPDATE ON `commission_calculations` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, old_values, new_values, user_id)
    VALUES ('commission_calculations', NEW.id, 'UPDATE',
           JSON_OBJECT('commission_amount', OLD.commission_amount, 'payment_status', OLD.payment_status),
           JSON_OBJECT('commission_amount', NEW.commission_amount, 'payment_status', NEW.payment_status),
           @audit_user_id);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger dwin.policies_audit_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `policies_audit_insert` AFTER INSERT ON `policies` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, new_values, user_id)
    VALUES ('policies', NEW.id, 'INSERT',
           JSON_OBJECT('id', NEW.id, 'policy_number', NEW.policy_number,
                      'client_id', NEW.client_id, 'company_id', NEW.company_id,
                      'policy_type_id', NEW.policy_type_id, 'agent_id', NEW.agent_id,
                      'premium_amount', NEW.premium_amount, 'policy_status', NEW.policy_status),
           @audit_user_id);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger dwin.policies_audit_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `policies_audit_update` AFTER UPDATE ON `policies` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, old_values, new_values, user_id)
    VALUES ('policies', NEW.id, 'UPDATE',
           JSON_OBJECT('policy_number', OLD.policy_number, 'client_id', OLD.client_id,
                      'premium_amount', OLD.premium_amount, 'policy_status', OLD.policy_status),
           JSON_OBJECT('policy_number', NEW.policy_number, 'client_id', NEW.client_id,
                      'premium_amount', NEW.premium_amount, 'policy_status', NEW.policy_status),
           @audit_user_id);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger dwin.users_audit_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `users_audit_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, new_values, user_id)
    VALUES ('users', NEW.id, 'INSERT', 
           JSON_OBJECT('id', NEW.id, 'username', NEW.username, 'email', NEW.email, 
                      'first_name', NEW.first_name, 'last_name', NEW.last_name,
                      'role_id', NEW.role_id, 'is_active', NEW.is_active),
           @audit_user_id);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger dwin.users_audit_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `users_audit_update` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, record_id, action_type, old_values, new_values, user_id)
    VALUES ('users', NEW.id, 'UPDATE',
           JSON_OBJECT('username', OLD.username, 'email', OLD.email, 
                      'first_name', OLD.first_name, 'last_name', OLD.last_name,
                      'role_id', OLD.role_id, 'is_active', OLD.is_active),
           JSON_OBJECT('username', NEW.username, 'email', NEW.email, 
                      'first_name', NEW.first_name, 'last_name', NEW.last_name,
                      'role_id', NEW.role_id, 'is_active', NEW.is_active),
           @audit_user_id);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_active_policies`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_active_policies` AS select `p`.`id` AS `id`,`p`.`policy_number` AS `policy_number`,`c`.`full_name` AS `client_name`,`c`.`phone_primary` AS `client_phone`,`pt`.`type_name` AS `policy_type`,`ic`.`company_name` AS `company_name`,`p`.`premium_amount` AS `premium_amount`,`p`.`sum_insured` AS `sum_insured`,`p`.`effective_date` AS `effective_date`,`p`.`expiry_date` AS `expiry_date`,(to_days(`p`.`expiry_date`) - to_days(curdate())) AS `days_to_expiry`,concat(`u`.`first_name`,' ',`u`.`last_name`) AS `agent_name` from ((((`policies` `p` join `clients` `c` on((`p`.`client_id` = `c`.`id`))) join `policy_types` `pt` on((`p`.`policy_type_id` = `pt`.`id`))) join `insurance_companies` `ic` on((`p`.`company_id` = `ic`.`id`))) join `users` `u` on((`p`.`agent_id` = `u`.`id`))) where (`p`.`policy_status` = 'ACTIVE');

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_client_summary`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_client_summary` AS select `c`.`id` AS `id`,`c`.`client_code` AS `client_code`,`c`.`full_name` AS `full_name`,`c`.`phone_primary` AS `phone_primary`,`c`.`email` AS `email`,`c`.`client_status` AS `client_status`,`c`.`kyc_status` AS `kyc_status`,count(`p`.`id`) AS `total_policies`,sum((case when (`p`.`policy_status` = 'ACTIVE') then 1 else 0 end)) AS `active_policies`,sum((case when (`p`.`policy_status` = 'ACTIVE') then `p`.`premium_amount` else 0 end)) AS `total_active_premium`,max(`p`.`created_at`) AS `last_policy_date`,concat(`u`.`first_name`,' ',`u`.`last_name`) AS `assigned_agent` from ((`clients` `c` left join `policies` `p` on((`c`.`id` = `p`.`client_id`))) left join `users` `u` on((`c`.`assigned_agent_id` = `u`.`id`))) group by `c`.`id`,`c`.`client_code`,`c`.`full_name`,`c`.`phone_primary`,`c`.`email`,`c`.`client_status`,`c`.`kyc_status`,`assigned_agent`;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_commission_summary`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_commission_summary` AS select `cc`.`agent_id` AS `agent_id`,concat(`u`.`first_name`,' ',`u`.`last_name`) AS `agent_name`,`u`.`employee_id` AS `employee_id`,`ic`.`company_name` AS `company_name`,`pt`.`type_name` AS `policy_type`,cast(`cc`.`calculation_date` as date) AS `calculation_date`,count(0) AS `commission_count`,sum(`cc`.`commission_amount`) AS `total_commission`,avg(`cc`.`commission_amount`) AS `avg_commission`,`cc`.`payment_status` AS `payment_status` from ((((`commission_calculations` `cc` join `users` `u` on((`cc`.`agent_id` = `u`.`id`))) join `insurance_companies` `ic` on((`cc`.`company_id` = `ic`.`id`))) join `policies` `p` on((`cc`.`policy_id` = `p`.`id`))) join `policy_types` `pt` on((`p`.`policy_type_id` = `pt`.`id`))) group by `cc`.`agent_id`,`agent_name`,`u`.`employee_id`,`ic`.`company_name`,`pt`.`type_name`,cast(`cc`.`calculation_date` as date),`cc`.`payment_status`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
