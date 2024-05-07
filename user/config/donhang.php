<?php


function taodonhang($madh, $tongdonhang, $payment_method, $name, $address, $email, $tel) {
    $conn = connectdb();
    if ($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO tbl_order (madh, tongdonhang, pttt, name, address, email, tel) 
                                    VALUES (:madh, :tongdonhang, :pttt, :name, :address, :email, :tel)");
            $stmt->execute([
                ':madh' => $madh,
                ':tongdonhang' => $tongdonhang,
                ':pttt' => htmlspecialchars($payment_method, ENT_QUOTES, 'UTF-8'),
                ':name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
                ':address' => htmlspecialchars($address, ENT_QUOTES, 'UTF-8'),
                ':email' => $email,
                ':tel' => htmlspecialchars($tel, ENT_QUOTES, 'UTF-8')
            ]);

            return $conn->lastInsertId();  // Trả về ID đơn hàng
        } catch (PDOException $e) {
            error_log("Lỗi khi tạo đơn hàng: " . $e->getMessage());
            return 0;
        }
    } else {
        error_log("Kết nối cơ sở dữ liệu thất bại.");
        return 0;
    }
}

?>