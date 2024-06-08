<?php
// Include the database connection file
require 'db_connect.php';

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)");
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("ssss", $matric, $name, $hashed_password, $role);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set parameters and execute
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    // Hash the password before storing it
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (empty($matric) || empty($name) || empty($role) || empty($hashed_password)) {
        echo "All fields are required.";
    } else {
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . htmlspecialchars($stmt->error);
        }
    }
}

// Debugging: Print submitted POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}

$stmt->close();
$conn->close();
?>
