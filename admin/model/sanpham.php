<div class="main">
    <h2>Sản Phẩm</h2>
    <form action="index.php?act=sanpham_add" method="post" enctype="multipart/form-data">
        <select name="iddm" id="">
            <option value="0">Chọn danh mục</option>
            <?php
                if(isset($dsdm)){
                    foreach($dsdm as $dm){
                        echo '<option value="'.$dm['id'].'">'.$dm['tendm'].'</option>';
                    }
                }
            ?>
        </select>
        <input type="text" name="tensp" id="" placeholder='Tên sản phẩm'>
        <input type="text" name="thuonghieu" id="" placeholder='Thương hiêu'>
        <input type="file" name="hinh">
        <input type="text" name="gia" id="" placeholder='Giá'>
        <input type="text" name="mota" id="" placeholder='Mô tả'>
        <input type="text" name="dungtich" id="" placeholder='Dung tích (ml)'>
        <input type="submit" name="themoi" value="Thêm mới">
    </form>
    <br>
    <table>
        <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Thương hiệu</th>
            <th>Hình ảnh</th>
            <th>Dung tích</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>

        <?php
        // Biến đếm số thứ tự
        $i = 1;

        // Kiểm tra mảng kết quả
        if (isset($kq) && is_array($kq) && count($kq) > 0) {
            foreach ($kq as $sp) { // Sử dụng tên biến rõ ràng hơn
                // Hiển thị từng dòng trong bảng sản phẩm
                echo '<tr>
                        <td>' . $i . '</td>  <!-- Số thứ tự -->
                        <td>' . $sp['tensanpham'] . '</td>  <!-- Tên sản phẩm -->
                        <td>' . $sp['thuonghieu'] . '</td>  <!-- Tên sản phẩm -->
                        <td><img src="../uploads/' . $sp['img'] . '" alt="' . $sp['tensanpham'] . '" style="width: 100px; height: auto;"></td>  <!-- Hình ảnh -->
                        <td>' . $sp['dungtich'] . '</td>  <!-- Dung tích -->
                        <td>' . number_format($sp['gia'], 0, ',', '.') . ' VND</td>  <!-- Giá -->
                        <td>' . $sp['mota'] . '</td>  <!-- Tên sản phẩm -->
                        <td>
                            <a href="index.php?act=updatespform&id=' . $sp['id'] . '">Sửa</a> |
                            <a href="index.php?act=deletesp&id=' . $sp['id'] . '">Xóa</a>
                        </td>
                    </tr>';
                $i++; // Tăng biến đếm
            }
        }
        ?>
    </table>
</div>
