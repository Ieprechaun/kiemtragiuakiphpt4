<?php
include 'config/connect.php';

// Chuẩn bị truy vấn
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM NHANVIEN");
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();

$total_pages = ceil($total / 5);

echo "<div style='text-align: center;'>";

for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='index.php?page=".$i."'>".$i."</a> ";
}

echo "</div>";

// Đóng kết nối
$stmt->close();
$conn->close();
?>
