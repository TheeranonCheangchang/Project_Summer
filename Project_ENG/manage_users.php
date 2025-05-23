<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// ดึงข้อมูลผู้ใช้ทั้งหมด
$result = $conn->query("SELECT id, username, firstname, lastname, email, role FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            color: black;
        }
        th {
            background: rgba(0, 0, 0, 0.3);
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }
        .edit-btn {
            background: #007bff;
            color: white;
        }
        .edit-btn:hover {
            background: #0056b3;
        }
        .delete-btn {
            background: #dc3545;
            color: white;
        }
        .delete-btn:hover {
            background: #c82333;
        }
        .add-user {
            margin-top: 20px;
            display: inline-block;
            padding: 12px 20px;
            background: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }
        .add-user:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn edit-btn">Edit</a>
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            
            <?php endwhile; ?>
        </table>
        <a href="register_employee.php" class="add-user">Add New Employee</a>
    </div>
</body>
</html>
