<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $symptoms = $_POST['symptoms'];
    $medical_history = $_POST['medical_history'];
    $blood_pressure = $_POST['blood_pressure'];
    $heart_rate = $_POST['heart_rate'];
    $temperature = $_POST['temperature'];
    $weight = $_POST['weight'];
    $diagnostic_tests = $_POST['diagnostic_tests'];

    $query = "INSERT INTO patients (name, age, gender, symptoms, medical_history, blood_pressure, heart_rate, temperature, weight, diagnostic_tests)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sissssidds", $name, $age, $gender, $symptoms, $medical_history, $blood_pressure, $heart_rate, $temperature, $weight, $diagnostic_tests);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Patient added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Patient</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            width: 100%;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s ease-in-out;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            background: linear-gradient(45deg, #007bff, #00c6ff);
            color: white;
            padding: 15px;
            border-radius: 10px;
            font-size: 28px;
            font-weight: bold;
        }
        .header i {
            margin-right: 10px;
        }
        h2, h4 {
            margin-bottom: 20px;
        }
        h2 {
            color: #007bff;
        }
        .section-header {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .form-control {
            border-radius: 10px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Add Patient</div>
        <form action="add_patient.php" method="POST">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Age:</label>
                    <input type="number" name="age" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label d-block">Gender:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Male" required>
                        <label class="form-check-label">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Female" required>
                        <label class="form-check-label">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Other" required>
                        <label class="form-check-label">Other</label>
                    </div>
                </div>
            </div>

            <h4 class="section-header">Subjective Data</h4>
            <div class="mb-3">
                <label class="form-label">Symptoms:</label>
                <textarea name="symptoms" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Medical History:</label>
                <textarea name="medical_history" class="form-control" required></textarea>
            </div>

            <h4 class="section-header">Objective Data</h4>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Blood Pressure (e.g., 120/80 mmHg):</label>
                    <input type="text" name="blood_pressure" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Heart Rate (BPM):</label>
                    <input type="number" name="heart_rate" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Temperature (°C):</label>
                    <input type="number" step="0.1" name="temperature" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Weight (kg):</label>
                    <input type="number" step="0.1" name="weight" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Diagnostic Tests (e.g., X-ray, Blood Test results):</label>
                    <textarea name="diagnostic_tests" class="form-control" required></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Add Patient</button>
                <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>