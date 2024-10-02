<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'appointment_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch medical details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM medical_details WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $medical_details = $result->fetch_assoc();
} else {
    // If no medical details found, set default values
    $medical_details = [
        'medical_history' => 'N/A',
        'allergies' => 'N/A',
        'current_medications' => 'N/A',
        'chronic_conditions' => 'N/A'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            margin: 20px;
            padding: 10px 15px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Your Medical Details</h1>
    <table>
        <tr>
            <th>Medical History</th>
            <td><?php echo htmlspecialchars($medical_details['medical_history']); ?></td>
        </tr>
        <tr>
            <th>Allergies</th>
            <td><?php echo htmlspecialchars($medical_details['allergies']); ?></td>
        </tr>
        <tr>
            <th>Current Medications</th>
            <td><?php echo htmlspecialchars($medical_details['current_medications']); ?></td>
        </tr>
        <tr>
            <th>Chronic Conditions</th>
            <td><?php echo htmlspecialchars($medical_details['chronic_conditions']); ?></td>
        </tr>
    </table>
    <button onclick="window.print()">Print this page</button>
</body>
</html>
