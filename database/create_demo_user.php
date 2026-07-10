<?php
/**
 * Create Demo Student User
 * 
 * Run this file once to create the demo student account:
 * http://localhost/smart-campus-lost-and-found-management-system/database/create_demo_user.php
 * 
 * Then delete this file for security!
 */

require_once "../config/database.php";

// Student user credentials
$full_name = "Demo Student";
$reg_number = "STU/2024/001";
$email = "user@gmail.com";
$phone = "+254 700 111 222";
$password = "User@321";
$role = "student";

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Create Demo Student User</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css' rel='stylesheet'>
    <style>
        body { background: linear-gradient(135deg, #06d6a0 0%, #1a9960 100%); min-height: 100vh; display: flex; align-items: center; }
        .container { max-width: 600px; }
        .card { border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); }
    </style>
</head>
<body>
    <div class='container'>
        <div class='card'>
            <div class='card-header bg-success text-white'>
                <h4 class='mb-0'><i class='bi bi-person-plus-fill'></i> Create Demo Student User</h4>
            </div>
            <div class='card-body'>";

try {
    // Check if user already exists
    $check_stmt = $conn->prepare("SELECT id FROM Users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<div class='alert alert-warning'>
                <strong><i class='bi bi-exclamation-triangle'></i> User Already Exists!</strong><br>
                A user with email <strong>$email</strong> already exists in the database.
              </div>";
        
        echo "<div class='alert alert-info'>
                <strong><i class='bi bi-info-circle'></i> Login Credentials:</strong><br>
                Email: <code>$email</code><br>
                Password: <code>$password</code>
              </div>";
    } else {
        // Insert student user
        $stmt = $conn->prepare("INSERT INTO Users (full_name, reg_number, email, phone, password, role, created_at) 
                               VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $full_name, $reg_number, $email, $phone, $hashed_password, $role);
        
        if ($stmt->execute()) {
            $user_id = $conn->insert_id;
            
            echo "<div class='alert alert-success'>
                    <h5 class='alert-heading'><i class='bi bi-check-circle-fill'></i> Success!</h5>
                    <p>Demo student user has been created successfully!</p>
                  </div>";
            
            echo "<div class='card bg-light mb-3'>
                    <div class='card-header'><strong>Student User Details:</strong></div>
                    <div class='card-body'>
                        <table class='table table-sm mb-0'>
                            <tr><th width='40%'>ID:</th><td>$user_id</td></tr>
                            <tr><th>Name:</th><td>$full_name</td></tr>
                            <tr><th>Reg Number:</th><td>$reg_number</td></tr>
                            <tr><th>Email:</th><td><strong>$email</strong></td></tr>
                            <tr><th>Phone:</th><td>$phone</td></tr>
                            <tr><th>Role:</th><td><span class='badge bg-success'>$role</span></td></tr>
                        </table>
                    </div>
                  </div>";
            
            echo "<div class='alert alert-info'>
                    <strong><i class='bi bi-key-fill'></i> Login Credentials:</strong><br><br>
                    <strong>Email:</strong> <code>$email</code><br>
                    <strong>Password:</strong> <code>$password</code>
                  </div>";
            
            echo "<div class='alert alert-success'>
                    <strong><i class='bi bi-check2-all'></i> What This User Can Do:</strong>
                    <ul class='mb-0 mt-2'>
                        <li>Report lost items</li>
                        <li>Report found items</li>
                        <li>Search for items</li>
                        <li>Claim items (with OTP & QR verification)</li>
                        <li>View personal dashboard</li>
                        <li>Update profile information</li>
                        <li>Receive notifications</li>
                    </ul>
                  </div>";
            
            echo "<div class='alert alert-warning'>
                    <strong><i class='bi bi-shield-exclamation'></i> Security Reminder:</strong>
                    <ol class='mb-0 mt-2'>
                        <li>Delete this file after creating the user</li>
                        <li>Change the password after first login</li>
                        <li>This is a demo account for testing only</li>
                    </ol>
                  </div>";
        } else {
            echo "<div class='alert alert-danger'>
                    <strong>Error!</strong><br>
                    Failed to create student user: " . $stmt->error . "
                  </div>";
        }
        
        $stmt->close();
    }
    
    $check_stmt->close();
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>
            <strong>Database Error!</strong><br>
            " . $e->getMessage() . "
          </div>";
}

echo "            <hr>
                <div class='d-grid gap-2'>
                    <a href='../authentication/login.php' class='btn btn-success btn-lg'>
                        <i class='bi bi-box-arrow-in-right'></i> Go to Login Page
                    </a>
                    <a href='../index.php' class='btn btn-outline-secondary'>
                        <i class='bi bi-house-door'></i> Go to Home
                    </a>
                </div>
            </div>
        </div>
        
        <div class='text-center mt-3'>
            <small class='text-white'>
                <i class='bi bi-info-circle-fill'></i> 
                Remember to delete <code>database/create_demo_user.php</code> after use
            </small>
        </div>
    </div>
</body>
</html>";

$conn->close();
?>
