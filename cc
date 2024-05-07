case 'thanhtoan':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = isset($_SESSION['user']['id']) ? intval($_SESSION['user']['id']) : 0;
            $tongdonhang = $_POST['tongdonhang'] ?? 0;
            $name = $_POST['name'] ?? '';
            $address = $_POST['address'] ?? '';
            $email = $_POST['email'] ?? '';
            $tel = $_POST['tel'] ?? '';
            $payment_method = $_POST['payment_method'] ?? '';
            $madh = "SLX" . rand(0, 9999999); // ID đơn hàng duy nhất
    
            // Gọi hàm `taodonhang()` với đủ 8 đối số, bao gồm `user_id`
            $iddh = taodonhang($madh, $tongdonhang, $user_id, $name, $address, $email, $tel, $payment_method);
    
            if ($iddh) {
                foreach ($_SESSION['giohang'] as $item) {
                    addtocart($iddh, $item['id'], $item['tensp'], $item['img'], $item['gia'], $item['quantity'], $user_id);
                }
    
                unset($_SESSION['giohang']); // Xóa giỏ hàng sau thanh toán
            }
    
            header("Location: index.php?act=home"); // Chuyển hướng sau thanh toán
            exit;
        }
        break;
        case "addcart":
        if (isset($_POST['addtocart'])) {
            $product_id = $_POST['product_id'] ?? 0;
            $product_name = $_POST['product_name'] ?? 'Unknown Product';
            $product_image = $_POST['product_image'] ?? 'default-image.png';
            $product_price = $_POST['product_price'] ?? 0;
            $quantity = 1; // Số lượng mặc định

            if (!isset($_SESSION['giohang'])) {
                $_SESSION['giohang'] = []; // Khởi tạo giỏ hàng nếu chưa có
            }

            $exists = false;
            foreach ($_SESSION['giohang'] as &$item) {
                if ($item['id'] === $product_id) {
                    $item['quantity'] += 1; // Tăng số lượng nếu đã tồn tại
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                $new_item = [
                    'id' => $product_id,
                    'tensp' => $product_name,
                    'img' => $product_image,
                    'gia' => $product_price,
                    'quantity' => $quantity
                ];
                $_SESSION['giohang'][] = $new_item; // Thêm sản phẩm mới vào giỏ hàng
            }

            header("Location: index.php?act=cart"); // Chuyển hướng đến giỏ hàng
            exit;
        }

        include("../view/666shop/viewcart.php"); // Đảm bảo hành động không bị chồng chéo
        break;