<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

$query = "SELECT * FROM patients";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - SOAP System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>DASHBOARD</h2>
        <BR>
        <BR>
 
        <a href="add_patient.php" class="btn btn-success mb-3">Add Patient</a>
        <a href="login.php" class="btn btn-danger mb-3">Logout</a>
        <BR>

        <h3>Patients List</h3>
        <table class="table table-bordered">
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
                        <a href="view_patient.php?id=<?= $row['id'] ?>" class="btn btn-info">View SOAP</a>
                        <a href="edit_patient.php?id=<?= $row['id'] ?>" class="btn btn-primary">Update SOAP</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>