<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Logic to handle password reset (send reset link via email or other)
    echo "Password reset link sent to your email.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password - CodeStyle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <style>
        :root {
            --accent: #ff4747;
            --bg-color: #121212;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --border-color: rgba(255, 255, 255, 0.15);
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            background: linear-gradient(145deg, #1a1a1a, #0d0d0d);
            color: #fff;
            overflow: hidden;
        }

        .login-wrapper {
            height: 100%;
            backdrop-filter: blur(10px);
        }

        .glass-card {
            background: var(--glass-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2.5rem;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
        }

        .glass-card h2 {
            font-weight: 600;
            color: var(--accent);
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(255, 71, 71, 0.25);
        }

        .btn-danger {
            background-color: var(--accent);
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #e03e3e;
            transform: scale(1.02);
        }

        .form-text a {
            color: #ccc;
            text-decoration: none;
        }

        .form-text a:hover {
            text-decoration: underline;
            color: #fff;
        }

        .animate-fade {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid login-wrapper d-flex justify-content-center align-items-center">
        <div class="glass-card animate-fade">
            <div class="mb-4 text-center">
                <span id="typed-text" class="fs-5 fw-semibold text-white"></span>
            </div>
            <h2 class="text-center mb-4">Forgot Password</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <button type="submit" class="btn btn-danger w-100">Reset Password</button>
                <div class="d-flex justify-content-between mt-3 form-text">
                    <a href="login.html">Back to Login</a>
                    <a href="register.html">Create account</a>
                </div>
            </form>
        </div>
    </div>

</body>
<script src="/assets/js/auto-typer.js"></script>
</html>
