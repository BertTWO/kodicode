<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dashboardUrl = $_POST['role'] . '/dashboard';
    header("Location: /kodicode/$dashboardUrl/dashboard");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CodeZilla | Secure Sign In</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #7367F0;
            --primary-dark: #5D52D3;
            --secondary: #FF9F43;
            --dark: #161622;
            --darker: #0F0F17;
            --light: #F8F8F8;
            --glass: rgba(42, 44, 58, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-primary: #D0D2D6;
            --text-secondary: #A6A7AB;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            margin: 0;
            background: linear-gradient(135deg, var(--dark), var(--darker));
            color: var(--text-primary);
            overflow: hidden;
        }

        .login-container {
            height: 100vh;
            display: flex;
            position: relative;
            overflow: hidden;
        }

        .bg-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .auth-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            display: flex;
        }

        .auth-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 8%;
            background: linear-gradient(135deg, rgba(22, 22, 34, 0.9), rgba(15, 15, 23, 0.95));
        }

        .brand-logo {
            width: 180px;
            margin-bottom: 2rem;
            filter: drop-shadow(0 0 10px rgba(115, 103, 240, 0.3));
        }

        .auth-heading {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-subheading {
            font-size: 1.1rem;
            color: var(--text-secondary);
            margin-bottom: 3rem;
            max-width: 500px;
            line-height: 1.6;
        }

        .auth-features {
            margin-top: 3rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(115, 103, 240, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--primary);
            font-size: 1.2rem;
        }

        .feature-text {
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        .auth-right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(10px);
        }

        .auth-card {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 3rem;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(115, 103, 240, 0.1) 0%, transparent 70%);
            z-index: -1;
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .card-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .card-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--light);
        }

        .card-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            background-color: rgba(23, 25, 35, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.07);
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: rgba(30, 32, 45, 0.7);
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(115, 103, 240, 0.25);
            color: var(--light);
        }

        .input-group-text {
            background-color: rgba(23, 25, 35, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.07);
            color: var(--text-secondary);
        }

        .btn-primary {
            background-color: var(--primary);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(115, 103, 240, 0.4);
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0.3) 0%,
                rgba(255, 255, 255, 0) 60%
            );
            transform: rotate(30deg);
            transition: all 0.3s ease;
        }

        .btn-primary:hover::after {
            left: 100%;
        }

        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .auth-footer a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .divider::before {
            margin-right: 1rem;
        }

        .divider::after {
            margin-left: 1rem;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            color: var(--primary);
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .auth-left {
                display: none;
            }
            
            .auth-right {
                padding: 2rem;
            }
            
            .auth-card {
                padding: 2rem;
            }
        }

        /* Animation classes */
        .animate-delay-1 {
            animation-delay: 0.2s;
        }
        .animate-delay-2 {
            animation-delay: 0.4s;
        }
        .animate-delay-3 {
            animation-delay: 0.6s;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Animated background particles would go here -->
        <div class="bg-particles" id="particles-js"></div>
        
        <div class="auth-wrapper">
            <!-- Left side with branding and info -->
            <div class="auth-left animate__animated animate__fadeInLeft">
                <img src="/assets/img/logo.png" alt="CodeZilla Logo" class="brand-logo">
                <h1 class="auth-heading">Welcome to CodeZilla</h1>
                <p class="auth-subheading">
                    The ultimate development platform for modern applications. 
                    Join thousands of developers building the future with our tools.
                </p>
                
                <div class="auth-features">
                    <div class="feature-item animate__animated animate__fadeInUp animate-delay-1">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">Enterprise-grade security & compliance</div>
                    </div>
                    <div class="feature-item animate__animated animate__fadeInUp animate-delay-2">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="feature-text">Lightning fast build times with our cloud infrastructure</div>
                    </div>
                    <div class="feature-item animate__animated animate__fadeInUp animate-delay-3">
                        <div class="feature-icon">
                            <i class="fas fa-infinity"></i>
                        </div>
                        <div class="feature-text">Unlimited scalability for projects of any size</div>
                    </div>
                </div>
            </div>
            
            <!-- Right side with login form -->
            <div class="auth-right animate__animated animate__fadeIn">
                <div class="auth-card">
                    <div class="card-header">
                        <h2 class="card-title">Sign In</h2>
                        <p class="card-subtitle">Enter your credentials to access your account</p>
                    </div>
                    
                    <form action="/log-in" method="post">
                        <div class="mb-3 animate__animated animate__fadeInUp">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="your@email.com" >
                            </div>
                        </div>
                        
                        <div class="mb-3 animate__animated animate__fadeInUp animate-delay-1">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                                <button class="input-group-text bg-transparent border-start-0" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <a href="#" class="text-decoration-none" style="color: var(--primary); font-size: 0.85rem;">Forgot password?</a>
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check animate__animated animate__fadeInUp animate-delay-2">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mb-3 animate__animated animate__fadeInUp animate-delay-3">
                            Sign In <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        
                        <div class="divider animate__animated animate__fadeInUp animate-delay-3">OR CONTINUE WITH</div>
                        
                        <div class="social-login animate__animated animate__fadeInUp animate-delay-3">
                            <a href="#" class="social-btn"><i class="fab fa-google"></i></a>
                            <a href="#" class="social-btn"><i class="fab fa-github"></i></a>
                            <a href="#" class="social-btn"><i class="fab fa-microsoft"></i></a>
                            <a href="#" class="social-btn"><i class="fab fa-apple"></i></a>
                        </div>
                        
                        <div class="auth-footer animate__animated animate__fadeInUp animate-delay-3">
                            Don't have an account? <a href="register">Create one</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    <!-- Particles.js for background animation -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Initialize particles.js
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof particlesJS !== 'undefined') {
                particlesJS('particles-js', {
                    "particles": {
                        "number": {
                            "value": 80,
                            "density": {
                                "enable": true,
                                "value_area": 800
                            }
                        },
                        "color": {
                            "value": "#7367F0"
                        },
                        "shape": {
                            "type": "circle",
                            "stroke": {
                                "width": 0,
                                "color": "#000000"
                            },
                            "polygon": {
                                "nb_sides": 5
                            }
                        },
                        "opacity": {
                            "value": 0.3,
                            "random": false,
                            "anim": {
                                "enable": false,
                                "speed": 1,
                                "opacity_min": 0.1,
                                "sync": false
                            }
                        },
                        "size": {
                            "value": 3,
                            "random": true,
                            "anim": {
                                "enable": false,
                                "speed": 40,
                                "size_min": 0.1,
                                "sync": false
                            }
                        },
                        "line_linked": {
                            "enable": true,
                            "distance": 150,
                            "color": "#7367F0",
                            "opacity": 0.2,
                            "width": 1
                        },
                        "move": {
                            "enable": true,
                            "speed": 2,
                            "direction": "none",
                            "random": false,
                            "straight": false,
                            "out_mode": "out",
                            "bounce": false,
                            "attract": {
                                "enable": false,
                                "rotateX": 600,
                                "rotateY": 1200
                            }
                        }
                    },
                    "interactivity": {
                        "detect_on": "canvas",
                        "events": {
                            "onhover": {
                                "enable": true,
                                "mode": "grab"
                            },
                            "onclick": {
                                "enable": true,
                                "mode": "push"
                            },
                            "resize": true
                        },
                        "modes": {
                            "grab": {
                                "distance": 140,
                                "line_linked": {
                                    "opacity": 1
                                }
                            },
                            "bubble": {
                                "distance": 400,
                                "size": 40,
                                "duration": 2,
                                "opacity": 8,
                                "speed": 3
                            },
                            "repulse": {
                                "distance": 200,
                                "duration": 0.4
                            },
                            "push": {
                                "particles_nb": 4
                            },
                            "remove": {
                                "particles_nb": 2
                            }
                        }
                    },
                    "retina_detect": true
                });
            }
            
            // Typed.js animation for any text you want to animate
            if (typeof Typed !== 'undefined') {
                new Typed('#typed-text', {
                    strings: ["Build faster.", "Scale effortlessly.", "Deploy securely.", "Welcome to CodeZilla."],
                    typeSpeed: 50,
                    backSpeed: 30,
                    loop: true
                });
            }
        });
    </script>
</body>
</html>