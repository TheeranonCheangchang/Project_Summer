<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager' && $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// ดึงข้อมูลผู้ใช้ทั้งหมด
$sql = "SELECT users.id, username, firstname, lastname, email, role, categories.name AS department_name
        FROM users 
        LEFT JOIN categories ON users.category_id = categories.id 
        WHERE role = 'employee'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการผู้ใช้งาน</title>
    <link rel="stylesheet" href="sidebar_menu\sidebar.css">
    <style>
    .container {
        max-width: 900px;
        margin: 50px auto;
        padding: 30px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
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

        table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                border-radius: 10px;
                overflow:initial;
            }
            th, td {
                padding: 12px;
                border-bottom: 1px solid #ddd;
                color: black;
            }
            th {
                background: rgba(0, 0, 0, 0.3);
            }
            button {
                width: 50%;
                padding: 2px;
                background: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
                transition: 0.3s;
            }
            button:hover {
                background: #0056b3;
            }
    </style>
</head>
<body>
    <?php include 'sidebar_menu\sidebar.php'; ?>
    <div class="container">
        <h2>จัดการผู้ใช้งาน</h2>
        <table>
            <tr>
                <th>รหัส</th>
                <th>ชื่อผู้ใช้งาน</th>
                <th>ชื่อจริง</th>
                <th>นามสกุล</th>
                <th>แผนก</th>
                <th>อีเมล</th>
                <th>หน้าที่</th>
                <th>รายละเอียด</th>
            </tr>
            <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                <td><?php echo htmlspecialchars($user['department_name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn edit-btn">Edit</a>
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="register_employee.php" class="add-user">เพิ่มพนักงานใหม่</a>
        <a href="add_admin.php" class="add-user">เพิ่มผู้ดูแลใหม่</a>
    </div>
</body>
</html>
