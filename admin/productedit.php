<?php 
  include 'inc/header.php'; 
  include '../classes/brand.php';
  include '../classes/category.php';
  include '../classes/product.php';
?>

<?php 
    $pd = new product();

    if (!isset($_GET['productid']) || $_GET['productid'] == NULL) {
        echo "<script>window.location = 'productlist.php'</script>";
    } else {
        $id = $_GET['productid'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $updateProduct = $pd->update_product($_POST,$_FILES,$id);
    }
?> 
 
  <link rel="stylesheet" href="./css/productadd.css">
    <div class="product-form-container">
        <h1 class="form-title">Sửa Thông Tin Sản Phẩm</h1>
        <?php
            $get_product_by_id = $pd->getproductbyId($id);
            $get_measures_by_product = $pd->get_measures_by_product($id);
            if($get_product_by_id){
                while($result_product = $get_product_by_id->fetch_assoc()){

             
        ?>
        <form action="" method="post" 
              enctype="multipart/form-data" class="product-form">
        <div class="noti">  
        <?php
            if(isset($updateProduct)){
            echo $updateProduct;
            }
        ?>
        </div>
            <table class="form-table">
                <tr>
                    <td><label for="product-name">Tên sản phẩm</label></td>
                    <td><input type="text" id="product-name" name="productName" value="<?php echo $result_product['productName'] ?>" class="input-field"></td>
                </tr>
                <tr>
                    <td><label for="category-select">Danh mục</label></td>
                    <td>
                        <select id="category-select" name="category" class="select-field">
                            <option>--------Chọn danh mục-----------</option>
                            <?php 
                                $cat = new category();
                                $catlist = $cat->show_category();
                                if($catlist) {
                                    while($result = $catlist->fetch_assoc()) {
                            ?>
                            <option 
                            <?php
                                if ($result['catId'] == $result_product['catId']) {
                                    echo 'selected';
                                }
                            ?>
                            
                            value="<?php echo $result['catId'] ?>"><?php echo $result['catName'] ?></option>
                            <?php 
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="brand-select">Thương hiệu</label></td>
                    <td>
                        <select id="brand-select" name="brand" class="select-field">
                            <option>--------Chọn thương hiệu--------</option>
                            <?php 
                                $brand = new brand();
                                $brandlist = $brand->show_brand();
                                if($brandlist) {
                                    while($result = $brandlist->fetch_assoc()) {
                            ?>
                            <option
                            <?php
                                if ($result['brandId'] == $result_product['brandId']) {
                                    echo 'selected';
                                }
                            ?>
                            
                            value="<?php echo $result['brandId'] ?>"><?php echo $result['brandName'] ?></option>
                            <?php 
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <!-- ============================================== -->
                <tr>
                    <td><label for="product-measures">Thông số kỹ thuật</label></td>
                    <td>
                        <div id="measure-container">
                            <?php 
                            if ($get_measures_by_product) {
                                while ($measure = $get_measures_by_product->fetch_assoc()) {
                            ?>
                            <div class="measure-row">
                                <input type="text" name="measureName[]" value="<?php echo $measure['measureName']; ?>" placeholder="Tên thông số" class="input-field measure-name">
                                <input type="text" name="measureValue[]" value="<?php echo $measure['measureValue']; ?>" placeholder="Giá trị thông số" class="input-field measure-value">
                                <button type="button" onclick="removeMeasure(this)">Xóa</button>
                            </div>
                            <?php 
                                }
                            } 
                            ?>
                        </div>
                        <button type="button" onclick="addMeasure()">Thêm thông số</button>
                    </td>
                </tr>
                <!-- ============================================== -->

                <tr class="description-row">
                    <td><label for="description">Mô tả</label></td>
                    <td>
                        <textarea id="description" name="productDesc"  class="textarea-field"><?php echo $result_product['productDesc'] ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td><label for="productPrice">Giá</label></td>
                    <td><input type="text" id="productPrice" name="productPrice" value="<?php echo $result_product['productPrice'] ?>" class="input-field"></td>
                </tr>

                <tr>
                    <td><label for="productQuantity">Số lượng</label></td>
                    <td><input type="number" id="productQuantity" name="productQuantity" step="1" min="0" placeholder="Nhập số lượng..." value="<?php echo $result_product['productQuantity'] ?>" class="input-field"></td>
                </tr>
                <!-- ============================================== -->
                <tr>
                    <td><label for="product-image">Tải ảnh lên</label></td>
                    <td>
                        <input type="file" id="product-image" name="image" onchange="previewImage(event)">
                        <div id="preview-container">
                            <img id="image-preview" src="./upload/<?php echo $result_product['image'] ?>"alt="Xem trước ảnh">
                        </div>
                    </td>
                </tr>
                <!-- ============================================== -->
                <tr>
                    <td><label for="type-select">Loại sản phẩm</label></td>
                    <td>
                        <select id="type-select" name="type" class="select-field">
                            <option>Chọn loại</option>
                            <?php
                                if($result_product['type'] == 1){
                            ?>
                            <option value="0">Không nổi bật</option>
                            <option selected value="1">Nổi bật</option>
                            
                            <?php
                                } else {
                            ?>
                            <option selected value="0">Không nổi bật</option>
                            <option value="1">Nổi bật</option>
                            <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="btnsubmit">
                            <input type="submit" name="submit" value="Lưu" class="submit-button">
                        </div>    
                    </td>
                </tr>
            </table>
        </form>
        <?php
               }
            }
        ?>
    </div>
    
    <script src="js/productadd.js"></script>

<?php 
  include 'inc/footer.php'; 
?>