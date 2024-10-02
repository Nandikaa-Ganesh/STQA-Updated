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

// Fetch current medical details if they exist
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM medical_details WHERE user_id = $user_id";
$result = $conn->query($sql);
$medical_details = $result->fetch_assoc();

// Handle form submission for adding/updating details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medical_history = $_POST['medical_history'];
    $allergies = $_POST['allergies'];
    $current_medications = $_POST['current_medications'];
    $chronic_conditions = $_POST['chronic_conditions'];

    if ($medical_details) {
        // Update existing record
        $sql = "UPDATE medical_details SET 
                    medical_history='$medical_history',
                    allergies='$allergies',
                    current_medications='$current_medications',
                    chronic_conditions='$chronic_conditions' 
                WHERE user_id = $user_id";
    } else {
        // Insert new record
        $sql = "INSERT INTO medical_details 
                    (user_id, medical_history, allergies, current_medications, chronic_conditions)
                VALUES ($user_id, '$medical_history', '$allergies', '$current_medications', '$chronic_conditions')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Medical details saved successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medical Details</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<style>
        body {
            font-family: Inter;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            resize: vertical; /* Allows vertical resizing */
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            font-family:Inter;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838; /* Darker green on hover */
        }
        .goback{
            text-align: center;
            text-decoration: none;
    color:white;
    padding:10px;
    border-radius: 8px;
    background-color: #7ca7d5;
    margin: 200px;
        }
    </style>
<body>
    <header>
        <h1>Update Medical Details</h1>
    </header>

    <div class="container">
    <h2>Enter Medical Details</h2>
    <form method="POST" action="">
        <label for="medical_history">Medical History:</label>
        <textarea id="medical_history" name="medical_history" required><?php echo $medical_details['medical_history'] ?? ''; ?></textarea>
        
        <label for="allergies">Allergies:</label>
        <textarea id="allergies" name="allergies" required><?php echo $medical_details['allergies'] ?? ''; ?></textarea>
        
        <label for="current_medications">Current Medications:</label>
        <textarea id="current_medications" name="current_medications" required><?php echo $medical_details['current_medications'] ?? ''; ?></textarea>
        
        <label for="chronic_conditions">Chronic Conditions:</label>
        <textarea id="chronic_conditions" name="chronic_conditions" required><?php echo $medical_details['chronic_conditions'] ?? ''; ?></textarea>

        <button type="submit">Save Medical Details</button>
    </form>
    <a href="dashboard.php" class="goback">Go Back to Dashboard</a>
</div>

    
</body>
</html>
