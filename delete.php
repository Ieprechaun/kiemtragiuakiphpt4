<?php
session_start();

// Kiểm tra quyền truy cập
checkAccess();

// Xử lý xóa nhân viên
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    deleteEmployee();
}

function checkAccess() {
    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
        header('location: login.php');
        exit(); 
    }

    if (!isset($_GET['id'])) {
        header('location: index.php');
        exit();
    }
}

function deleteEmployee() {
    
    include 'config/connect.php';

    
    $ma_nv = $_GET['id'];

  
    $sql = "DELETE FROM NHANVIEN WHERE Ma_NV = '$ma_nv'";

    if ($conn->query($sql) === TRUE) {
        header('location: index.php');
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }

    $conn->close();
}
?>
