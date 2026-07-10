# 🔐 Demo Accounts Credentials

Quick reference for demo accounts in the Smart Campus system.

---

## 👤 Demo Accounts

### 1. **Admin Account**

| Field | Value |
|-------|-------|
| **Role** | Administrator |
| **Email** | `admin@gmail.com` |
| **Password** | `Admin@321` |
| **Reg Number** | `ADM/2024/001` |
| **Name** | System Administrator |
| **Phone** | +254 700 000 000 |

#### Admin Capabilities:
✅ View all users
✅ Verify and approve/reject claims
✅ View all lost items
✅ View all found items
✅ Generate system reports
✅ Manage user accounts
✅ Access admin dashboard
✅ View claim descriptions (private)

#### Access Admin Dashboard:
1. Login with admin credentials
2. You'll be redirected to: `/admin/dashboard.php`

---

### 2. **Student Account**

| Field | Value |
|-------|-------|
| **Role** | Student |
| **Email** | `user@gmail.com` |
| **Password** | `User@321` |
| **Reg Number** | `STU/2024/001` |
| **Name** | Demo Student |
| **Phone** | +254 700 111 222 |

#### Student Capabilities:
✅ Report lost items
✅ Report found items
✅ Search for items
✅ Claim items (with OTP verification)
✅ Generate QR codes for claims
✅ View personal dashboard
✅ Update profile
✅ View notifications
✅ Track claim status

#### Access Student Dashboard:
1. Login with student credentials
2. You'll be redirected to: `/dashboard/dashboard.php`

---

## 🚀 Quick Setup

### Method 1: Using PHP Scripts (Recommended)

#### Create Admin:
```
http://localhost/smart-campus-lost-and-found-management-system/database/create_admin.php
```

#### Create Student:
```
http://localhost/smart-campus-lost-and-found-management-system/database/create_demo_user.php
```

After running each script, **delete the file** for security!

---

### Method 2: Using SQL Files

Run these SQL files in phpMyAdmin or MySQL command line:

#### Create Admin:
```sql
-- File: database/insert_demo_admin.sql
USE smartcampus;
SOURCE database/insert_demo_admin.sql;
```

#### Create Student:
```sql
-- File: database/insert_demo_user.sql
USE smartcampus;
SOURCE database/insert_demo_user.sql;
```

---

## 🧪 Testing Scenarios

### Scenario 1: Student Reports Lost Item
1. Login as: `user@gmail.com`
2. Click "Report Lost Item"
3. Fill in item details
4. Submit report
5. View in "My Lost Items"

### Scenario 2: Admin Views Lost Items
1. Login as: `admin@gmail.com`
2. Go to "Lost Items" section
3. View all reported lost items
4. See student's reported item

### Scenario 3: Claim Verification Flow
1. **Student** searches and finds an item
2. Click "Claim This Item"
3. Provide detailed description
4. Submit claim
5. Enter OTP (shown on screen in dev mode)
6. QR code is generated
7. Download/print QR code
8. **Admin** reviews claim in Admin Dashboard
9. Admin approves/rejects with notes
10. Student receives notification
11. Student collects item with QR code

---

## 🔒 Security Notes

### ⚠️ Before Production:

1. **Change All Passwords**
   - Use strong, unique passwords
   - Minimum 12 characters
   - Mix of uppercase, lowercase, numbers, symbols

2. **Delete Demo Accounts**
   ```sql
   DELETE FROM Users WHERE email IN ('admin@gmail.com', 'user@gmail.com');
   ```

3. **Delete Setup Files**
   - `database/create_admin.php`
   - `database/create_demo_user.php`
   - `database/insert_demo_admin.sql`
   - `database/insert_demo_user.sql`
   - `DEMO_CREDENTIALS.md` (this file)

4. **Enable Production Mode**
   - Configure real email service for OTP
   - Remove development OTP display
   - Enable HTTPS
   - Set proper file permissions

---

## 🎯 Login URLs

### Main Login Page:
```
http://localhost/smart-campus-lost-and-found-management-system/authentication/login.php
```

### Landing Page:
```
http://localhost/smart-campus-lost-and-found-management-system/
```

### Student Dashboard:
```
http://localhost/smart-campus-lost-and-found-management-system/dashboard/dashboard.php
```

### Admin Dashboard:
```
http://localhost/smart-campus-lost-and-found-management-system/admin/dashboard.php
```

---

## 📊 Account Comparison

| Feature | Student Account | Admin Account |
|---------|----------------|---------------|
| Report Lost Items | ✅ Yes | ✅ Yes |
| Report Found Items | ✅ Yes | ✅ Yes |
| Search Items | ✅ Yes | ✅ Yes |
| Claim Items | ✅ Yes | ❌ No |
| View Own Items | ✅ Yes | ✅ Yes |
| View All Items | ❌ No | ✅ Yes |
| Manage Claims | ❌ No | ✅ Yes |
| Approve/Reject Claims | ❌ No | ✅ Yes |
| View All Users | ❌ No | ✅ Yes |
| Generate Reports | ❌ No | ✅ Yes |
| Access Admin Panel | ❌ No | ✅ Yes |

---

## 🆘 Troubleshooting

### "Invalid email or password"
- Ensure credentials are typed correctly (case-sensitive)
- Check if user exists: `SELECT * FROM Users WHERE email = 'user@gmail.com';`
- Verify password hash is correct

### "User not found"
- Run the create user scripts
- Check database connection
- Verify `Users` table exists

### "Access denied"
- Check user role in database
- Admin routes require `role = 'admin'`
- Student routes require `role = 'student'`

---

## 💡 Pro Tips

1. **Testing Claims**: Use student account to claim items, admin account to verify
2. **Multiple Students**: Create more student accounts by changing email/reg number
3. **Password Reset**: Currently requires database update, implement forgot password feature
4. **Backup**: Export database before testing destructive operations

---

## 📞 Quick Command Reference

### Check if accounts exist:
```sql
SELECT id, full_name, email, role FROM Users 
WHERE email IN ('admin@gmail.com', 'user@gmail.com');
```

### Reset admin password:
```sql
UPDATE Users 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
WHERE email = 'admin@gmail.com';
-- Password: Admin@321
```

### Reset student password:
```sql
UPDATE Users 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
WHERE email = 'user@gmail.com';
-- Password: User@321
```

---

**Last Updated**: January 2025
**System Version**: 2.0

**⚠️ IMPORTANT**: Delete this file before deploying to production!
