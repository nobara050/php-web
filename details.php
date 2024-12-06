<?php
    include 'inc/header.php';
?>
<?php
    if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
        echo "<script>window.location = '404.php'</script>";
    } else {
        $id = $_GET['proid'];
    }
?>
<!-- <link rel="stylesheet" href="css/cart.css"> -->
<link rel="stylesheet" href="css/detail.css">
<!-- wrapper for content -->
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
                <p class="product-price"><?php echo $result_details['price']; ?> vnd</p>
                <!-- ==================================== -->
                <form class="quantity-form">
                    <label for="quantity-input" class="form-label">Chọn số lượng:</label>
                    <div class="quantity-container">
                        <button type="button" id="decrement-button" class="quantity-btn decrement-btn">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 2">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                            </svg>
                        </button>
                        <input type="number" id="quantity-input" class="quantity-input" value="1" min="1" required />
                        <button type="button" id="increment-button" class="quantity-btn increment-btn">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                            </svg>
                        </button>
                    </div>
                </form>
                <script>
                    document.getElementById('increment-button').addEventListener('click', function() {
                        let input = document.getElementById('quantity-input');
                        input.value = parseInt(input.value) + 1;
                    });

                    document.getElementById('decrement-button').addEventListener('click', function() {
                        let input = document.getElementById('quantity-input');
                        if (input.value > 1) {
                            input.value = parseInt(input.value) - 1;
                        }
                    });
                </script>
                <!-- ==================================== -->
                <div class="btn-sales">
                    <button class="buy-now">Mua ngay</button>
                    <button class="add-to-cart">Thêm vào giỏ hàng</button>
                </div>
            </div>
        </div>

        <div class="product-desc-measure">
            <div class="product-desc">
                <div class="product-desc-tittle">
                    <h2>Mô tả sản phẩm</h2>
                </div>
                <p class="p_desc"><?php echo $result_details['product_desc']; ?></p>
            </div>
            <div class="product-measure">
                <div class="spec-list-title">
                    <h2>Thông số kỹ thuật: </h2>
                </div>
                <ul class="spec-list">
                    <?php 
                        // Hiển thị thông số kỹ thuật trong danh sách
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


<?php
    include 'inc/footer.php';
?>
