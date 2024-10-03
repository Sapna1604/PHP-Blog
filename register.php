<?php
session_start();
require_once 'config.php'; // Include your database configuration

$warningMessage = ""; // Initialize the warning message

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($checkEmail);
    $stmt->execute(['email' => $email]);

    // Check if username already exists
    $checkUsername = "SELECT * FROM users WHERE username = :username";
    $stmtUsername = $pdo->prepare($checkUsername);
    $stmtUsername->execute(['username' => $username]);

    if ($stmt->rowCount() > 0) {
        $warningMessage = "Email already exists. Please use a different email.";
    } elseif ($stmtUsername->rowCount() > 0) {
        $warningMessage = "Username already exists. Please choose a different username.";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);

        // Redirect to login page
        header("Location: login.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .link {
            text-align: center;
            margin-top: 10px;
        }

        .link a {
            color: #007bff;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }

        .warning {
            color: red;
            text-align: center;
            margin-top: 10px; /* Adds some space above the warning */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        
        <!-- Display warning message if exists -->
        <?php if (!empty($warningMessage)): ?>
            <div class="warning">
                <?php echo $warningMessage; ?>
            </div>
        <?php endif; ?>

        <div class="link">
            <p>Already have an account? <a href="login.php">Login here.</a></p>
        </div>
    </div>
</body>
</html>
