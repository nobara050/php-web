<?php
    include 'inc/header.php';
?>

<?php
    // Xử lý khi nhận được productid từ các card sản phẩm, nếu không có productid thì trả về 404
    if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
        echo "<script>window.location = 'page404.php'</script>";
    } else {
        $id = $_GET['proid'];
    }
    
    // Xử lý submit form từ nút Buy now và Add to cart
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $login_check = Session::get('customer_login');
            if($login_check == false){
            header('Location: login.php');
        }
        $quantity = $_POST['quantity'];
        // Nếu chọn Buy now thì trong hàm add_to_cart của class cart khi kết thúc sẽ chuyển hướng đến giỏ hàng còn nút Add to cart thì không
        $buy_now = ($_POST['submit'] == 'Buy Now') ? true : false; 
        $AddToCart = $ct->add_to_cart($quantity, $id, $buy_now);
    }

?>

<link rel="stylesheet" href="css/detail.css">
<!-- Nội dung trang -->
<div class="wrapper">
    <!-- ============================================================================== -->
    <!--                 Lấy từ cơ sở dữ liệu chi tiết của sản phẩm                     -->
    <!-- ============================================================================== -->
    <?php
        $get_measures_by_product = $product->get_measures_by_product($id);
        $get_product_details = $product->get_details($id);
        // Lưu thông số kỹ thuật vào mảng
        $measures = [];
        if ($get_measures_by_product) {
            while ($measure = $get_measures_by_product->fetch_assoc()) {
                $measures[] = $measure;
            }
        }
        if($get_product_details) {
            while($result_details = $get_product_details->fetch_assoc()){
    ?>
        <div class="product-detail">
            <div class="product-overview">
                <div class="image-gallery">
                    <img src="admin/upload/<?php echo $result_details['image']; ?>" alt="Product Image" class="main-image" />  
                </div>
                <div class="product-info">
                    <!-- Tên sản phẩm -->
                    <h1 class="product-title"><?php echo $result_details['productName']; ?>
                        <?php 
                            // Hiển thị thông số kỹ thuật trong tiêu đề
                            foreach ($measures as $measure) {
                                echo $measure['measureName'] . ' ' . $measure['measureValue'] . '/';
                            }
                        ?>
                    </h1>
                    
                    <!-- Thương hiệu và danh mục -->
                    <ul class="product-meta">
                    <li><strong>Thương hiệu: </strong>
                        <!-- Gửi brandid qua cho getproduct.php bằng Get -->
                        <a href="getproduct.php?type=brand&id=<?php echo $result_details['brandId']; ?>">
                            <?php echo $result_details['brandName']; ?>
                        </a>
                    </li>                    
                    <li><p>|</p> </li>
                    <li> 
                        <!-- Gửi catid qua cho getproduct.php bằng Get -->
                        <a href="getproduct.php?type=cat&id=<?php echo $result_details['catId']; ?>">
                            <?php echo $result_details['catName']; ?> 
                        </a>
                    </li>
                    </ul>
                    <!-- Giá tiền -->
                    <p class="product-price"><?php echo number_format($result_details['productPrice'], 0, ',', '.'); ?>đ</p>
                    <!-- Form số lượng sản phẩm và 2 nút Add to cart và Buy now -->
                    <!-- ==================================== -->
                    <form class="quantity-form" action="" method="post">
                        <label for="quantity-input" class="form-label">Chọn số lượng:</label>
                        <div class="quantity-container">
                            <!-- Nút giảm số lượng -->
                            <button type="button" id="decrement-button" class="quantity-btn decrement-btn">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                </svg>
                            </button>
                            <!-- Input số lượng -->
                            <input name="quantity" type="number" id="quantity-input" class="quantity-input" value="1" min="1" required />
                            <!-- Nút tăng số lượng -->
                            <button type="button" id="increment-button" class="quantity-btn increment-btn">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Hiển thị thông báo thêm thành công nếu có tồn tại việc thực hiện bấm nút -->
                        <?php
                            if (isset($_SESSION['cart_message'])) {
                                echo "<div class='success'><span class='success'>" . $_SESSION['cart_message'] . "</span></div>";
                                unset($_SESSION['cart_message']); // Xóa thông báo sau khi đã hiển thị
                            }
                        ?>
                        
                        <div class="btn-sales">
                            <!-- Thêm vào giỏ hàng -->
                            <button type="submit" name="submit" value="Add to Cart" class="add-to-cart">Thêm vào giỏ hàng</button>
                            <!-- Mua ngay và chuyển hướng tới giỏ hàng -->
                            <button type="submit" name="submit" value="Buy Now" class="buy-now">Mua ngay</button>
                        </div>
                    </form>
                    <!-- ==================================== -->
                </div>
            </div>

            <div class="product-desc-measure">
                <div class="product-desc">
                    <div class="product-desc-tittle">
                        <h2>Mô tả sản phẩm</h2>
                    </div>
                    <p class="p_desc">
                    <?php 
                        if (!empty($result_details['productDesc'])) {
                            echo $result_details['productDesc'];
                        } else {
                            echo "<div style='text-align: center'><p>Không có mô tả nào cho sản phẩm này</p></div>";
                        }
                    ?>
                    </p>
                </div>
                <div class="product-measure">
                    <div class="spec-list-title">
                        <h2>Thông số kỹ thuật: </h2>
                    </div>
                    <ul class="spec-list">
                        <?php 
                            foreach ($measures as $measure_new) {
                        ?>
                            <li><strong><?php echo $measure_new['measureName']; ?></strong> : <?php echo $measure_new['measureValue']; ?></li>
                        <?php 
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php
            }
        }
    ?>
    <!-- Kết thúc lấy detail -->
</div>
    
    <!-- Script của nút tăng giảm số lượng sản phẩm khi mua -->
    <script src="js/detail.js"></script>
<?php
    include 'inc/footer.php';
?>

