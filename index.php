<?php
    include 'inc/header.php';
    include 'inc/slider.php';
?>
<div class="wrapper">
    <!-- List Card -->
    <span class="list_title">Sản phẩm hot</span>
    <div class="listcard-button">
        <div class="listcard">
            <?php
                $product_featured = $product->getproduct_featured();
                if($product_featured) {
                    while($result = $product_featured->fetch_assoc()){
                        $measures = $product->get_measures_by_product($result['productId']);
                        $measureText = $result['productName']; // Bắt đầu với tên sản phẩm
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
                        <span class="card-price"><?php echo $result['price'] ?> VND</span>
                    </div>
                    <button class="btnMua" onclick="addToCart(this)">Mua ngay</button>
                </div>
            <?php
                    }
                }
            ?>
            
        </div>
        <div class="btn-xemthem-wrapper">
            <button class="btn-xemthem">Xem thêm sản phẩm</button>
        </div>
    </div>
    <!-- Banner -->
    <span class="list_title">Tự build PC</span>
    <div class="banner">
        <a href="#">
            <img src="img/banner2.jpg" alt="banner1" />
        </a>
    </div>
    <!-- List Card -->
    <span class="list_title">Sản phẩm mới</span>
    <div class="listcard-button">
        <div class="listcard">
        <?php
            $product_new = $product->getproduct_new();
            if($product_new) {
                while($result_new = $product_new->fetch_assoc()){
                    $measures = $product->get_measures_by_product($result_new['productId']);
                    $measureText = $result_new['productName']; // Bắt đầu với tên sản phẩm
                    if ($measures) {
                        while ($measure = $measures->fetch_assoc()) {
                            $measureText .= " / " . $measure['measureName'] . " " . $measure['measureValue'];
                        }
                    }
        ?>
            <!-- card here -->
            <div class="card">
                <div class="card-img">
                    <a href="details.php?proid=<?php echo $result_new['productId'] ?>">
                    <img src="admin/upload/<?php echo $result_new['image'] ?>" alt="Hình ảnh sản phẩm" />
                    </a>
                </div>
                <div class="card-info">
                    <a href="details.php?proid=<?php echo $result_new['productId'] ?>">
                    <span class="card-name"><?php echo $measureText; ?></span>
                    </a>
                    <span class="card-price"><?php echo $result_new['price'] ?> VND</span>
                </div>
                <button class="btnMua" onclick="addToCart(this)">Mua ngay</button>
            </div>
        <?php
                }
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