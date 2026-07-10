# 🚀 Smart Campus Setup Guide

Complete setup instructions for the Smart Campus Lost & Found Management System.

---

## 📋 Prerequisites

- ✅ XAMPP (or similar) with PHP 7.4+ and MySQL
- ✅ Web browser (Chrome, Firefox, Edge, Safari)
- ✅ Basic knowledge of running SQL scripts

---

## 🔧 Step-by-Step Setup

### **Step 1: Database Setup**

#### Option A: Using phpMyAdmin (Recommended)

1. Open **phpMyAdmin**: `http://localhost/phpmyadmin`

2. Create the database:
   - Click "New" in the sidebar
   - Database name: `smartcampus`
   - Collation: `utf8_general_ci`
   - Click "Create"

3. Import the base schema:
   - Select `smartcampus` database
   - Click "Import" tab
   - Choose file: `database/smartcampus.sql`
   - Click "Go"
   - ✅ Base tables created!

4. Apply claims update:
   - Still in Import tab
   - Choose file: `database/update_claims_schema.sql`
   - Click "Go"
   - ✅ Claims verification features added!

#### Option B: Using MySQL Command Line

```bash
# Navigate to your project directory
cd C:\Xamm\htdocs\smart-campus-lost-and-found-management-system

# Login to MySQL
mysql -u root -p

# Create and setup database
CREATE DATABASE smartcampus;
USE smartcampus;
SOURCE database/smartcampus.sql;
SOURCE database/update_claims_schema.sql;
EXIT;
```

---

### **Step 2: Create Admin User**

#### Option A: Run PHP Script (Easiest)

1. Open browser and navigate to:
   ```
   http://localhost/smart-campus-lost-and-found-management-system/database/create_admin.php
   ```

2. You'll see a success message with credentials:
   - **Email**: `admin@gmail.com`
   - **Password**: `Admin@321`

3. **Important**: Delete the file after use:
   ```
   database/create_admin.php
   ```

#### Option B: Run SQL Script

1. In phpMyAdmin, select `smartcampus` database
2. Click "SQL" tab
3. Copy and paste contents from: `database/insert_demo_admin.sql`
4. Click "Go"

Or via command line:
```bash
mysql -u root -p smartcampus < database/insert_demo_admin.sql
```

---

### **Step 3: Install PHP QR Code Library**

The system needs this library for QR code generation during claims verification.

#### Download & Install:

1. Download from: https://github.com/t0k4rt/phpqrcode/archive/refs/heads/master.zip

2. Extract the ZIP file

3. Copy all `.php` files to:
   ```
   smart-campus-lost-and-found-management-system/vendor/phpqrcode/
   ```

4. Verify `qrlib.php` exists at:
   ```
   vendor/phpqrcode/qrlib.php
   ```

#### Alternative: Use the batch file

Double-click: `install_qr_library.bat` (Windows only)
- It will guide you through the installation

---

### **Step 4: Create Required Directories**

Create the directory for storing QR codes:

```bash
# Navigate to your project root
cd C:\Xamm\htdocs\smart-campus-lost-and-found-management-system

# Create directory
mkdir assets\qrcodes
```

Or create manually:
- Right-click in `assets` folder
- New → Folder
- Name it: `qrcodes`

---

### **Step 5: Configure Database Connection** (if needed)

The system should work with default XAMPP settings. If you changed MySQL credentials:

Edit: `config/database.php`

```php
$host = "localhost";
$username = "root";        // Your MySQL username
$password = "";            // Your MySQL password
$database = "smartcampus";
```

---

## ✅ Verification Checklist

Before testing, verify:

- [ ] Database `smartcampus` created
- [ ] Tables created (Users, Lost_Items, Found_Items, Claims, etc.)
- [ ] Claims table has OTP and QR columns
- [ ] Admin user exists (email: admin@gmail.com)
- [ ] PHP QR library installed at `vendor/phpqrcode/qrlib.php`
- [ ] Directory `assets/qrcodes` exists
- [ ] XAMPP Apache and MySQL are running

---

## 🎯 Testing the System

### **Test 1: Landing Page**

1. Navigate to: `http://localhost/smart-campus-lost-and-found-management-system/`
2. You should see:
   - Hero carousel with 3 slides
   - Features section
   - About section
   - How It Works section
   - Login and Register buttons

✅ **Success**: Landing page displays correctly

---

### **Test 2: Admin Login**

1. Click "Login" button
2. Enter credentials:
   - **Email**: `admin@gmail.com`
   - **Password**: `Admin@321`
3. Click "Login"

✅ **Success**: Redirected to Admin Dashboard

---

### **Test 3: Admin Dashboard**

After logging in as admin, verify:

1. **Sidebar Navigation** shows:
   - Dashboard
   - Users
   - Lost Items
   - Found Items
   - Claims
   - Reports

2. **Dashboard Page** shows:
   - Statistics cards (Users, Lost Items, Found Items, Claims)
   - Recent Lost Items table
   - Recent Found Items table

3. Click through each section:
   - **Users**: View all registered users
   - **Lost Items**: View all reported lost items
   - **Found Items**: View all found items
   - **Claims**: Claims management (should be empty initially)
   - **Reports**: System statistics and analytics

✅ **Success**: All admin pages load without errors

---

### **Test 4: Student Registration**

1. Logout from admin
2. Click "Register" on landing page
3. Fill the form:
   - Full Name: `John Doe`
   - Reg Number: `STU/2024/001`
   - Email: `student@test.com`
   - Phone: `+254 700 111 222`
   - Password: `Student@123`
   - Confirm Password: `Student@123`
