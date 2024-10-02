<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];

    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $appointment_id, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php"); // Redirect back to the dashboard
    } else {
        echo "Error deleting appointment: " . $stmt->error;
    }
} else {
    header("Location: dashboard.php"); // Redirect if accessed directly
    exit();
}
?>
