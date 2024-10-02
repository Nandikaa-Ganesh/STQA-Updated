<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $appointment_date = $_POST['appointment_date'];
    $doctor_id = $_POST['doctor_id'];

    $stmt = $conn->prepare("INSERT INTO appointments (user_id, doctor_id, appointment_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $doctor_id, $appointment_date);
    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        $error = "Booking failed.";
    }
}

$doctor_stmt = $conn->prepare("SELECT * FROM doctors");
if ($doctor_stmt->execute()) {
    $doctor_result = $doctor_stmt->get_result();
    $doctors = $doctor_result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error fetching doctors: " . $doctor_stmt->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST">
        <h2>Book an Appointment</h2>
        <label for="doctor">Select Doctor:</label>
<select name="doctor_id" required>
    <option value="">Choose a doctor</option>
    <?php foreach ($doctors as $doctor): ?>
        <option value="<?= $doctor['id'] ?>"><?= $doctor['name'] ?> (<?= $doctor['specialization'] ?>)</option>
    <?php endforeach; ?>
</select>

        <input type="datetime-local" name="appointment_date" required>
        <button type="submit">Book Appointment</button>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </form>
</body>
</html>
