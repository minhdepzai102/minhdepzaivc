<?php
// Bước 1: Kết nối cơ sở dữ liệu
$host = 'localhost';  // Tên máy chủ
$user = 'root';  // Tên người dùng
$password = '';  // Mật khẩu
$dbname = 'products';  // Tên cơ sở dữ liệu

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Bước 2: Truy vấn sản phẩm theo ID
$product_id = $_GET['id'];  // Giả định ID sản phẩm được truyền qua URL
$sql = "SELECT * FROM tbl_sanpham WHERE id = $product_id";
$result = $conn->query($sql);
?>
<?php
// Kiểm tra nếu nút "Add To Cart" được nhấn
if (isset($_GET['submit']) && $_GET['submit'] === 'addtocard') {
    if (!isset($_SESSION['giohang'])) {
        $_SESSION['giohang'] = array(); // Khởi tạo giỏ hàng nếu chưa có
    }

    // Lấy thông tin sản phẩm và số lượng
    $product_id = intval($_GET['id']); // Chuyển đổi sang số nguyên để tránh SQL Injection
    $quantity = intval($_GET['product-quanity']);

    // Kiểm tra sản phẩm trong giỏ hàng
    $found = false;
    foreach ($_SESSION['giohang'] as &$item) {
        if ($item['id'] === $product_id) {
            $item['quantity'] += $quantity; // Tăng số lượng nếu đã có
            $found = true;
            break;
        }
    }

    if (!$found) {
        $sql = "SELECT * FROM tbl_sanpham WHERE id = $product_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $new_item = array(
                'id' => $product_id,
                'img' => $product['img'],
                'tensp' => $product['tensanpham'],
                'gia' => $product['gia'],
                'quantity' => $quantity
            );
            $_SESSION['giohang'][] = $new_item; // Thêm sản phẩm mới
        }
    }

    header("Location: index.php?act=cart"); // Chuyển hướng đến trang giỏ hàng
    exit;
}
if (isset($_GET['submit']) && $_GET['submit'] === 'buy') {
    // Bạn có thể thêm mã xử lý để tạo đơn hàng và lưu vào cơ sở dữ liệu.
    // Hiện tại, chỉ chuyển hướng đến trang thanh toán.

    header("Location: checkout.php"); // Chuyển hướng đến trang thanh toán
    exit;
}

?>
<?php
// Kiểm tra nếu nút "Buy Now" được nhấn
if (isset($_GET['submit']) && $_GET['submit'] === 'buy') {
    // Xử lý hành động mua ngay, có thể là thêm vào đơn hàng và chuyển hướng tới thanh toán
    // Bạn có thể đặt mã xử lý đơn hàng tại đây, hoặc chuyển hướng tới trang thanh toán

    // Ví dụ: Chuyển hướng tới trang thanh toán
    header("Location: checkout.php");
    exit;
}
?>




<!-- Modal -->
<div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="w-100 pt-1 mb-5 text-right">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="get" class="modal-content modal-body border-0 p-0">
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                <button type="submit" class="input-group-text bg-success text-light">
                    <i class="fa fa-fw fa-search text-white"></i>
                </button>
            </div>
        </form>
    </div>
</div>



