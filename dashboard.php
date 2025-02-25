<?php
session_start();
include 'db.php'; // Ensure this file contains a proper database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Ensure database connection exists
if (!isset($conn)) {
    die("Database connection not found.");
}

// Execute the query
$query = "SELECT * FROM patients";
$result = $conn->query($query);

// Check for query errors
if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - SOAP System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background: #0d6efd;
            color: white;
            height: 100vh;
            position: fixed;
            padding: 20px;
        }
        .sidebar a {
            color: black;
            display: block;
            margin: 10px 0;
            text-decoration: none;
            font-weight: bold;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        .table th {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>DASHBOARD</h3>
        <a href="add_patient.php" class="btn btn-light w-100">Add Patient</a>
        <a href="login.php" class="btn btn-danger w-100">Logout</a>
    </div>
    
    <div class="main-content">
        <h2>Patients List</h2>
        <table class="table table-bordered table-hover mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Symptoms</th>
                    <th>Medical History</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= $row['gender'] ?></td>
                    <td><?= htmlspecialchars($row['symptoms']) ?></td>
                    <td><?= htmlspecialchars($row['medical_history']) ?></td>
                    <td>
                        <a href="view_patient.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">View SOAP</a>
                        <a href="edit_patient.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Update SOAP</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>