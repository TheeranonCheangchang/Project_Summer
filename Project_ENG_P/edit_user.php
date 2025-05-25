<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('Invalid user ID!'); window.location='manage_users.php';</script>";
    exit();
}
$id = intval($_GET['id']);

$result = $conn->query("SELECT id, username, firstname, lastname, email, role FROM users WHERE id = $id");
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('User not found!'); window.location='manage_users.php';</script>";
    exit();
}

if (isset($_POST['update_user'])) {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', email='$email', role='$role' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User updated successfully!'); window.location='manage_users.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ddd;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }
        h2 {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
            margin-top: 15px;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <form method="POST" action="edit_user.php?id=<?php echo $user['id']; ?>">
            <label>Username (Cannot be changed):</label>
            <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
            
            <label>First Name:</label>
            <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
            
            <label>Last Name:</label>
            <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            
            <label>Role:</label>
            <select name="role" required>
                <option value="manager" <?php echo ($user['role'] == 'manager') ? 'selected' : ''; ?>>Manager</option>
                <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="Employee" <?php echo ($user['role'] == 'Employee') ? 'selected' : ''; ?>>Employee</option>
            </select>
            
            <button type="submit" name="update_user">Update User</button>
        </form>
    </div>
</body>
</html>
