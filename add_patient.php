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
        echo "<div class='alert alert-success'>Patient added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Patient</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Patient</h2>
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

            <h4 class="mt-4 text-primary">Subjective Data</h4>
            <div class="mb-3">
                <label class="form-label">Symptoms:</label>
                <textarea name="symptoms" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Medical History:</label>
                <textarea name="medical_history" class="form-control" required></textarea>
            </div>

            <h4 class="mt-4 text-primary">Objective Data</h4>
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
                <button type="submit" class="btn btn-primary">Add Patient</button>
                <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>


