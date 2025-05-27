<?php

session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    echo "ไม่พบรายการที่ต้องการแก้ไข";
    exit();
}

$repairId = $_GET['id'];

$sql = "SELECT repairs.*, users.username AS username, users.firstname, users.email
        FROM repairs 
        LEFT JOIN users ON repairs.user_id = users.id 
        WHERE repairs.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $repairId);
$stmt->execute();
$result = $stmt->get_result();
$repair = $result->fetch_assoc();

if (!$repair) {
    echo "ไม่พบข้อมูลรายการซ่อม";
    exit();
}
?>
<style>
    h2 {
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }
    form {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }
    select {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขสถานะการแจ้งซ่อม</title>
    <link rel="stylesheet" href="sidebar_menu\sidebar.css">
</head>
<body>
    <?php include 'sidebar_menu\sidebar.php'; ?>
    <form action="update_status.php" method="POST">
        <input type="hidden" name="id" value="<?= $repair['id'] ?>">
        
        <p><strong>รหัสอุปกรณ์:</strong> <?= htmlspecialchars($repair['device_code']) ?></p>
        <p><strong>ชื่ออุปกรณ์:</strong> <?= htmlspecialchars($repair['device_name']) ?></p>
        <p><strong>ปัญหา:</strong> <?= htmlspecialchars($repair['problem']) ?></p>
        <p><strong>เบอร์โทร:</strong> <?= htmlspecialchars($repair['phone']) ?></p>
        <p><strong>วันที่แจ้ง:</strong> <?= htmlspecialchars($repair['repair_date']) ?></p>
        <p><strong>หมายเหตุ:</strong> <?= htmlspecialchars($repair['note']) ?></p>
        <p><strong>ชื่อผู้ใช้งาน:</strong> <?= htmlspecialchars($repair['username']) ?? 'ไม่ทราบ' ?></p>
        <p><strong>ผู้แจ้ง:</strong> <?= htmlspecialchars($repair['firstname']) ?? 'ไม่ทราบ' ?></p>
        <p><strong>อีเมล:</strong> <?= htmlspecialchars($repair['email']) ?? 'ไม่ทราบ' ?></p>

        <label for="status"><strong>สถานะ:</strong></label>
        <select name="status" id="status">
            <option value="pending" <?= $repair['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="in_progress" <?= $repair['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
            <option value="completed" <?= $repair['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
        </select>

        <br><br>
        <button type="submit">อัปเดตสถานะ</button>
    </form>
</body>
</html>
