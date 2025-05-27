<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "UPDATE repairs SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดต";
    }
}
?>