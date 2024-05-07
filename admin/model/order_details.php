<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Bắt đầu phiên
}

ob_start(); // Bắt đầu bộ đệm đầu ra

// Bao gồm các cấu hình và tệp cần thiết
require_once '../config/config.php';
require_once '../config/order_functions.php';  // Bao gồm các hàm liên quan đến đơn hàng

// Lấy `idorder` từ tham số URL để xem chi tiết đơn hàng
$idorder = isset($_GET['idorder']) ? intval($_GET['idorder']) : 0;

$orderDetails = getOrderDetails($idorder);  // Lấy chi tiết đơn hàng

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết Đơn hàng</title>
    <style>
        /* Định dạng bảng */
        table {
            width: 100%;  /* Sử dụng toàn bộ chiều rộng */
            border-collapse: collapse;  /* Loại bỏ khoảng cách giữa các ô */
        }

        th, td {
            padding: 10px;  /* Thêm khoảng trống trong các ô */
            text-align: left;  /* Căn trái văn bản */
            border-bottom: 1px solid #ddd;  /* Thêm đường viền đáy */
        }

        th {
            background-color: #f2f2f2;  /* Màu nền cho tiêu đề bảng */
        }

        tr:hover {
            background-color: #f5f5f5;  /* Hiệu ứng hover */
        }

        /* Định dạng hình ảnh */
        img {
            max-width: 100px;  /* Giới hạn chiều rộng */
            max-height: 100px;  /* Giới hạn chiều cao */
            border-radius: 5px;  /* Làm tròn các góc */
        }

        /* Định dạng tiêu đề và văn bản */
        h2 {
            color: #333;  /* Màu tiêu đề */
            
        }

        p {
            color: #555;  /* Màu văn bản */
            display: flex;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<?php
if ($orderDetails && !empty($orderDetails)):  // Kiểm tra nếu có chi tiết đơn hàng
?>
    <h2>Chi tiết Đơn hàng: 
        <?php 
        if (isset($orderDetails[0]['madh'])) {  // Hiển thị mã đơn hàng
            echo htmlspecialchars($orderDetails[0]['madh'], ENT_QUOTES, 'UTF-8');
        } else {
            echo "Không có mã đơn hàng.";
        }
        ?>
    </h2>

    <p>Tên khách hàng: 
        <?php 
        if (isset($orderDetails[0]['name'])) {  // Hiển thị tên khách hàng
            echo htmlspecialchars($orderDetails[0]['name'], ENT_QUOTES, 'UTF-8');
        } else {
            echo "Không có tên.";
        }
        ?>
    </p>
    <p>Địa chỉ:
        <?php 
        if (isset($orderDetails[0]['address'])) {  // Hiển thị tên khách hàng
            echo htmlspecialchars($orderDetails[0]['address'], ENT_QUOTES, 'UTF-8');
        } else {
            echo "Không có tên.";
        }
        ?>
    </p>

    <p>Số điện thoại: 
        <?php 
        if (isset($orderDetails[0]['tel'])) {  // Hiển thị số điện thoại
            echo htmlspecialchars($orderDetails[0]['tel'], ENT_QUOTES, 'UTF-8');
        } else {
            echo "Không có số điện thoại.";
        }
        ?>
    </p>

    <table>
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderDetails as $detail): ?>  <!-- Vòng lặp qua các chi tiết đơn hàng -->
            <tr>
                <td>
                    <?php if (!empty($detail['img'])): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($detail['img'], ENT_QUOTES, 'UTF-8'); ?>" alt="Ảnh sản phẩm" width="50" height="50">
                    <?php else: ?>
                        Không có hình ảnh
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($detail['tensanpham'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($detail['soluong'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo number_format($detail['dongia'], 0, ',', '.') . ' VND'; ?></td>  <!-- Định dạng tiền tệ -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <p>Không có chi tiết đơn hàng.</p>  <!-- Thông báo nếu không có chi tiết đơn hàng -->
<?php endif; ?>

</body>
</html>
