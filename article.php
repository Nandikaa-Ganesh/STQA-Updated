<?php
include 'database.php';

if (isset($_GET['id'])) {
    $article_id = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->bind_param("i", $article_id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $article = $result->fetch_assoc();
    } else {
        echo "Error fetching article: " . $stmt->error;
    }
} else {
    header("Location: dashboard.php"); // Redirect if no article ID is provided
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $article['title'] ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="article-content">
        <h1><?= $article['title'] ?></h1>
        <p><?= nl2br($article['content']) ?></p>
        <a href="dashboard.php" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>
