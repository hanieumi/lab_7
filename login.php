<?php
session_start();
require 'db_connect.php';

if(isset($_SESSION['matric'])) {
    header("Location: display_users.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE matric='$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['matric'] = $matric;
            header("Location: display_users.php");
            exit();
        } else {
            echo "Invalid password, try <a href='login.html'>login</a> again.";
        }
    } else {
        echo "Invalid username or password, try <a href='login.html'>login</a> again.";
    }
}

$conn->close();
?>
