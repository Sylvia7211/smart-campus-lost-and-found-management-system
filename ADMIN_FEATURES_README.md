# Admin Dashboard & Claims Verification System

## 🎯 Overview
This document outlines the enhanced admin dashboard with claims verification, user management, and reporting features, plus the new OTP and QR code verification system for users.

---

## 📦 Required Setup

### 1. Database Updates
Run the SQL update script to add new columns and tables:

```sql
-- Execute this file:
database/update_claims_schema.sql
```

This adds:
- OTP verification columns
- QR code verification columns
- Admin notes field
- Claim verification logs table

### 2. PHP QR Code Library Installation

**Option A: Download Manually**
1. Download PHP QRCode library from: https://github.com/t0k4rt/phpqrcode
2. Extract to: `vendor/phpqrcode/`
3. Ensure `qrlib.php` exists at: `vendor/phpqrcode/qrlib.php`

**Option B: Using Composer** (if available)
```bash
composer require phpqrcode/phpqrcode
```

### 3. Create Required Directories
```bash
mkdir assets/qrcodes
chmod 777 assets/qrcodes
```

---

## 🛡️ Admin Dashboard Features

### **1. Claims Management** (`admin/pages/claims.php`)

#### Features:
- View all claims (pending, approved, rejected)
- Filter claims by status
- View detailed claim information in modal
- Approve/reject claims with admin notes
- See verification status (OTP, QR Code)
- Track claim submission dates

#### Claim Details Include:
- Claimant information (name, email, phone, reg number)
- Item information (name, category, type, location, date)
- Item image
- Claimant's detailed description
- Verification status indicators
- Admin notes

#### Actions:
- **Approve Claim**: Marks claim as approved, sends notification to user
- **Reject Claim**: Marks claim as rejected with optional reason
- **View Details**: Opens modal with complete claim information

---

### **2. User Management** (`admin/pages/users.php`)

Currently displays:
- User ID
- Full name
- Email
- Phone
- Role (student/admin)
- Registration date

#### Future Enhancements:
- Edit user details
- Change user role
- Suspend/activate accounts
- View user activity
- Reset passwords

---

### **3. Reports & Analytics** (`admin/pages/reports.php`)

#### Current Statistics:
- Total users count
- Total lost items
- Total found items
- Total claims

#### Breakdowns:
- Lost items by status
- Claims by status
- Top 5 lost item categories

#### Future Enhancements:
- Date range filtering
- Export to PDF/CSV
- Charts and graphs
- Success rate tracking
- Response time analytics

---

## 👥 User Claims System

### **Step 1: Submit Claim** (`claims/claim_item.php`)

#### User Provides:
1. **Detailed Item Description**
   - Unique features or marks
   - Color, brand, model
   - Contents (for bags/wallets)
   - Serial numbers
   - Any identifiable characteristics

2. **Contact Information**
   - Phone number
   - Email address

#### Validation:
- Description is required and must be detailed
- Contact info must be valid
- Item must exist and be available

---

### **Step 2: OTP Verification** (`claims/verify_claim.php`)

#### Process:
1. System generates 6-digit OTP
2. OTP sent to user's email (expires in 15 minutes)
3. User enters OTP to verify email
4. Upon successful verification:
   - OTP marked as verified
   - QR code automatically generated
   - User can download/print QR code

#### OTP Features:
- 6-digit numeric code
- 15-minute expiration
- Resend option available
- Secure validation

---

### **Step 3: QR Code Generation**

#### QR Code Contains:
```
CLAIM:{claim_id}:USER:{user_id}:TIME:{timestamp}
```

#### User Options:
- View QR code on screen
- Print QR code
- Download QR code image
- Save for later use

---

### **Step 4: Admin Review**

1. Admin views claim in dashboard
2. Reviews claimant's description
3. Compares with item description
4. Checks verification status (OTP ✓, QR Code ✓)
5. Approves or rejects with notes

---

### **Step 5: Item Collection**

#### When Approved:
1. User receives approval notification
2. User brings QR code to collection point
3. Admin scans QR code (future feature)
4. QR validated and item released
5. Claim marked as completed

---

## 📋 API Endpoints

### `api/process_claim.php`
- **Method**: POST
- **Auth**: Admin only
- **Purpose**: Approve or reject claims
- **Body**:
  ```json
  {
    "claim_id": 123,
    "action": "Approved", // or "Rejected"
    "notes": "Optional admin notes"
  }
  ```

