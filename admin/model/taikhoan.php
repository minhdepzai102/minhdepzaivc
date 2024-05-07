<?php
// Thay vì `include`, sử dụng `include_once` hoặc `require_once`
require_once("../config/config.php");

function updateUserRole($id, $role) {
    $conn = connectdb();  // Kết nối cơ sở dữ liệu
    if ($conn) {
        $stmt = $conn->prepare("UPDATE tbl_users SET role = ? WHERE id = ?");
        return $stmt->execute([$role, $id]);  // Cập nhật vai trò
    }
    return false;  // Nếu không kết nối được
}
function getAllUsers() {
    $conn = connectdb();  // Kết nối cơ sở dữ liệu
    if ($conn) {
        $stmt = $conn->prepare("SELECT id, user, role FROM tbl_users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Lấy danh sách người dùng
    }
    return [];  // Nếu không kết nối được
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_role'])) {
    $id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;  // Lấy ID người dùng
    $role = isset($_POST['role']) ? intval($_POST['role']) : 0;  // Lấy vai trò mới
    
    if ($id > 0 && updateUserRole($id, $role)) {  // Nếu ID hợp lệ và cập nhật thành công
        header("Location: index.php?act=taikhoan");  // Chuyển hướng sau khi cập nhật
        exit();
    } else {
        echo "Failed to update role.";  // Nếu cập nhật thất bại
    }
}
$users = getAllUsers(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>User List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8'); ?></td>  <!-- Bảo mật đầu vào -->
                <td><?php echo htmlspecialchars($user['user'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo ($user['role'] == 1) ? 'Admin' : 'User'; ?></td>
                <td>
                    <!-- Nút hoặc liên kết để mở biểu mẫu sửa -->
                    <button onclick="openEditModal(<?php echo $user['id']; ?>)">Edit Role</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Biểu mẫu sửa vai trò -->
    <div id="editModal" style="display: none;">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="post">  <!-- Bảo mật đầu vào -->
            <input type="hidden" id="user_id" name="user_id">  <!-- ID người dùng -->
            <label for="role">New Role:</label>
            <select name="role" id="role">  <!-- Chọn vai trò -->
                <option value="1">Admin</option>
                <option value="0">User</option>
            </select>
            <button type="submit" name="update_role">Update</button>
        </form>
    </div>

    <!-- JavaScript để mở cửa sổ modal và thiết lập giá trị ID -->
    <script>
        function openEditModal(userId) {
            document.getElementById('user_id').value = userId;  // Đặt ID người dùng
            document.getElementById('editModal').style.display = 'block';  // Hiển thị modal
        }
    </script>

</body>
</html>