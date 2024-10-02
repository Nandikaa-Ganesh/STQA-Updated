<?php
include 'database.php';

// Sample doctors data
$doctors = [
    ['name' => 'Dr. Alice Smith', 'specialization' => 'Pediatrician'],
    ['name' => 'Dr. Bob Johnson', 'specialization' => 'Dermatologist'],
    ['name' => 'Dr. Carol Williams', 'specialization' => 'Cardiologist'],
    ['name' => 'Dr. David Brown', 'specialization' => 'Orthopedic'],
    ['name' => 'Dr. Emma Davis', 'specialization' => 'Neurologist'],
];

foreach ($doctors as $doctor) {
    $stmt = $conn->prepare("INSERT INTO doctors (name, specialization) VALUES (?, ?)");
    $stmt->bind_param("ss", $doctor['name'], $doctor['specialization']);
    $stmt->execute();
}

echo "Sample doctors added successfully!";
?>
