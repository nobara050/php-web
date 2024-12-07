<?php
    include 'inc/header.php';
?>

<?php
    if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
        echo "<script>window.location = '404.php'</script>";
    } else {
        $id = $_GET['proid'];
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $quantity = $_POST['quantity'];
        $buy_now = ($_POST['submit'] == 'Buy Now') ? true : false; // Kiểm tra xem người dùng chọn "Mua ngay"
        $AddToCart = $ct->add_to_cart($quantity, $id, $buy_now);
    }
?>

<link rel="stylesheet" href="css/detail.css">

<div class="wrapper">
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
                <h1 class="product-title"><?php echo $result_details['productName']; ?>
                <?php 
                    // Hiển thị thông số kỹ thuật trong tiêu đề
                    foreach ($measures as $measure) {
                        echo $measure['measureName'] . ' ' . $measure['measureValue'] . '/';
                    }
                ?>
                </h1>
                <ul class="product-meta">
                    <li><strong>Thương hiệu: </strong> <?php echo $result_details['brandName']; ?></li>
                    <li><p>|</p> </li>
                    <li> <?php echo $result_details['catName']; ?></li>
                </ul>
                <p class="product-price"><?php echo number_format($result_details['price'], 0, ',', '.'); ?>đ</p>
                
                <!-- ==================================== -->
                <form class="quantity-form" action="" method="post">
                    <label for="quantity-input" class="form-label">Chọn số lượng:</label>
                    <div class="quantity-container">
                        <button type="button" id="decrement-button" class="quantity-btn decrement-btn">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 2">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                            </svg>
                        </button>
                        <input name="quantity" type="number" id="quantity-input" class="quantity-input" value="1" min="1" required />
                        <button type="button" id="increment-button" class="quantity-btn increment-btn">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg>
                        </button>
                    </div>

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
                    if (!empty($result_details['product_desc'])) {
                        echo $result_details['product_desc'];
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
</div>

<script>
    // Thêm logic cho nút tăng/giảm số lượng
    document.getElementById('increment-button').addEventListener('click', function () {
        let input = document.getElementById('quantity-input');
        input.value = parseInt(input.value) + 1;
    });

    document.getElementById('decrement-button').addEventListener('click', function () {
        let input = document.getElementById('quantity-input');
        if (input.value > 1) {
            input.value = parseInt(input.value) - 1;
        }
    });
</script>
<?php
    include 'inc/footer.php';
?>

