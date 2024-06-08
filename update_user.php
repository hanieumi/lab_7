<?php
session_start(); 
require 'db_connect.php';

$matric = $_GET['matric'];
$sql = "SELECT * FROM users WHERE matric='$matric'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 50px;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
        }
    </style>
</head>
<body>

    <h2 class="text-center">Update User</h2> 
    <div class="form-container">
        <!-- Form content -->
    </div>

    <div class="form-container">
        <form action="display_users.php" method="post">
            <input type="hidden" name="originalMatric" value="<?php echo $matric; ?>">
            <div class="form-group">
                <label for="newMatric">Matric:</label>
                <input type="text" class="form-control" id="newMatric" name="newMatric" value="<?php echo $row['matric']; ?>" required>
            </div>
            <div class="form-group">
                <label for="newName">Name:</label>
                <input type="text" class="form-control" id="newName" name="newName" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="newRole">Access Level:</label>
                <select class="form-control" id="newRole" name="newRole" required>
                    <option value="lecturer" <?php if($row['role'] == 'lecturer') echo 'selected'; ?>>Lecturer</option>
                    <option value="student" <?php if($row['role'] == 'student') echo 'selected'; ?>>Student</option>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-success">Update</button>
            <a href="display_users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
