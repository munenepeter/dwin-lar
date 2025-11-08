CREATE PROCEDURE GetExpiringPoliciesReport(
    IN days_ahead INT
)
BEGIN
    SELECT
        p.policy_number,
        c.full_name AS client_name,
        c.phone_primary,
        pt.type_name AS policy_type,
        ic.company_name,
        p.expiry_date,
        DATEDIFF(p.expiry_date, CURDATE()) AS days_to_expiry,
        u.full_name AS agent_name
    FROM policies p
    JOIN clients c ON p.client_id = c.id
    JOIN policy_types pt ON p.policy_type_id = pt.id
    JOIN insurance_companies ic ON p.company_id = ic.id
    JOIN users u ON p.agent_id = u.id
    WHERE p.expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL days_ahead DAY)
      AND p.status = 'active'
    ORDER BY p.expiry_date;
END


CREATE PROCEDURE GetOutstandingCommissions()
BEGIN
    SELECT
        u.full_name AS agent_name,
        u.employee_id,
        COUNT(cc.id) AS pending_calculations,
        SUM(cc.commission_earned) AS total_outstanding,
        MIN(cc.calculation_date) AS oldest_calculation,
        MAX(cc.calculation_date) AS newest_calculation
    FROM commission_calculations cc
    JOIN users u ON cc.agent_id = u.id
    WHERE cc.is_paid = 0
    GROUP BY u.full_name, u.employee_id
    ORDER BY total_outstanding DESC;
END


CREATE PROCEDURE GetAgentPerformanceReport(
    IN agent_id INT,
    IN start_date DATE,
    IN end_date DATE
)
BEGIN
    SELECT
        DATE(p.sale_date) AS sale_date,
        COUNT(p.id) AS policies_sold,
        SUM(p.premium_amount) AS total_premium,
        AVG(p.premium_amount) AS avg_premium,
        SUM(cc.commission_earned) AS total_commission,
        COUNT(DISTINCT p.client_id) AS unique_clients
    FROM policies p
    JOIN commission_calculations cc ON p.id = cc.policy_id
    WHERE p.agent_id = agent_id
      AND p.sale_date BETWEEN start_date AND end_date
    GROUP BY DATE(p.sale_date)
    ORDER BY DATE(p.sale_date);
END

