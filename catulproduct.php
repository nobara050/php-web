<?php
    include 'inc/header.php';
?>

<!-- Trang này thực hiện việc lấy sản phẩm theo category hoặc brand -->
<?php 
    // Xử lý Get khi nhận được từ trang details.php gửi qua
    if (!isset($_GET['search']) || !isset($_GET['name']) || $_GET['name'] == NULL) {
        echo "<script>window.location = 'page404.php'</script>";
    } else {
        $search_cat = $_GET['search'];
        $search_name = $_GET['name']; 
    }
    
?> 

<!-- Nội dung trang -->
<div class="wrapper">
    <!-- ============================================================================== -->
    <!--                             Title của trang                                    -->
    <!-- ============================================================================== -->
    <?php
        $titlePrefix = "Tìm kiếm: ";
    ?>
    <span class="list_title"><?php echo $titlePrefix . $search_cat . " " . $search_name ?></span>
    <!-- ============================================================================== -->
    <!--                          List card sản phẩm                                    -->
    <!-- ============================================================================== -->
    <div class="listcard-button">
        <div class="listcard">
            <?php
                $products = $product->get_product_by_search($search_name, $search_cat);
            
                if ($products) {
                    while ($result = $products->fetch_assoc()) {
                        $measures = $product->get_measures_by_product($result['productId']);
                        $measureText = $result['productName'];
                        if ($measures) {
                            while ($measure = $measures->fetch_assoc()) {
                                $measureText .= " / " . $measure['measureName'] . " " . $measure['measureValue'];
                            }
                        }
            ?>
                <!-- Xuất các phẩn tử card -->
                <!-- card here -->
                <div class="card">
                    <div class="card-img">
                        <a href="details.php?proid=<?php echo $result['productId'] ?>">
                        <img src="admin/upload/<?php echo $result['image'] ?>" alt="Hình ảnh sản phẩm" />
                        </a>
                    </div>
                    <div class="card-info">
                        <a href="details.php?proid=<?php echo $result['productId'] ?>">
                        <span class="card-name"><?php echo $measureText; ?></span>
                        </a>
                        <span class="card-price"><?php echo number_format($result['productPrice'], 0, ',', '.') ?>đ</span>
                    </div>
                    <button class="btnMua" onclick="addToCart(this)">Mua ngay</button>
                </div>
            <?php
                    }
                } else {
                    echo "  <div></div>
                            <div></div>
                            <div class='img-out-product'><img src='./img/outproduct.png' alt='Không có sản phẩm'></div>
                            <div></div>
                            <div></div>";
                    $btn = false;
                }
            ?>
            
            <div class='img-out-product'></div>
        </div>
        <?php
            if (isset($btn) && $btn == true) {
        ?>
            <div class="btn-xemthem-wrapper">
                <button class="btn-xemthem">Xem thêm sản phẩm</button>
            </div>
        <?php
            } 
        ?>
    </div>
</div>
<?php
    include 'inc/footer.php';
?>