### `api/get_claim_details.php`
- **Method**: GET
- **Auth**: Admin only
- **Purpose**: Fetch complete claim details
- **Query**: `?claim_id=123`
- **Returns**: HTML content for modal

---

## 🔐 Security Features

### Claims Security:
- ✅ Only logged-in users can submit claims
- ✅ Users can only claim items not owned by them
- ✅ OTP expires after 15 minutes
- ✅ QR code is unique per claim
- ✅ Admin-only access to approve/reject
- ✅ All actions logged in verification table

### Admin Security:
- ✅ `requireAdmin()` middleware on all pages
- ✅ Session validation
- ✅ Role checking
- ✅ SQL injection prevention (prepared statements)
- ✅ XSS protection (htmlspecialchars)

---

## 📊 Database Schema Updates

### Claims Table (Updated):
```sql
- claim_description TEXT        -- Detailed item description
- otp_code VARCHAR(6)           -- 6-digit OTP
- otp_expires_at DATETIME       -- OTP expiration time
- otp_verified TINYINT(1)       -- OTP verification status
- qr_code VARCHAR(255)          -- QR code filename
- qr_verified TINYINT(1)        -- QR verification status
- admin_notes TEXT              -- Admin review notes
- verified_at DATETIME          -- Verification timestamp
```

### Claim_Verification_Logs (New):
```sql
- id INT PRIMARY KEY
- claim_id INT
- verification_type ENUM('OTP', 'QR_Code', 'Admin')
- verified_by INT
- status ENUM('Success', 'Failed')
- notes TEXT
- created_at TIMESTAMP
```

---

## 🎨 UI/UX Improvements

### Admin Dashboard:
- Modern card-based layout
- Status badges with color coding
- Filter buttons for quick sorting
- Modal popups for detailed views
- Responsive design
- Loading states
- Success/error feedback

### User Verification:
- Step-by-step process
- Visual progress indicators
- Clear instructions
- Large OTP input field
- QR code display
- Print/download options
- Mobile-friendly design

---

## 🚀 Future Enhancements

### Admin Features:
- [ ] Real-time QR code scanner
- [ ] Bulk claim actions
- [ ] Advanced filtering and search
- [ ] Email notification system
- [ ] SMS notifications
- [ ] Activity dashboard with charts
- [ ] Export reports to PDF/Excel

### User Features:
- [ ] Email OTP delivery (currently development mode)
- [ ] SMS OTP as alternative
- [ ] Claim status tracking
- [ ] In-app notifications
- [ ] Claim history
- [ ] Rate found items/users

---

## 📱 Testing Instructions

### Test Admin Claims Management:
1. Login as admin
2. Go to Admin Dashboard → Claims
3. View pending claims
4. Click "View Details" to see full information
5. Approve or reject with notes
6. Verify notification sent to user

### Test User Claim Flow:
1. Login as regular user
2. Search for an item
3. Click "Claim This Item"
4. Fill detailed description
5. Submit claim
6. Enter OTP (check development alert or notifications)
7. View generated QR code
8. Download/print QR code
9. Check "My Claims" page for status

---

## ⚠️ Important Notes

1. **OTP Email**: Currently in development mode showing OTP on screen. Integrate with email service (PHPMailer, SendGrid, etc.) for production.

2. **QR Library**: Ensure PHP QR Code library is installed before testing QR generation.

3. **File Permissions**: `assets/qrcodes/` directory must be writable (chmod 777).

4. **Database**: Run the update schema SQL file before using new features.

5. **Testing**: Use development mode to see OTP codes. In production, remove the debug display.

---

## 📞 Support

For issues or questions:
- Check database connection
- Verify file permissions
- Review PHP error logs
- Ensure all SQL updates are applied
- Confirm QR library is installed

---

## ✅ Checklist

Before going live:
- [ ] Run `update_claims_schema.sql`
- [ ] Install PHP QR Code library
- [ ] Create `assets/qrcodes` directory
- [ ] Configure email service for OTP
- [ ] Test complete claim flow
- [ ] Test admin approval/rejection
- [ ] Verify QR code generation
- [ ] Check all permissions
- [ ] Remove development OTP display
- [ ] Test on mobile devices

---

**Last Updated**: <?php echo date('F d, Y'); ?>
**Version**: 2.0
