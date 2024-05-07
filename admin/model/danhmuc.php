<div class="main">
    <h2>Danh Mục</h2>
    <form action="index.php?act=adddm" method="post">
        <input type="text" name="tendm" placeholder="Tên danh mục" id="">
        <input type="submit" name="themoi" value="Thêm mới">
    </form>
    <br>
    <table>
        <tr>
            <th>STT</th>
            <th>Tên Danh Mục</th>
            <th>Ưu tiên</th>
            <th>Hiển thị</th>
            <th>Hành động</th>
        </tr>

        <?php
        // Khởi tạo biến $i để đếm số thứ tự
        $i = 1;

        // Kiểm tra mảng $kq và duyệt qua từng phần tử
        if (isset($kq) && is_array($kq) && count($kq) > 0) {
            foreach ($kq as $dm) {
                echo '<tr>
                        <td>' . $i . '</td>
                        <td>' . $dm['tendm'] . '</td>
                        <td>' . $dm['uutien'] . '</td>
                        <td>' . $dm['hienthi'] . '</td>
                        <td>
                            <a href="index.php?act=updateform&id='. $dm['id'] .'">Sửa</a>
                            <a href="index.php?act=deletedm&id='. $dm['id'] .'">Xóa</a>
                        </td>
                    </tr>';
                $i++; // Tăng biến đếm STT
            }
        } 
        ?>

    </table>
</div>
