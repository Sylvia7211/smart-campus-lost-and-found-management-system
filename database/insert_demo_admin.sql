-- ==========================================
-- INSERT DEMO ADMIN USER
-- ==========================================

USE smartcampus;

-- Insert demo admin user
-- Email: admin@gmail.com
-- Password: Admin@321
-- The password is hashed using PHP password_hash() with PASSWORD_DEFAULT (bcrypt)

INSERT INTO Users (full_name, reg_number, email, phone, password, role, created_at) 
VALUES (
    'System Administrator',
    'ADM/2024/001',
    'admin@gmail.com',
    '+254 700 000 000',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- Password: Admin@321
    'admin',
    NOW()
);

-- Verify the admin was created
SELECT id, full_name, email, role, created_at 
FROM Users 
WHERE email = 'admin@gmail.com';

-- ==========================================
-- IMPORTANT NOTES:
-- ==========================================
-- 1. This creates an admin account with credentials:
--    Email: admin@gmail.com
--    Password: Admin@321
--
-- 2. Change the password immediately after first login
--
-- 3. For security, delete or disable this account in production
--
-- 4. To manually hash a new password in PHP:
--    <?php echo password_hash('YourPassword', PASSWORD_DEFAULT); ?>
--
-- ==========================================
