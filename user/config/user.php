<?php
function checkuser($user, $pass) {
    $conn = connectdb();  // Kết nối cơ sở dữ liệu
    
    // Tạo chuỗi băm MD5 từ mật khẩu đầu vào
     
    
    // Chuẩn bị và thực hiện truy vấn
    $stmt = $conn->prepare("SELECT role, pass FROM tbl_users WHERE user = ?");
    $stmt->execute([$user]);
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);  // Lấy kết quả
    
    // Kiểm tra nếu chuỗi băm mật khẩu đầu vào khớp với mật khẩu đã lưu
    if ($result && $result['pass'] === md5($pass)) {
        return $result['role'];  // Trả về vai trò nếu đúng
    }
    
    return -1;  // Trả về -1 nếu sai hoặc không tìm thấy
}

?>
