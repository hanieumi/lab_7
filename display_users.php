<?php
session_start(); // Insert session_start() here
require 'db_connect.php';

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['matric'])) {
    header("Location: login.html");
    exit();
}

// Logout functionality
if (isset($_GET['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    header("Location: login.html");
    exit();
}

if (isset($_POST['delete'])) {
    $matricToDelete = $_POST['matricToDelete'];
    $sql = "DELETE FROM users WHERE matric='$matricToDelete'";
    $conn->query($sql);
}

if (isset($_POST['update'])) {
    $originalMatric = $_POST['originalMatric'];
    $newMatric = $_POST['newMatric'];
    $newName = $_POST['newName'];
    $newRole = $_POST['newRole'];
    $sql = "UPDATE users SET matric='$newMatric', name='$newName', role='$newRole' WHERE matric='$originalMatric'";
    $conn->query($sql);
}

$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .logout-button {
            text-align: right;
            margin-top: 10px;
        }
        .user-table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center; 
        }
        td {
            border-bottom: 1px solid #ddd;
        }
        .text-center {
            text-align: center;
        }
        .logout-button a {
            color: white;
            background-color: #007bff; /* Bootstrap primary blue */
        }
        .center-title {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logout-button">
            <a href="display_users.php?logout=true" class="btn btn-primary">Logout</a>
        </div>
        <div class="user-table-container">
            <h2 class="my-4 center-title">Users</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Matric</th>
                        <th>Name</th>
                        <th>Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='text-center'>" . $row["matric"] . "</td>"; // Center-align Matric column
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td class='text-center'>" . $row["role"] . "</td>"; // Center-align Level column
                            echo "<td class='text-center'> <!-- Added text-center class here -->
                                    <form action='display_users.php' method='post' style='display:inline;'>
                                        <input type='hidden' name='matricToDelete' value='" . $row["matric"] . "'>
                                        <input type='submit' name='delete' value='Delete' class='btn btn-danger'>
                                    </form>
                                    <form action='update_user.php' method='get' style='display:inline;'>
                                        <input type='hidden' name='matric' value='" . $row["matric"] . "'>
                                        <input type='submit' value='Update' class='btn btn-warning'>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No results found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
