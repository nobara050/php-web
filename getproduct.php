<?php
    include 'inc/header.php';
?>

<?php 
    if (!isset($_GET['type']) || !isset($_GET['id']) || $_GET['id'] == NULL) {
        echo "<script>window.location = 'page404.php'</script>";
    } else {
        $type = $_GET['type']; // Loại tìm kiếm (cat hoặc brand)
        $id = $_GET['id']; // ID danh mục hoặc thương hiệu
    }
?> 

<!-- wrapper for content -->
<div class="wrapper">
    <?php
        if ($type === 'cat') {
            $nameData = $cat->getcatbyId($id);
            $titlePrefix = "Danh mục: ";
        } elseif ($type === 'brand') {
            $nameData = $brand->getbrandbyId($id);
            $titlePrefix = "Thương hiệu: ";
        }

        if ($nameData) {
            while ($result_name = $nameData->fetch_assoc()) {
    ?>
        <span class="list_title"><?php echo $titlePrefix . ($result_name['catName'] ?? $result_name['brandName']); ?></span>
    <?php
            }
        }
    ?>
    <div class="listcard-button">
        <div class="listcard">
            <?php
                if ($type === 'cat') {
                    $products = $product->get_product_by_cat($id);
                } elseif ($type === 'brand') {
                    $products = $product->get_product_by_brand($id);
                }

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
                        <span class="card-price"><?php echo number_format($result['price'], 0, ',', '.') ?>đ</span>
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
