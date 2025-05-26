<?php

session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    echo "ไม่พบรายการที่ต้องการแก้ไข";
    exit();
}

$repairId = $_GET['id'];

$sql = "SELECT repairs.*, users.username 
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

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขสถานะการแจ้งซ่อม</title>
</head>
<body>
    <h2>รายละเอียดการแจ้งซ่อม</h2>

    <form action="update_status.php" method="POST">
        <input type="hidden" name="id" value="<?= $repair['id'] ?>">

        <p><strong>รหัสอุปกรณ์:</strong> <?= htmlspecialchars($repair['device_code']) ?></p>
        <p><strong>ชื่ออุปกรณ์:</strong> <?= htmlspecialchars($repair['device_name']) ?></p>
        <p><strong>ปัญหา:</strong> <?= htmlspecialchars($repair['problem']) ?></p>
        <p><strong>เบอร์โทร:</strong> <?= htmlspecialchars($repair['phone']) ?></p>
        <p><strong>วันที่แจ้ง:</strong> <?= htmlspecialchars($repair['repair_date']) ?></p>
        <p><strong>หมายเหตุ:</strong> <?= htmlspecialchars($repair['note']) ?></p>
        <p><strong>ผู้แจ้ง:</strong> <?= htmlspecialchars($repair['username']) ?? 'ไม่ทราบ' ?></p>

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
