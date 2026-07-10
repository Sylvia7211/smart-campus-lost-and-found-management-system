-- ==========================================
-- UPDATE CLAIMS TABLE FOR OTP & QR VERIFICATION
-- ==========================================

USE smartcampus;

-- Add new columns to Claims table
ALTER TABLE Claims
ADD COLUMN claim_description TEXT AFTER claim_message,
ADD COLUMN otp_code VARCHAR(6) DEFAULT NULL,
ADD COLUMN otp_expires_at DATETIME DEFAULT NULL,
ADD COLUMN otp_verified TINYINT(1) DEFAULT 0,
ADD COLUMN qr_code VARCHAR(255) DEFAULT NULL,
ADD COLUMN qr_verified TINYINT(1) DEFAULT 0,
ADD COLUMN admin_notes TEXT DEFAULT NULL,
ADD COLUMN verified_at DATETIME DEFAULT NULL;

-- Create table for claim verification logs
CREATE TABLE IF NOT EXISTS Claim_Verification_Logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    claim_id INT NOT NULL,
    verification_type ENUM('OTP', 'QR_Code', 'Admin') NOT NULL,
    verified_by INT NULL,
    status ENUM('Success', 'Failed') NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (claim_id) REFERENCES Claims(id) ON DELETE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES Users(id) ON DELETE SET NULL
);

-- Add index for faster queries
CREATE INDEX idx_claims_status ON Claims(status);
CREATE INDEX idx_claims_otp ON Claims(otp_code, otp_expires_at);
