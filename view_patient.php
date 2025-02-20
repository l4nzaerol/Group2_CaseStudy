<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit();
}

$patient_id = $_GET['id'];
$query = "SELECT * FROM patients WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

if (!$patient) {
    echo "Patient not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient SOAP Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Patient SOAP Details</h2>
        <a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

        <table class="table table-bordered">
            <tr><th>Name</th><td><?= htmlspecialchars($patient['name']) ?></td></tr>
            <tr><th>Age</th><td><?= $patient['age'] ?></td></tr>
            <tr><th>Gender</th><td><?= $patient['gender'] ?></td></tr>
            <tr><th>Symptoms</th><td><?= htmlspecialchars($patient['symptoms']) ?></td></tr>
            <tr><th>Medical History</th><td><?= htmlspecialchars($patient['medical_history']) ?></td></tr>
            <tr><th>Blood Pressure</th><td><?= $patient['blood_pressure'] ?></td></tr>
            <tr><th>Heart Rate</th><td><?= $patient['heart_rate'] ?> BPM</td></tr>
            <tr><th>Temperature</th><td><?= $patient['temperature'] ?> °C</td></tr>
            <tr><th>Weight</th><td><?= $patient['weight'] ?> kg</td></tr>
            <tr><th>Diagnostic Tests</th><td><?= htmlspecialchars($patient['diagnostic_tests']) ?></td></tr>
            <tr><th>Diagnosis</th><td><?= htmlspecialchars($patient['diagnosis']) ?></td></tr>
            <tr><th>Treatment Plan</th><td><?= htmlspecialchars($patient['treatment_plan']) ?></td></tr>
            <tr><th>Medications</th><td><?= htmlspecialchars($patient['medications']) ?></td></tr>
            <tr><th>Therapies</th><td><?= htmlspecialchars($patient['therapies']) ?></td></tr>
            <tr><th>Follow-up Appointments</th><td><?= htmlspecialchars($patient['follow_ups']) ?></td></tr>
        </table>
    </div>
</body>
</html>
