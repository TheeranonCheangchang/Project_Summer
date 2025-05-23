<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_POST['new_repair'])) {

    $device_name = mysqli_real_escape_string($conn, $_POST['device_name']);
    $issue = mysqli_real_escape_string($conn, $_POST['issue']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $repair_date = mysqli_real_escape_string($conn, $_POST['repair_date']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    
    if (empty($device_name) || empty($issue) || empty($contact_number) || empty($repair_date)) {
        echo "<script>alert('Please fill all required fields!'); window.history.back();</script>";
        exit();
    }

    $sql = "INSERT INTO repairs (device_name, issue, contact_number, repair_date, remarks) VALUES ('$device_name', '$issue', '$contact_number', '$repair_date', '$remarks')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Repair details submitted successfully!'); window.location='manage_repairs.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งรายละเอียดของซ่อม</title>
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
        input {
            width: 96%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
            margin-top: 15px;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>แจ้งรายละเอียดของซ่อม</h2>
        <form method="POST" action="new_repair.php">
            <label>รหัสอุปกรณ์</label>
            <input type="text" name="device_name" required>

            <label>ชื่ออุปกรณ์</label>
            <input type="text" name="device_name" required>
            
            <label>ปัญหาที่พบ</label>
            <input type="text" name="issue" required>
            
            <label>เบอร์โทรศัพท์</label>
            <input type="text" name="contact_number" required>
            
            <label>วันที่แจ้งซ่อม</label>
            <input type="date" name="repair_date" required>
            
            <label>หมายเหตุ</label>
            <input type="text" name="remarks">
            
            <button type="submit" name="new_repair">แจ้งซ่อม</button>
        </form>
    </div>
</body>
</html>
