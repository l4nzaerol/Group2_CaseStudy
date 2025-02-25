<?php
session_start();
include 'db.php';

$message = ""; // For storing messages
$messageType = ""; // "success" or "error"

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    // Check if the username exists
    $checkQuery = "SELECT * FROM users WHERE username = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $message = "Username already exists. Please try again.";
        $messageType = "error";
    } else {
        // Insert new user
        $query = "INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $password, $role);

        if ($stmt->execute()) {
            $message = "Registration successful! Redirecting to login...";
            $messageType = "success";
        } else {
            $message = "Error: " . $stmt->error;
            $messageType = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Medical System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            font-size: 16px;
            color: #34495e;
            font-weight: 500;
        }
        input[type="text"], input[type="password"] {
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 16px;
            width: 100%;
            margin-bottom: 15px;
        }
        button {
            background-color: #3498db;
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #2980b9;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .role-selection {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        .role-selection input {
            display: none;
        }
        .role-label {
            background-color: #ecf0f1;
            padding: 12px 20px;
            border-radius: 5px;
            border: 2px solid transparent;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            transition: all 0.3s ease;
        }
        .role-selection input:checked + .role-label {
            background-color: #3498db;
            color: white;
            border: 2px solid #2980b9;
        }
        .modal-content {
            border-radius: 10px;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Registration</h2>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="form-group">
                <label>Role:</label>
                <div class="role-selection">
                    <input type="radio" id="doctor" name="role" value="doctor" required>
                    <label for="doctor" class="role-label">Doctor</label>

                    <input type="radio" id="nurse" name="role" value="nurse">
                    <label for="nurse" class="role-label">Nurse</label>
                </div>
            </div>
            <button type="submit">Register</button>
        </form>
        <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <!-- Success/Error Modal -->
    <?php if (!empty($message)) { ?>
        <div class="modal fade show" id="feedbackModal" tabindex="-1" aria-hidden="true" style="display: block;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <h4 class="mb-3 <?php echo ($messageType == 'success') ? 'text-success' : 'text-danger'; ?>">
                        <?php echo ($messageType == 'success') ? 'Success!' : 'Error!'; ?>
                    </h4>
                    <p><?php echo $message; ?></p>
                    <button class="btn btn-<?php echo ($messageType == 'success') ? 'success' : 'danger'; ?>" onclick="closeModal()">OK</button>
                </div>
            </div>
        </div>
        <script>
            function closeModal() {
                document.getElementById("feedbackModal").style.display = "none";
                <?php if ($messageType == "success") { ?>
                    setTimeout(() => window.location.href = 'login.php', 1000);
                <?php } ?>
            }
        </script>
    <?php } ?>
</body>
</html>