<!-- Open Content -->
<section class="bg-light">
    <?php
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo '<div class="container pb-5">
         <div class="row">
             <div class="col-lg-5 mt-5">
                 <div class="card mb-3">
                 <img class="card-img img-fluid" src="../../admin/uploads/' . $product['img'] . '" alt="' . $product['tensanpham'] . '">;
                 </div>
                 <div class="row">
                     <!--Start Controls-->

                     <!--End Controls-->
                     <!--Start Carousel Wrapper-->
                     <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item" data-bs-ride="carousel">
                         <!--Start Slides-->
                         <div class="carousel-inner product-links-wap" role="listbox">

                          </div>   
                         <!--End Slides-->
                     </div>
                     <!--End Carousel Wrapper-->
                     <!--End Controls-->
                 </div>
             </div>
             <!-- col end -->
             <div class="col-lg-7 mt-5">
                 <div class="card">
                     <div class="card-body">
                     <h1 class="h2">' . $product['tensanpham'] . '</h1>
                     <p class="h3 py-2">' . number_format($product['gia'], 0, ',', '.') . ' VND</p>
                         <ul class="list-inline">
                             <li class="list-inline-item">
                                 <h6>Brand:</h6>
                             </li>
                             <li class="list-inline-item">
                                 <p class="text-muted"><strong>' . $product['thuonghieu'] . '</strong></p>
                             </li>
                         </ul>

                         <h6>Description:</h6>
                         <p>' . $product['mota'] . '</p>
                         

                         <form action="" method="GET">
                             <input type="hidden" name="product-title" value="Activewear">
                             <div class="row">
                                 <div class="col-auto">
                                     <ul class="list-inline pb-3">
                                         <li class="list-inline-item">Capacity: 
                                             <input type="hidden" name="product-size" id="product-size" value="S">
                                         </li>
                                         <li class="list-inline-item"><span class="btn btn-success btn-size">' . $product['dungtich'] . '</span></li>
                                     </ul>
                                 </div>
                                 <div class="col-auto">
                                     <ul class="list-inline pb-3">
                                         <li class="list-inline-item text-right">
                                             Quantity
                                             <input type="hidden" name="product-quanity" id="product-quanity" value="1">
                                         </li>
                                         <li class="list-inline-item"><span class="btn btn-success" id="btn-minus">-</span></li>
                                         <li class="list-inline-item"><span class="badge bg-secondary" id="var-value">1</span></li>
                                         <li class="list-inline-item"><span class="btn btn-success" id="btn-plus">+</span></li>
                                     </ul>
                                 </div>
                             </div>
                             <!-- Form để xử lý thêm vào giỏ hàng và mua ngay -->
<form action="" method="GET">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($product_id, ENT_QUOTES); ?>">
    <input type="hidden" name="product-quanity" value="1"> <!-- Số lượng mặc định là 1 -->

    <div class="row pb-3">
        <div class="col d-grid">
            <button type="submit" class="btn btn-success btn-lg" name="submit" value="buy">Buy Now</button>
        </div>
        <div class="col d-grid">
            <button type="submit" class="btn btn-success btn-lg" name="submit" value="addtocard">Add To Cart</button>
        </div>
    </div>
</form>


                         </form>

                     </div>
                 </div>
             </div>
         </div>
     </div>';
    }
    ?>

    <!-- Close Content -->

    <!-- Start Article -->

    <!-- End Article -->


    <!-- Start Footer -->

    <!-- End Footer -->

    <!-- Start Script -->
    <script src="../view/666shop/../view/666shop/assets/js/jquery-1.11.0.min.js"></script>
    <script src="../view/666shop/../view/666shop/assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="../view/666shop/../view/666shop/assets/js/bootstrap.bundle.min.js"></script>
    <script src="../view/666shop/../view/666shop/assets/js/templatemo.js"></script>
    <script src="../view/666shop/../view/666shop/assets/js/custom.js"></script>
    <!-- End Script -->

    <!-- Start Slider Script -->
    <script src="../view/666shop/assets/js/slick.min.js"></script>
    <script>
        $('#carousel-related-product').slick({
            infinite: true,
            arrows: false,
            slidesToShow: 4,
            slidesToScroll: 3,
            dots: true,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3
                }
            }
            ]
        });
    </script>
    <script>
        // Lấy các phần tử theo ID
        var btnMinus = document.getElementById("btn-minus");
        var btnPlus = document.getElementById("btn-plus");
        var varValue = document.getElementById("var-value");

        // Thêm sự kiện "click" cho nút giảm
        btnMinus.addEventListener("click", function () {
            var currentValue = parseInt(varValue.innerText); // Chuyển đổi sang số nguyên
            if (currentValue > 1) { // Không cho phép giá trị nhỏ hơn 1
                varValue.innerText = currentValue - 1; // Giảm giá trị
            }
        });

        // Thêm sự kiện "click" cho nút tăng
        btnPlus.addEventListener("click", function () {
            var currentValue = parseInt(varValue.innerText); // Chuyển đổi sang số nguyên
            varValue.innerText = currentValue + 1; // Tăng giá trị
        });
    </script>
    <!-- End Slider Script -->