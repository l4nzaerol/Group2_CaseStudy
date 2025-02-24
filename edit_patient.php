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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $diagnosis = $_POST['diagnosis'];
    $medications = $_POST['medications'];
    $therapies = $_POST['therapies'];
    $follow_ups = $_POST['follow_ups'];

    $update_query = "UPDATE patients SET diagnosis = ?, medications = ?, therapies = ?, follow_ups = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssi", $diagnosis, $medications, $therapies, $follow_ups, $patient_id);

    if ($stmt->execute()) {
        header("Location: view_patient.php?id=$patient_id");
        exit();
    } else {
        echo "Error updating patient information.";
    }
}

$query = "SELECT * FROM patients WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Patient SOAP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color:rgb(229, 242, 255);
        }
        .container {
            max-width: 1000px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background: white;
            margin-bottom: 20px;
        }
        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }
        .patient-name {
            font-size: 20px;
            font-weight: bold;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-primary {
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;
        }
        .btn-danger {
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="header">
        <span class="patient-name">Patient: <?= htmlspecialchars($patient['name']) ?></span>
    </div>
    <div class="card">
        <h4 class="text-center mb-3">Update Patient SOAP</h4>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label"><strong>Diagnosis:</strong></label>
                <textarea name="diagnosis" class="form-control" rows="3" required><?= htmlspecialchars($patient['diagnosis']) ?></textarea>
            </div>
            <h5 class="mt-3">Treatment Plan</h5>
            <div class="mb-3">
                <label class="form-label"><strong>Medications:</strong></label>
                <textarea name="medications" class="form-control" rows="3"><?= htmlspecialchars($patient['medications']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label"><strong>Therapies:</strong></label>
                <textarea name="therapies" class="form-control" rows="3"><?= htmlspecialchars($patient['therapies']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label"><strong>Follow-up Appointments:</strong></label>
                <textarea name="follow_ups" class="form-control" rows="2"><?= htmlspecialchars($patient['follow_ups']) ?></textarea>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Update SOAP</button>
                <a href="view_patient.php?id=<?= $patient_id ?>" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>