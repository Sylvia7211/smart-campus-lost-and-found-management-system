PHP QR Code Library Path Configuration
========================================

The QR code library is located at:
vendor/phpqrcode/phpqrcode-master/qrlib.php

To use it in your PHP files:
require_once '../vendor/phpqrcode/phpqrcode-master/qrlib.php';

Or from root directory:
require_once './vendor/phpqrcode/phpqrcode-master/qrlib.php';

Files currently using this library:
- claims/verify_claim.php

Example usage:
QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize);

Parameters:
- $data: The data to encode in the QR code
- $filename: Output filename (full path)
- $errorCorrectionLevel: QR_ECLEVEL_L, QR_ECLEVEL_M, QR_ECLEVEL_Q, or QR_ECLEVEL_H
- $matrixPointSize: Size of QR code (1-10, default 3)

Example:
$data = "CLAIM:123:USER:456:TIME:1234567890";
$file = "../assets/qrcodes/claim_123.png";
QRcode::png($data, $file, QR_ECLEVEL_L, 10);
