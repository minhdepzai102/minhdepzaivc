<?php
function getPaymentMethodDescription($pttt) {
    switch ($pttt) {
        case 1:
            return "Cash on Delivery";  // Tiền mặt khi giao hàng
        case 2:
            return "Credit Card";  // Thẻ tín dụng
        case 3:
            return "Bank Transfer";  // Chuyển khoản ngân hàng
        case 4:
            return "E-Wallet";  // Ví điện tử
        default:
            return "Unknown";  // Giá trị không xác định
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Đơn hàng</title>
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

        /* Đảm bảo các cột nằm thẳng hàng */
        td {
            vertical-align: middle;  /* Căn giữa theo chiều dọc */
        }

        /* Định dạng liên kết */
        a {
            color: #0066cc;  /* Màu xanh cho liên kết */
            text-decoration: none;  /* Không có gạch chân */
        }

        a:hover {
            text-decoration: underline;  /* Gạch chân khi hover */
        }

        /* Định dạng ảnh */
        img {
            max-width: 50px;  /* Giới hạn chiều rộng của ảnh */
            max-height: 50px;  /* Giới hạn chiều cao của ảnh */
            border-radius: 5px;  /* Làm tròn các góc */
        }
    </style>
</head>
<body>

<h2>Danh sách Đơn hàng</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Mã Đơn hàng</th>
            <th>Tổng Đơn hàng</th>
            <th>Phương thức Thanh toán</th>
            <th>Tên Khách hàng</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo htmlspecialchars($order['id'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($order['madh'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo number_format($order['tongdonhang'], 0, ',', '.') . ' VND'; ?></td>  <!-- Định dạng tiền tệ -->
            <td><?php echo htmlspecialchars(getPaymentMethodDescription($order['pttt']), ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($order['name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($order['trangthai'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
                <a href="index.php?act=donhang&idorder=<?php echo $order['id']; ?>">Xem Chi tiết</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
