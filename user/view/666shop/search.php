<?php
// Kết nối đến cơ sở dữ liệu
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'products';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$keywork = isset($_GET['keyword']) ? $_GET['keyword'] : ''; // Kiểm tra từ khóa

$sql = "SELECT id, tensanpham, img, gia FROM tbl_sanpham WHERE tensanpham LIKE ? LIMIT 10"; 
$stmt = $conn->prepare($sql);
$likeTerm = '%' . $keywork . '%';
$stmt->bind_param('s', $likeTerm);

$stmt->execute();
$result = $stmt->get_result();

$searchResults = [];
while ($row = $result->fetch_assoc()) {
    $searchResults[] = $row;
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($searchResults);

$stmt->close();
$conn->close();
?>
