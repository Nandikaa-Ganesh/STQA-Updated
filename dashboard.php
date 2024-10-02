<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// Fetch articles
$article_stmt = $conn->prepare("SELECT * FROM articles");
if ($article_stmt->execute()) {
    $article_result = $article_stmt->get_result();
    $articles = $article_result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error fetching articles: " . $article_stmt->error;
}


$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT a.id, a.appointment_date, d.name as doctor_name, d.specialization FROM appointments a JOIN doctors d ON a.doctor_id = d.id WHERE a.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);
$appointment_stmt = $conn->prepare("
    SELECT a.id, d.name AS doctor_name, d.specialization, a.appointment_date 
    FROM appointments a 
    JOIN doctors d ON a.doctor_id = d.id 
    WHERE a.user_id = ?
");
$appointment_stmt->bind_param("i", $_SESSION['user_id']);
$appointment_stmt->execute();
$appointments_result = $appointment_stmt->get_result();
$appointments = $appointments_result->fetch_all(MYSQLI_ASSOC);
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM medical_details WHERE user_id = $user_id";
$result = $conn->query($sql);
$medical_details = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dash-style.css">
</head>
<body>
    <header style="padding:10px 50px;">
        <h1>Your Appointments</h1>
        <a href="book_appointment.php" class="book-btn">Book a New Appointment</a>
        <a href="index.php" class="logout-btn">Logout</a>
        
    </header>
    <h2>Profile</h2>
    <div style="padding:10px 50px;">
    <h3>Medical Information</h3>
        <p><strong>Medical History:</strong> <?php echo !empty($medical_details['medical_history']) ? $medical_details['medical_history'] : 'N/A'; ?></p>
        <p><strong>Allergies:</strong> <?php echo !empty($medical_details['allergies']) ? $medical_details['allergies'] : 'N/A'; ?></p>
        <p><strong>Current Medications:</strong> <?php echo !empty($medical_details['current_medications']) ? $medical_details['current_medications'] : 'N/A'; ?></p>
        <p><strong>Chronic Conditions:</strong> <?php echo !empty($medical_details['chronic_conditions']) ? $medical_details['chronic_conditions'] : 'N/A'; ?></p>
        
        <form action="export_pdf.php" method="post" style="margin:30px;">
        <a href="medical_details.php" style="text-decoration:none; padding:20px; margin:50px; background-color:blue; color:white; border-radius:20px;">Edit Medical Details</a>
            <input type="submit" style="text-decoration:none; padding:20px; margin:50px; background-color:blue; color:white; border-radius:20px; font-family:Inter; font-size: 100;" value="Export as PDF">
        </form>
    </div>
    <main style="padding:10px 50px;">
        <h2>Booked Appointments</h2>
        <div class="appointment-cards">
            <?php foreach ($appointments as $appointment): ?>
                <div class="card">
                    <h3>Appointment ID: <?= $appointment['id'] ?></h3>
                    <p>Date: <?= $appointment['appointment_date'] ?></p>
                    <p>Doctor: <?= $appointment['doctor_name'] ?></p>
                    <p>Specialization: <?= $appointment['specialization'] ?></p>
            <form method="POST" action="delete_appointment.php" style="display:inline;" >
                <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                <button type="submit" onclick="return confirm('Are you sure you want to delete this appointment?');" class="delete-btn">Delete</button>
            </form>
                </div>
            <?php endforeach; ?>
        </div>
        

        <h2>Common Health Articles</h2>
<div class="article-container" style="padding:10px 50px;">
    <?php foreach ($articles as $article): ?>
        <div class="article-card">
            <h3><?= $article['title'] ?></h3>
            <a href="article.php?id=<?= $article['id'] ?>" class="read-more">Read More</a>
        </div>
    <?php endforeach; ?>
</div>

    </main>
</body>
</html>
