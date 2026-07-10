<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Campus Lost & Found Management System</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --success-color: #06d6a0;
            --danger-color: #ef476f;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* ── Navbar ──────────────────────────────────── */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
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
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        /* ── Hero Carousel ────────────────────────────── */
        .hero-carousel {
            height: 90vh;
            position: relative;
        }

        .carousel-item {
            height: 90vh;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .carousel-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.85), rgba(63, 55, 201, 0.75));
        }

        .carousel-caption {
            bottom: 50%;
            transform: translateY(50%);
            text-align: left;
            left: 10%;
            right: 10%;
        }

        .carousel-caption h1 {
            font-size: 3.5rem;
            font-weight: 800;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease;
        }

        .carousel-caption p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease 0.2s both;
        }

        .carousel-caption .btn-group {
            animation: fadeInUp 1s ease 0.4s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-hero {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-hero-primary {
            background: white;
            color: var(--primary-color);
            border: none;
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            background: #f8f9fa;
        }

        .btn-hero-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-hero-outline:hover {
            background: white;
            color: var(--primary-color);
        }

        /* ── Features Section ────────────────────────── */
        .features-section {
            padding: 5rem 0;
            background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
        }

        .feature-card {
            padding: 2.5rem;
            border-radius: 20px;
            background: white;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            height: 100%;
            border: 1px solid #e9ecef;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(67, 97, 238, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }

        .feature-icon.blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .feature-icon.green { background: linear-gradient(135deg, #06d6a0 0%, #1a9960 100%); color: white; }
        .feature-icon.orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
        .feature-icon.purple { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }

        /* ── About Section ────────────────────────────── */
        .about-section {
            padding: 5rem 0;
            background: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }

        .about-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #495057;
        }

        .stat-box {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            box-shadow: 0 5px 20px rgba(67, 97, 238, 0.3);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.95;
        }

        /* ── How It Works ─────────────────────────────── */
        .how-it-works-section {
            padding: 5rem 0;
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
        }

        .step-card {
            text-align: center;
            padding: 2rem;
        }

        .step-number {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            margin: 0 auto 1.5rem;
        }

        /* ── Footer ────────────────────────────────────── */
        footer {
            background: #1a1f36;
            color: white;
            padding: 3rem 0 1rem;
        }

        footer a {
            color: #b0bcd0;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: white;
        }

        /* ── Responsive ─────────────────────────────────── */
        @media (max-width: 768px) {
            .carousel-caption h1 { font-size: 2rem; }
            .carousel-caption p { font-size: 1rem; }
            .hero-carousel, .carousel-item { height: 70vh; }
            .section-title { font-size: 2rem; }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-search-heart-fill"></i>
                Smart Campus
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">How It Works</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a href="authentication/login.php" class="btn btn-login">Login</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="authentication/register.php" class="btn btn-register">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Carousel -->
    <section id="home">
        <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>

            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920&h=1080&fit=crop');">
                    <div class="carousel-caption">
                        <h1 class="display-3 fw-bold">Never Lose Your Items Again</h1>
                        <p class="lead">Smart Campus Lost & Found connects you with your missing belongings instantly.</p>
                        <div class="btn-group gap-3">
                            <a href="authentication/register.php" class="btn btn-hero btn-hero-primary">Get Started</a>
                            <a href="#about" class="btn btn-hero btn-hero-outline">Learn More</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item" style="background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=1920&h=1080&fit=crop');">
                    <div class="carousel-caption">
                        <h1 class="display-3 fw-bold">Report & Search Easily</h1>
                        <p class="lead">Found something? Lost something? Post it in seconds and reunite items with their owners.</p>
                        <div class="btn-group gap-3">
                            <a href="authentication/register.php" class="btn btn-hero btn-hero-primary">Join Now</a>
                            <a href="#features" class="btn btn-hero btn-hero-outline">View Features</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item" style="background-image: url('https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=1920&h=1080&fit=crop');">
                    <div class="carousel-caption">
                        <h1 class="display-3 fw-bold">Secure & Reliable</h1>
                        <p class="lead">Your trusted platform for managing lost and found items across campus.</p>
                        <div class="btn-group gap-3">
                            <a href="authentication/register.php" class="btn btn-hero btn-hero-primary">Sign Up Free</a>
                            <a href="#how-it-works" class="btn btn-hero btn-hero-outline">How It Works</a>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Why Choose Smart Campus?</h2>
                <p class="section-subtitle">Powerful features designed to reunite you with your belongings</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon blue">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Quick Reporting</h4>
                        <p class="text-muted">Report lost or found items in under 60 seconds with our streamlined interface.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon green">
                            <i class="bi bi-search-heart"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Smart Search</h4>
                        <p class="text-muted">Advanced search filters help you find your items quickly and efficiently.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon orange">
                            <i class="bi bi-bell-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Instant Notifications</h4>
                        <p class="text-muted">Get notified immediately when someone finds or claims your item.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon purple">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Secure Platform</h4>
                        <p class="text-muted">Your data is protected with enterprise-grade security measures.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="section-title">About Smart Campus Lost & Found</h2>
                    <div class="about-content">
                        <p>
                            <strong>Smart Campus Lost & Found</strong> is a comprehensive digital platform designed to streamline 
                            the process of reporting and recovering lost items within campus environments.
                        </p>
                        <p>
                            Our mission is to create a connected community where losing an item doesn't mean losing hope. 
                            With our intuitive interface, students and staff can quickly report lost or found items, 
                            search through an organized database, and reunite with their belongings.
                        </p>
                        <p>
                            Whether it's a laptop left in the library, keys dropped in the cafeteria, or a wallet found 
                            in the parking lot, our system makes recovery simple, fast, and secure.
                        </p>

                        <div class="mt-4">
                            <a href="authentication/register.php" class="btn btn-register btn-lg">
                                <i class="bi bi-arrow-right-circle me-2"></i>Join Our Community
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-box">
                                <div class="stat-number">1000+</div>
                                <div class="stat-label">Items Recovered</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box" style="background: linear-gradient(135deg, #06d6a0, #1a9960);">
                                <div class="stat-number">500+</div>
                                <div class="stat-label">Active Users</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                                <div class="stat-number">95%</div>
                                <div class="stat-label">Success Rate</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                                <div class="stat-number">24/7</div>
                                <div class="stat-label">Platform Access</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">How It Works</h2>
                <p class="section-subtitle">Get started in three simple steps</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h4 class="fw-bold mb-3">Create Account</h4>
                        <p class="text-muted">Sign up with your campus email in less than a minute. It's free and secure.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h4 class="fw-bold mb-3">Report or Search</h4>
                        <p class="text-muted">Lost something? Report it. Found something? Post it. Search our database anytime.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h4 class="fw-bold mb-3">Get Reunited</h4>
                        <p class="text-muted">Connect with finders or owners, verify ownership, and reclaim your items safely.</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="authentication/register.php" class="btn btn-register btn-lg px-5">
                    Get Started Today <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-search-heart-fill me-2"></i>Smart Campus
                    </h5>
                    <p class="text-muted">
                        Your trusted platform for managing lost and found items across campus. 
                        Connecting people with their belongings since 2024.
                    </p>
                </div>

                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home">Home</a></li>
                        <li class="mb-2"><a href="#features">Features</a></li>
                        <li class="mb-2"><a href="#about">About Us</a></li>
                        <li class="mb-2"><a href="#how-it-works">How It Works</a></li>
                        <li class="mb-2"><a href="authentication/login.php">Login</a></li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-envelope me-2"></i>
                            <a href="mailto:support@smartcampus.com">support@smartcampus.com</a>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone me-2"></i>
                            <a href="tel:+254700000000">+254 700 000 000</a>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-geo-alt me-2"></i>
                            Campus Main Office
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

            <div class="text-center">
                <p class="mb-0 text-muted">
                    &copy; <?php echo date('Y'); ?> Smart Campus Lost & Found. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offset = 80;
                    const targetPosition = target.offsetTop - offset;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
