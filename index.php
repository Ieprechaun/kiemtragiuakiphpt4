<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['username'])) {
    redirectToLoginPage();
}

// Xử lý đăng xuất
if (isset($_POST['logout'])) {
    logoutUser();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Hola, <?php echo $_SESSION['username']; ?>!</h1>
    
    <form action="" method="POST">
        <input type="submit" name="logout" value="Đăng xuất">
    </form>

    <?php if ($_SESSION['role'] == 'admin') : ?>
        <button onclick="location.href='add.php'">Thêm nhân viên mới</button>
    <?php endif; ?>

    <h2>THÔNG TIN NHÂN VIÊN</h2>

    <table>
        <tr>
            <th>Mã Nhân Viên</th>
            <th>Tên Nhân Viên</th>
            <th>Giới tính</th>
            <th>Nơi Sinh</th>
            <th>Tên Phòng</th>
            <th>Lương</th>
            <?php if ($_SESSION['role'] == 'admin') : ?>
                <th>Thao tác</th>
            <?php endif; ?>
        </tr>
        
        <?php displayEmployeeInformation(); ?>
    </table>

    <?php include 'pagi.php'; ?>

</body>
</html>

<?php
// Hàm chuyển hướng đến trang đăng nhập
function redirectToLoginPage() {
    header('location: login.php');
    exit();
}

// Hàm đăng xuất
function logoutUser() {
    session_destroy();
    header('location: login.php');
    exit();
}

// Hàm hiển thị thông tin nhân viên
function displayEmployeeInformation() {
    include 'config/connect.php';

    $results_per_page = 5;

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start_from = ($page - 1) * $results_per_page;

    $sql = "SELECT NHANVIEN.Ma_NV, Ten_NV, Phai, Noi_Sinh, Ten_Phong, Luong
            FROM NHANVIEN
            JOIN PHONGBAN ON NHANVIEN.Ma_Phong = PHONGBAN.Ma_Phong
            LIMIT $start_from, $results_per_page";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Ma_NV'] . "</td>";
            echo "<td>" . $row['Ten_NV'] . "</td>";
            echo "<td>";
            echo ($row['Phai'] == 'NU') ? '<img src="images/woman.jpg" alt="Woman">' : '<img src="images/man.jpg" alt="Man">';
            echo "</td>";
            echo "<td>" . $row['Noi_Sinh'] . "</td>";
            echo "<td>" . $row['Ten_Phong'] . "</td>";
            echo "<td>" . $row['Luong'] . "</td>";
            if ($_SESSION['role'] == 'admin') {
                echo '<td><a href="edit.php?id=' . $row['Ma_NV'] . '">Sửa</a> | <a href="delete.php?id=' . $row['Ma_NV'] . '">Xóa</a></td>';
            }
            echo "</tr>";
        }
    } else {
        echo "Không có dữ liệu.";
    }

    $conn->close();
}
?>
