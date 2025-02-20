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
</head>
<body>
    <div class="container mt-5">
        <h2>Add Patient</h2>
        <form action="add_patient.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Age:</label>
                <input type="number" name="age" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender:</label>
                <select name="gender" class="form-control" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <h4>Subjective Data</h4>
            <div class="mb-3">
                <label class="form-label">Symptoms:</label>
                <textarea name="symptoms" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Medical History:</label>
                <textarea name="medical_history" class="form-control" required></textarea>
            </div>

            <h4>Objective Data</h4>
            <div class="mb-3">
                <label class="form-label">Blood Pressure (e.g., 120/80 mmHg):</label>
                <input type="text" name="blood_pressure" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Heart Rate (BPM):</label>
                <input type="number" name="heart_rate" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Temperature (°C):</label>
                <input type="number" step="0.1" name="temperature" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Weight (kg):</label>
                <input type="number" step="0.1" name="weight" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Diagnostic Tests (e.g., X-ray, Blood Test results):</label>
                <textarea name="diagnostic_tests" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Patient</button>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>