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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOAP System Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <style>
        body {
            background-color: #eef2f3;
        }
        .container {
            margin-top: 20px;
        }
        .table th {
            background: linear-gradient(45deg, #007bff, #00c6ff);
            color: white;
        }
        .search-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .button-group {
            display: flex;
            gap: 10px;
        }
        .table-hover tbody tr:hover {
            background-color: #d6e4ff;
            transition: 0.3s;
        }
        .dashboard-header {
            background: linear-gradient(90deg, #0044cc, #0066ff);
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
    <script>
        function searchPatients() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let tableRows = document.querySelectorAll(".table tbody tr");
            
            tableRows.forEach(row => {
                let name = row.children[1].textContent.toLowerCase();
                if (name.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="dashboard-header">
            SOAP System Dashboard
        </div>
        <div class="search-bar">
            <div class="button-group">
                <a href="add_patient.php" class="btn btn-success"><i class="fas fa-user-plus"></i> Add Patient</a>
            </div>
            <input type="text" id="searchInput" class="form-control w-50" onkeyup="searchPatients()" placeholder="Search by patient name...">
            <!-- Logout link now has a confirmation prompt -->
            <a href="login.php" class="btn btn-danger" onclick="return confirm('Are you sure you want to logout?');"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div class="card shadow p-3 mb-5 bg-white rounded">
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover">
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
                                <a href="view_patient.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                <a href="edit_patient.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>