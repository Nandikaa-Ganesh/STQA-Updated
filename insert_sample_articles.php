<?php
include 'database.php';

// Sample articles data
$articles = [
    [
        'title' => 'How to Measure Your Blood Pressure at Home',
        'content' => 'Measuring your blood pressure at home can help you keep track of your health...'
    ],
    [
        'title' => '5 Common Health Tests You Can Do at Home',
        'content' => 'Here are some simple tests you can do at home to monitor your health...'
    ],
    [
        'title' => 'Understanding Your Cholesterol Levels',
        'content' => 'Cholesterol levels can be measured at home with a simple kit...'
    ],
];

foreach ($articles as $article) {
    $stmt = $conn->prepare("INSERT INTO articles (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $article['title'], $article['content']);
    $stmt->execute();
}

echo "Sample articles added successfully!";
?>
