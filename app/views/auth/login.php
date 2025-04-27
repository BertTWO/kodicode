<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
     $dashboardUrl = $_POST['role'].'/dashboard';
    echo"header('Location: /kodicode/$dashboardUrl/dashboard');";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS for styling -->
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";  // Display error messages if any
        }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Login</button>
            </div>
        </form>
        <p>Don't have an account? <a href="register">Register here</a></p>
    </div>
</body>
</html>
