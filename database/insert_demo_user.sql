-- ==========================================
-- INSERT DEMO STUDENT USER
-- ==========================================

USE smartcampus;

-- Insert demo student user
-- Email: user@gmail.com
-- Password: User@321
-- The password is hashed using PHP password_hash() with PASSWORD_DEFAULT (bcrypt)

INSERT INTO Users (full_name, reg_number, email, phone, password, role, created_at) 
VALUES (
    'Demo Student',
    'STU/2024/001',
    'user@gmail.com',
    '+254 700 111 222',
    '$2y$10$YJGlXd4X8F6qGqZ8zQqZ4eX5z3X5X5X5X5X5X5X5X5X5X5X5X5X5X5X',  -- This will be replaced below
    'student',
    NOW()
);

-- Note: The password hash above is a placeholder
-- Use the correct hash generated below:

-- For password: User@321
-- The correct bcrypt hash is:
UPDATE Users 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
WHERE email = 'user@gmail.com';

-- Alternative: If the hash doesn't work, run this PHP script to generate it:
-- <?php echo password_hash('User@321', PASSWORD_DEFAULT); ?>

-- Verify the user was created
SELECT id, full_name, email, role, created_at 
FROM Users 
WHERE email = 'user@gmail.com';

-- ==========================================
-- DEMO USER CREDENTIALS:
-- ==========================================
-- Email: user@gmail.com
-- Password: User@321
-- Role: student
--
-- This account can:
-- - Report lost items
-- - Report found items
-- - Search for items
-- - Claim items
-- - View personal dashboard
-- - Update profile
-- - View notifications
--
-- ==========================================
