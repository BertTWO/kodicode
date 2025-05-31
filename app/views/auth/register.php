<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Your registration logic here
    $success = true; // Set this based on your registration logic
    
    if ($success) {
        header("Location: /welcome"); // Redirect after successful registration
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join CodeZilla | Developer Platform</title>
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
        }

        body, html {
            height: 100%;
            margin: 0;
            background: linear-gradient(135deg, var(--dark), var(--darker));
            color: var(--text-primary);
            overflow: hidden;
        }

        .auth-container {
            height: 100vh;
            display: flex;
            position: relative;
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
        }

        .form-control, .form-select {
            background-color: rgba(23, 25, 35, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.07);
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
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
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(115, 103, 240, 0.4);
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
        }

        .auth-footer a:hover {
            text-decoration: underline;
            color: var(--secondary);
        }

        .password-strength {
            height: 4px;
            background: #2D2F40;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }

        .strength-meter {
            height: 100%;
            width: 0;
            background: #FF5B5C;
            transition: all 0.3s ease;
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
        .animate-delay-1 { animation-delay: 0.2s; }
        .animate-delay-2 { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-wrapper">
            <!-- Left side with branding and info -->
            <div class="auth-left animate__animated animate__fadeInLeft">
                <img src="/assets/img/logo.png" alt="CodeZilla Logo" class="brand-logo">
                <h1 class="auth-heading">Join CodeZilla</h1>
                <p class="auth-subheading">
                    Become part of the developer community building the future. 
                    Get access to powerful tools, resources, and collaboration.
                </p>
                
                <div class="auth-features">
                    <div class="feature-item animate__animated animate__fadeInUp">
                        <div class="feature-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="feature-text">Access to cutting-edge development tools</div>
                    </div>
                    <div class="feature-item animate__animated animate__fadeInUp animate-delay-1">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="feature-text">Join a community of expert developers</div>
                    </div>
                    <div class="feature-item animate__animated animate__fadeInUp animate-delay-2">
                        <div class="feature-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div class="feature-text">Launch projects faster with our platform</div>
                    </div>
                </div>
            </div>
            
            <!-- Right side with registration form -->
            <div class="auth-right animate__animated animate__fadeIn">
                <div class="auth-card">
                    <div class="card-header">
                        <h2 class="card-title">Create Account</h2>
                        <p class="card-subtitle">Start your developer journey with us</p>
                    </div>
                    
                    <form action="register" method="POST">
                        <div class="mb-3 animate__animated animate__fadeInUp">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="your@email.com" required>
                            </div>
                        </div>
                        
                        <div class="mb-3 animate__animated animate__fadeInUp animate-delay-1">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="coder123" required>
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
                            <div class="password-strength">
                                <div class="strength-meter" id="passwordStrength"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3 animate__animated animate__fadeInUp animate-delay-2">
                            <label for="role" class="form-label">I'm joining as a</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="" disabled selected>Select your role</option>
                                <option value="teacher">Educator/Teacher</option>
                                <option value="student">Student/Learner</option>
                                <option value="developer">Professional Developer</option>
                            </select>
                        </div>
                        
                        <div class="mb-3 form-check animate__animated animate__fadeInUp animate-delay-2">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="#" style="color: var(--primary);">Terms of Service</a> and <a href="#" style="color: var(--primary);">Privacy Policy</a></label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mb-3 animate__animated animate__fadeInUp animate-delay-3">
                            Create Account <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                        
                        <div class="auth-footer animate__animated animate__fadeInUp animate-delay-3">
                            Already have an account? <a href="log-in">Sign in</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const strengthMeter = document.getElementById('passwordStrength');
            const strength = calculatePasswordStrength(this.value);
            
            if (strength < 30) {
                strengthMeter.style.backgroundColor = '#FF5B5C'; // Weak (red)
                strengthMeter.style.width = '30%';
            } else if (strength < 70) {
                strengthMeter.style.backgroundColor = '#FFC107'; // Medium (yellow)
                strengthMeter.style.width = '60%';
            } else {
                strengthMeter.style.backgroundColor = '#28C76F'; // Strong (green)
                strengthMeter.style.width = '100%';
            }
        });

        function calculatePasswordStrength(password) {
            let strength = 0;
            
            // Length contributes up to 40%
            strength += Math.min(password.length / 12 * 40, 40);
            
            // Character variety contributes up to 30%
            const hasLower = /[a-z]/.test(password);
            const hasUpper = /[A-Z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[^a-zA-Z0-9]/.test(password);
            
            const varietyCount = [hasLower, hasUpper, hasNumber, hasSpecial].filter(Boolean).length;
            strength += (varietyCount / 4) * 30;
            
            // Common patterns reduce strength
            const commonPatterns = ['123', 'password', 'qwerty', 'abc'];
            if (commonPatterns.some(pattern => password.toLowerCase().includes(pattern))) {
                strength = Math.max(0, strength - 20);
            }
            
            return Math.min(100, Math.round(strength));
        }
    </script>
</body>
</html>