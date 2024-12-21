<?php
    include 'inc/header.php';
?>

<script src="js/ajax_detail.js"></script>

<?php
    // Xử lý khi nhận được productid từ các card sản phẩm, nếu không có productid thì trả về 404
    if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
        echo "<script>window.location = 'page404.php'</script>";
    } else {
        $id = $_GET['proid'];
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
                    <form id="addToCartForm" method="post">
                        <label for="quantity-input" class="form-label">Chọn số lượng:</label>
                        <div class="quantity-container">
                            <button type="button" id="decrement-button" class="quantity-btn decrement-btn">-</button>
                            <input name="quantity" type="number" id="quantity-input" class="quantity-input" value="1" min="1" required />
                            <button type="button" id="increment-button" class="quantity-btn increment-btn">+</button>
                        </div>
                        <!-- In giá trị proid từ PHP vào input -->
                        <input type="text" id="proid" value="<?php echo $id; ?>" hidden />
                        <div id="cartMessage"></div>
                        <div class="btn-sales">
                            <button type="button" id="addToCartButton" class="add-to-cart" data-action="add">Thêm vào giỏ hàng</button>
                            <button type="button" id="buyNowButton" class="buy-now" data-action="buy">Mua ngay</button>
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