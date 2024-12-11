<?php
    include 'inc/header.php';
?>

<!-- Trang này thực hiện việc lấy sản phẩm theo category hoặc brand -->
<?php 
    // Xử lý Get khi nhận được từ trang details.php gửi qua
    if (!isset($_GET['type']) || !isset($_GET['id']) || $_GET['id'] == NULL) {
        echo "<script>window.location = 'page404.php'</script>";
    } else {
        $type = $_GET['type']; // Loại tìm kiếm (cat hoặc brand)
        $id = $_GET['id']; // ID danh mục hoặc thương hiệu
    }
?> 

<!-- Nội dung trang -->
<div class="wrapper">
    <!-- ============================================================================== -->
    <!--                             Title của trang                                    -->
    <!-- ============================================================================== -->
    <?php
        // Xuất title là Category hay Brand tùy theo type lấy được ở trên
        if ($type === 'cat') {
            $nameData = $cat->getcatbyId($id);
            $titlePrefix = "Danh mục: ";
        } elseif ($type === 'brand') {
            $nameData = $brand->getbrandbyId($id);
            $titlePrefix = "Thương hiệu: ";
        }

        // Xuất ra title 
        if ($nameData) {
            while ($result_name = $nameData->fetch_assoc()) {
    ?>
        <span class="list_title"><?php echo $titlePrefix . ($result_name['catName'] ?? $result_name['brandName']); ?></span>
    <?php
            }
        }
    ?>

    <!-- ============================================================================== -->
    <!--                          List card sản phẩm                                    -->
    <!-- ============================================================================== -->
    <div class="listcard-button">
        <div class="listcard">
            <?php
                // Nếu type là category thì get_product_by_cat theo id của category
                if ($type === 'cat') {
                    $products = $product->get_product_by_cat($id);
                } elseif ($type === 'brand') {
                    $products = $product->get_product_by_brand($id);
                }
            
                // Nếu type là brand thì get_product_by_brand theo id của brand
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
                    echo "<img src='./img/cart-empty.png' alt='Không có sản phẩm'>";
                }
            ?>
        </div>
        <div class="btn-xemthem-wrapper">
            <button class="btn-xemthem">Xem thêm sản phẩm</button>
        </div>
    </div>
</div>
<?php
    include 'inc/footer.php';
?>
