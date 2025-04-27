<!-- register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS for styling -->
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";  // Display error messages if any
        }
        ?>
        <form action="register" method="POST">

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password">Role</label>
                <select name="role" id="" require>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Register</button>
            </div>
        </form>
        <p>Already have an account? <a href="log-in">Login here</a></p>
    </div>
</body>
</html>
