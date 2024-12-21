<?php
// Database connection
require_once dirname(__DIR__) . '/lib/connection_no_class.php';
require_once dirname(__DIR__) . '/classes/product.php'; // Adjust the path to the correct location
// Instantiate the Product class
$product = new Product($conn);

?>


<!-- Load hình trong CSDL và hiển thị nó trên trang web -->
<!-- Banner -->
<div class="wrapper-banners">
    <!--Flex Slider -->
    <section class="slider">
        <div class="flexslider">
            <ul class="slides">
                <?php 
                $get_slider = $product->show_slider();
                if ($get_slider) {
                    while ($result_slider = $get_slider->fetch_assoc()) {
                ?>
                <li><img src="admin/upload/<?php echo htmlspecialchars($result_slider['sliderImage']); ?>" alt="banner1"></li>
                <?php
                    }
                } else {
                    echo '<li>No sliders found.</li>';
                }
                ?>
            </ul>
        </div>
    </section>
</div>
