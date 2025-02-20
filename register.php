<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    // Check if username already exists
    $checkQuery = "SELECT * FROM users WHERE username = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists. <a href='login.php'>Login here</a>";
        exit();
    }

    // Insert new user
    $query = "INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        echo "Registration successful! <a href='login.php'>Login here</a>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Registration</h2>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Role:</label>
                <select name="role" class="form-control" required>
                    <option value="doctor">Doctor</option>
                    <option value="nurse">Nurse</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <br>
        <p>Already registered? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>