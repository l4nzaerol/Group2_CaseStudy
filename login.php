<?php
session_start();
include 'db.php';

$error = ""; // To store error messages
$redirectScript = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password_hash'])) {
            // Start session and set user data
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            
            // JavaScript prompt for confirmation
            $redirectScript = "<script>
                if (confirm('Login successful! Click OK to proceed to your dashboard.')) {
                    window.location.href = 'dashboard.php';
                }
            </script>";
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Medical System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 450px;
            margin-top: 80px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 26px;
            font-weight: 600;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 6px;
            font-size: 16px;
            padding: 10px;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }
        .btn {
            background-color: #3498db;
            color: white;
            font-size: 16px;
            padding: 10px;
            border-radius: 6px;
            width: 100%;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .error-message {
            padding: 10px;
            color: #e74c3c;
            background-color: #f8d7da;
            border: 1px solid #e74c3c;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 15px;
        }
        a {
            color: #3498db;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Login</h2>

        <!-- Error Message Box -->
        <?php if (!empty($error)) { ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php } ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <a href="register.php">Don't have an account? Register here</a>
    </div>

    <?php echo $redirectScript; ?>
</body>
</html>