<?php
session_start();

$message = "";

if(isset($_SESSION['success'])){
    $message = "<div class='alert alert-success alert-dismissible fade show'>"
        .htmlspecialchars($_SESSION['success'])
        ."<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
    unset($_SESSION['success']);
}

if(isset($_SESSION['error'])){
    $message = "<div class='alert alert-danger alert-dismissible fade show'>"
        .htmlspecialchars($_SESSION['error'])
        ."<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>";
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Smart Campus Lost & Found</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #06d6a0 0%, #1a9960 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar ──────────────────────────────────── */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link {
            font-weight: 500;
            color: #495057 !important;
            transition: color 0.3s;
            margin: 0 0.5rem;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .btn-login {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: var(--primary-color);
            color: white;
        }

        /* ── Main Content ─────────────────────────────── */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 3rem 0;
        }

        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 700px;
            margin: 0 auto;
        }

        .register-header {
            background: linear-gradient(135deg, #06d6a0, #1a9960);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .register-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .register-header h3 {
            margin: 0;
            font-weight: 700;
        }

        .register-body {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #06d6a0;
            box-shadow: 0 0 0 0.2rem rgba(6, 214, 160, 0.25);
        }

        .btn-register-submit {
            background: linear-gradient(135deg, #06d6a0, #1a9960);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            transition: all 0.3s;
        }

        .btn-register-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(6, 214, 160, 0.4);
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #dee2e6;
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            position: relative;
            color: #6c757d;
        }

        /* ── Footer ────────────────────────────────────── */
        footer {
            background: rgba(26, 31, 54, 0.95);
            color: white;
            padding: 2rem 0 1rem;
            margin-top: auto;
        }

        footer a {
            color: #b0bcd0;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: white;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="bi bi-search-heart-fill"></i>
                Smart Campus
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php#about">About</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a href="login.php" class="btn btn-login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-9">
                    <div class="register-card">
                        <div class="register-header">
                            <i class="bi bi-person-plus-fill"></i>
                            <h3>Create Your Account</h3>
                            <p class="mb-0">Join Smart Campus and never lose your items again!</p>
                        </div>

                        <div class="register-body">
                            <?php echo $message; ?>

                            <form action="../api/register_api.php" method="POST">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="bi bi-person me-2"></i>Full Name
                                        </label>
                                        <input type="text" name="full_name" class="form-control" 
                                               placeholder="John Doe" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="bi bi-card-text me-2"></i>Registration Number
                                        </label>
                                        <input type="text" name="reg_number" class="form-control" 
                                               placeholder="REG/2024/001" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="bi bi-envelope me-2"></i>Email Address
                                        </label>
                                        <input type="email" name="email" class="form-control" 
                                               placeholder="john@example.com" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="bi bi-telephone me-2"></i>Phone Number
                                        </label>
                                        <input type="text" name="phone" class="form-control" 
                                               placeholder="+254 700 000 000" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="bi bi-lock me-2"></i>Password
                                        </label>
                                        <input type="password" name="password" class="form-control" 
                                               placeholder="Enter password" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="bi bi-lock-fill me-2"></i>Confirm Password
                                        </label>
                                        <input type="password" name="confirm_password" class="form-control" 
                                               placeholder="Re-enter password" required>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-register-submit w-100">
                                            <i class="bi bi-person-plus-fill me-2"></i>Create Account
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="divider">
                                <span>OR</span>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">Already have an account? 
                                    <a href="login.php" class="fw-bold" style="color: #06d6a0;">
                                        Login here
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-search-heart-fill me-2"></i>Smart Campus
                    </h6>
                    <p class="mb-0 small text-muted">
                        Your trusted platform for managing lost and found items across campus.
                    </p>
                </div>

                <div class="col-md-3 mb-3 mb-md-0">
                    <h6 class="fw-bold mb-2">Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1"><a href="../index.php">Home</a></li>
                        <li class="mb-1"><a href="../index.php#features">Features</a></li>
                        <li class="mb-1"><a href="../index.php#about">About</a></li>
                    </ul>
                </div>

                <div class="col-md-3">
                    <h6 class="fw-bold mb-2">Contact</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-1">
                            <i class="bi bi-envelope me-2"></i>
                            <a href="mailto:support@smartcampus.com">support@smartcampus.com</a>
                        </li>
                        <li class="mb-1">
                            <i class="bi bi-telephone me-2"></i>
                            <a href="tel:+254700000000">+254 700 000 000</a>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="my-3" style="border-color: rgba(255,255,255,0.1);">

            <div class="text-center">
                <p class="mb-0 small text-muted">
                    &copy; <?php echo date('Y'); ?> Smart Campus Lost & Found. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
