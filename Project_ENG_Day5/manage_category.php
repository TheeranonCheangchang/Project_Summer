<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager' && $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit();
}


$categories = $conn->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการแผนก</title>
    <link rel="stylesheet" href="sidebar_menu\sidebar.css">
</head>
<body>
    <?php include 'sidebar_menu\sidebar.php'; ?>
    <div class="container">
        <h2>จัดการแผนก</h2>
        <table>
            <tr>
                <th>รหัส</th>
                <th>ชื่อแผนก</th>
                <th>รายละเอียด</th>
            </tr>
            <?php while ($category = $categories->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($category['id']); ?></td>
                <td><?php echo htmlspecialchars($category['name']); ?></td>
                <td>
                    <form action="edit_category.php" method="get" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                        <button type="submit" class="edit-btn">Edit</button>
                    </form>
                    <form action="delete_category.php" method="get" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="add_category.php" class="add-category">เพิ่มแผนกใหม่</a>
    </div>
</body>
</html>