4. Click "Create Account"

✅ **Success**: Redirected to login page with success message

---

### **Test 5: Student Login & Dashboard**

1. Login with student credentials
2. You should see the student dashboard with:
   - Stats cards
   - Quick action buttons
   - Recent lost items
   - Recent found items
   - Sidebar with navigation

✅ **Success**: Student dashboard displays correctly

---

### **Test 6: Report Lost Item**

1. As student, click "Report Lost Item" in sidebar
2. Fill the form:
   - Item Name: `Blue Laptop`
   - Category: `Electronics`
   - Description: `Dell Inspiron 15, silver color`
   - Location Lost: `Library`
   - Date Lost: (today's date)
   - Reward: `1000`
   - Upload Image: (optional)
3. Click "Submit Report"

✅ **Success**: Item reported, redirected to "My Lost Items"

---

### **Test 7: Report Found Item**

1. Click "Report Found Item"
2. Fill similar details
3. Submit

✅ **Success**: Found item reported

---

### **Test 8: Search Items**

1. Click "Search" in sidebar
2. Enter search term: `laptop`
3. Click "Search"
4. Results should show matching items

✅ **Success**: Search returns results

---

### **Test 9: Claim Item (Full Verification Flow)**

1. From search results, click "Claim This Item"
2. Provide detailed description
3. Submit claim
4. **OTP Page** appears:
   - In development mode, OTP shows on screen
   - Enter the 6-digit OTP
   - Click "Verify OTP"
5. **QR Code** generates automatically
   - You can view, print, or download it

✅ **Success**: Claim submitted with OTP and QR code

---

### **Test 10: Admin Claim Verification**

1. Login as admin
2. Go to Claims section
3. You should see the pending claim
4. Click "View Details"
5. Review the claim information
6. Click "Approve" or "Reject"
7. Add optional notes
8. Confirm action

✅ **Success**: Claim processed, notification sent

---

### **Test 11: Profile Management**

1. As any user, click "Profile"
2. Update information:
   - Change name, phone, etc.
   - Update password (optional)
3. Click "Update Profile"

✅ **Success**: Profile updated

---

### **Test 12: Notifications**

1. Click "Notifications" in sidebar
2. View any system notifications
3. Mark as read

✅ **Success**: Notifications display

---

## 🐛 Troubleshooting

### **Error: "Database connection failed"**
- ✅ Check XAMPP MySQL is running
- ✅ Verify credentials in `config/database.php`
- ✅ Ensure database `smartcampus` exists

### **Error: "Table doesn't exist"**
- ✅ Run `database/smartcampus.sql`
- ✅ Run `database/update_claims_schema.sql`

### **Error: "Admin login fails"**
- ✅ Run `database/insert_demo_admin.sql` or `create_admin.php`
- ✅ Password is case-sensitive: `Admin@321`

### **Error: "QR code not generating"**
- ✅ Install PHP QR library at `vendor/phpqrcode/`
- ✅ Ensure `qrlib.php` exists
- ✅ Check `assets/qrcodes` directory exists

### **Error: "Call to undefined function QRcode::png()"**
- ✅ PHP QR library not installed correctly
- ✅ Check the path: `vendor/phpqrcode/qrlib.php`

### **Error: "Failed to open stream" or "Permission denied"**
- ✅ Check file permissions on `assets/qrcodes`
- ✅ On Windows, right-click folder → Properties → Security → Full Control

### **Images not displaying**
- ✅ Check `assets/uploads/lost/` and `assets/uploads/found/` directories exist
- ✅ Verify image paths in database

---

## 🔐 Security Recommendations

### **Before Production:**

1. **Change Admin Password**
   - Login as admin
   - Go to Profile
   - Update password to something secure

2. **Delete Setup Files**
   ```
   database/create_admin.php
   database/insert_demo_admin.sql
   install_qr_library.bat
   SETUP_GUIDE.md (this file)
   ```

3. **Configure Email Service**
   - Update OTP email sending in `claims/verify_claim.php`
   - Use PHPMailer, SendGrid, or SMTP

4. **Update Database Credentials**
   - Change MySQL root password
   - Update `config/database.php`

5. **Enable HTTPS**
   - Get SSL certificate
   - Force HTTPS in production

6. **Set Proper File Permissions**
   - Restrict write access to upload directories
   - Protect config files

---

## 📞 Support

### **Common Commands:**

**Start XAMPP:**
- Open XAMPP Control Panel
- Start Apache
- Start MySQL

**Access Project:**
```
http://localhost/smart-campus-lost-and-found-management-system/
```

**Access phpMyAdmin:**
```
http://localhost/phpmyadmin
```

**Default Admin Credentials:**
- Email: `admin@gmail.com`
- Password: `Admin@321`

---

## 📚 Additional Documentation

- **Admin Features**: Read `ADMIN_FEATURES_README.md`
- **Database Schema**: See `database/smartcampus.sql`
- **API Endpoints**: Check `api/` directory

---

## ✨ Quick Reference

| Feature | URL |
|---------|-----|
| Landing Page | `/index.php` |
| Login | `/authentication/login.php` |
| Register | `/authentication/register.php` |
| Student Dashboard | `/dashboard/dashboard.php` |
| Admin Dashboard | `/admin/dashboard.php` |
| Create Admin | `/database/create_admin.php` |

---

**Setup Complete!** 🎉

Your Smart Campus Lost & Found Management System is now ready to use!

**Next Steps:**
1. Test all features
2. Create some demo data
3. Customize as needed
4. Deploy to production (with security measures)

---

**Last Updated**: January 2025
**Version**: 2.0
