<?php
// view_patient.php
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient SOAP Details</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-color: #eef2f3;
    }
    .card {
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease-in-out;
    }
    .card:hover {
      transform: scale(1.02);
    }
    .btn-custom {
      border-radius: 20px;
      transition: background 0.3s ease;
    }
    .btn-custom:hover {
      background: #007bff;
      color: white;
    }
    /* Patient Header Styles */
    .patient-header {
      background: linear-gradient(45deg, #007bff, #00c6ff);
      color: white;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      margin-bottom: 20px;
    }
    .patient-name {
      font-size: 28px;
      font-weight: bold;
      display: block;
      transition: transform 0.3s ease, color 0.3s ease;
    }
    .patient-name:hover {
      transform: scale(1.05);
      color: #ffd700; /* gold on hover */
    }
    .patient-id {
      font-size: 18px;
      color: #e0e0e0;
      transition: color 0.3s ease;
    }
    .patient-id:hover {
      color: #ffffff;
    }
  </style>
</head>
<body>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <a href="dashboard.php" class="btn btn-secondary btn-custom"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
      <a href="edit_patient.php?id=<?= $patient_id ?>" class="btn btn-warning btn-custom"><i class="fas fa-edit"></i> Edit SOAP</a>
    </div>
    
    <div class="card p-4">
      <div class="patient-header">
        <span class="patient-name"><?= htmlspecialchars($patient['name']) ?></span>
        <span class="patient-id">Patient ID: <?= $patient_id ?></span>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h4>Patient Information</h4>
          <hr>
          
          <p><strong>Age:</strong> <?= $patient['age'] ?></p>
          <p><strong>Gender:</strong> <?= $patient['gender'] ?></p>
          <p><strong>Blood Pressure:</strong> <?= $patient['blood_pressure'] ?></p>
          <p><strong>Heart Rate:</strong> <?= $patient['heart_rate'] ?> BPM</p>
          <p><strong>Diagnostic Test:</strong> <?= $patient['diagnostic_tests'] ?></p>
        </div>
        <div class="col-md-6">
          
            <br>
            <br>
            <br>
          <p><strong>Temperature:</strong> <?= $patient['temperature'] ?> °C</p>
          <p><strong>Weight:</strong> <?= $patient['weight'] ?> kg</p>
          <p><strong>Symptoms:</strong> <?= htmlspecialchars($patient['symptoms']) ?></p>
          <p><strong>Medical History:</strong> <?= htmlspecialchars($patient['medical_history']) ?></p>
        </div>
      </div>
    </div>
    
    <div class="row mt-3">
      <div class="col-md-6">
        <div class="card p-4">
          <h4>Diagnosis</h4>
          <hr>
          <p><strong>Primary Diagnosis:</strong> <?= htmlspecialchars($patient['diagnosis']) ?></p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card p-4">
          <h4>Treatment Plan</h4>
          <hr>
          <p><strong>Medications:</strong> <?= htmlspecialchars($patient['medications']) ?></p>
          <p><strong>Therapies:</strong> <?= htmlspecialchars($patient['therapies']) ?></p>
          <p><strong>Follow-up Appointments:</strong> <?= htmlspecialchars($patient['follow_ups']) ?></p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>