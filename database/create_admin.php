<?php
/**
 * Create Demo Admin User
 * 
 * Run this file once to create the admin account:
 * http://localhost/smart-campus-lost-and-found-management-system/database/create_admin.php
 * 
 * Then delete this file for security!
 */

require_once "../config/database.php";

// Admin credentials
$full_name = "System Administrator";
$reg_number = "ADM/2024/001";
$email = "admin@gmail.com";
$phone = "+254 700 000 000";
$password = "Admin@321";
$role = "admin";

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Create Admin User</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; }
        .container { max-width: 600px; }
        .card { border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); }
    </style>
</head>
<body>
    <div class='container'>
        <div class='card'>
            <div class='card-header bg-primary text-white'>
                <h4 class='mb-0'><i class='bi bi-shield-lock'></i> Create Admin User</h4>
            </div>
            <div class='card-body'>";

try {
    // Check if admin already exists
    $check_stmt = $conn->prepare("SELECT id FROM Users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<div class='alert alert-warning'>
                <strong>Admin Already Exists!</strong><br>
                An admin user with email <strong>$email</strong> already exists in the database.
              </div>";
        
        echo "<div class='alert alert-info'>
                <strong>Login Credentials:</strong><br>
                Email: <code>$email</code><br>
                Password: <code>$password</code>
              </div>";
    } else {
        // Insert admin user
        $stmt = $conn->prepare("INSERT INTO Users (full_name, reg_number, email, phone, password, role, created_at) 
                               VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $full_name, $reg_number, $email, $phone, $hashed_password, $role);
        
        if ($stmt->execute()) {
            $admin_id = $conn->insert_id;
            
            echo "<div class='alert alert-success'>
                    <h5 class='alert-heading'><i class='bi bi-check-circle'></i> Success!</h5>
                    <p>Admin user has been created successfully!</p>
                  </div>";
            
            echo "<div class='card bg-light mb-3'>
                    <div class='card-header'><strong>Admin Details:</strong></div>
                    <div class='card-body'>
                        <table class='table table-sm mb-0'>
                            <tr><th width='40%'>ID:</th><td>$admin_id</td></tr>
                            <tr><th>Name:</th><td>$full_name</td></tr>
                            <tr><th>Reg Number:</th><td>$reg_number</td></tr>
                            <tr><th>Email:</th><td><strong>$email</strong></td></tr>
                            <tr><th>Phone:</th><td>$phone</td></tr>
                            <tr><th>Role:</th><td><span class='badge bg-danger'>$role</span></td></tr>
                        </table>
                    </div>
                  </div>";
            
            echo "<div class='alert alert-info'>
                    <strong><i class='bi bi-key'></i> Login Credentials:</strong><br><br>
                    <strong>Email:</strong> <code>$email</code><br>
                    <strong>Password:</strong> <code>$password</code>
                  </div>";
            
            echo "<div class='alert alert-warning'>
                    <strong><i class='bi bi-exclamation-triangle'></i> Important Security Notes:</strong>
                    <ol class='mb-0 mt-2'>
                        <li>Change the admin password immediately after first login</li>
                        <li>Delete this file (<code>create_admin.php</code>) after use</li>
                        <li>Keep admin credentials secure</li>
                    </ol>
                  </div>";
        } else {
            echo "<div class='alert alert-danger'>
                    <strong>Error!</strong><br>
                    Failed to create admin user: " . $stmt->error . "
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
                    <a href='../authentication/login.php' class='btn btn-primary btn-lg'>
                        <i class='bi bi-box-arrow-in-right'></i> Go to Login Page
                    </a>
                    <a href='../index.php' class='btn btn-outline-secondary'>
                        <i class='bi bi-house'></i> Go to Home
                    </a>
                </div>
            </div>
        </div>
        
        <div class='text-center mt-3'>
            <small class='text-white'>
                <i class='bi bi-info-circle'></i> 
                Remember to delete <code>database/create_admin.php</code> after creating the admin
            </small>
        </div>
    </div>
    
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css' rel='stylesheet'>
</body>
</html>";

$conn->close();
?>
