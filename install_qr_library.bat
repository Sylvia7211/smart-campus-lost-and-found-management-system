@echo off
echo ============================================
echo  Smart Campus - QR Library Installation
echo ============================================
echo.

REM Create vendor directory
if not exist "vendor" mkdir vendor
if not exist "vendor\phpqrcode" mkdir vendor\phpqrcode

echo Downloading PHP QR Code library...
echo.
echo Please download manually from:
echo https://github.com/t0k4rt/phpqrcode/archive/refs/heads/master.zip
echo.
echo Extract the contents to: vendor\phpqrcode\
echo.
echo The main file should be at: vendor\phpqrcode\qrlib.php
echo.

REM Create QR codes directory
if not exist "assets\qrcodes" mkdir assets\qrcodes
echo Created assets\qrcodes directory
echo.

echo ============================================
echo  Installation Instructions:
echo ============================================
echo 1. Download from the URL above
echo 2. Extract phpqrcode-master.zip
echo 3. Copy all .php files to vendor\phpqrcode\
echo 4. Ensure qrlib.php exists in vendor\phpqrcode\
echo 5. Run the SQL update: database\update_claims_schema.sql
echo.
echo ============================================
pause
