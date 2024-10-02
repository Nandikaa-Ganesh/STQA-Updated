<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];

    $stmt = $conn->prepare("INSERT INTO doctors (name, specialization) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $specialization);
    if ($stmt->execute()) {
        $success = "Doctor added successfully.";
    } else {
        $error = "Failed to add doctor.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST">
        <h2>Add Doctor</h2>
        <input type="text" name="name" required placeholder="Doctor's Name">
        <input type="text" name="specialization" required placeholder="Specialization">
        <button type="submit">Add Doctor</button>
        <?php if (isset($success)) echo "<p>$success</p>"; ?>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </form>
</body>
</html>
