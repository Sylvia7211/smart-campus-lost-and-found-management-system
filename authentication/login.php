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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Smart Campus Lost & Found</title>
    
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        .btn-register {
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            border: 2px solid var(--primary-color);
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        /* ── Main Content ─────────────────────────────── */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 3rem 0;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 500px;
            margin: 0 auto;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .login-header h3 {
            margin: 0;
            font-weight: 700;
        }

        .login-body {
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
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .btn-login {
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
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
                        <a href="register.php" class="btn btn-register">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="login-card">
                        <div class="login-header">
                            <i class="bi bi-box-arrow-in-right"></i>
                            <h3>Welcome Back!</h3>
                            <p class="mb-0">Login to access your account</p>
                        </div>

                        <div class="login-body">
                            <?php echo $message; ?>

                            <form action="../api/login_api.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-envelope me-2"></i>Email Address
                                    </label>
                                    <input type="email" name="email" class="form-control" 
                                           placeholder="Enter your email" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="bi bi-lock me-2"></i>Password
                                    </label>
                                    <input type="password" name="password" class="form-control" 
                                           placeholder="Enter your password" required>
                                </div>

                                <button type="submit" class="btn btn-login btn-primary w-100">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </button>
                            </form>

                            <div class="divider">
                                <span>OR</span>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">Don't have an account? 
                                    <a href="register.php" class="fw-bold" style="color: var(--primary-color);">
                                        Register here
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
