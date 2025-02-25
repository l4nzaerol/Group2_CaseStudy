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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <style>
        body {
            background-color: #eef2f3;
        }
        .container {
            max-width: 900px;
            margin-top: 40px;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .header {
            text-align: center;
            padding: 15px;
            background: linear-gradient(45deg, #007bff, #00c6ff);
            color: white;
            border-radius: 10px;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background: white;
        }
        .form-control {
            border-radius: 10px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0,123,255,0.3);
        }
        .btn {
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #b02a37;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
       Edit Patient SOAP
    </div>
    <div class="card">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label"><strong>Diagnosis:</strong></label>
                <textarea name="diagnosis" class="form-control" rows="3" required><?= htmlspecialchars($patient['diagnosis']) ?></textarea>
            </div>
            <div class="mb-3">
                <h5 class="mt-3">Treatment Plan</h5>
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
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update SOAP</button>
                <a href="dashboard.php?id=<?= $patient_id ?>" class="btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>