<?php 
  include 'inc/header.php'; 
  include '../classes/brand.php';
  include '../classes/category.php';
  include '../classes/product.php';
?>

<?php 
  $pd = new product();
  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
      $insertProduct = $pd->insert_product($_POST,$_FILES);
  }
?>

  <link rel="stylesheet" href="./css/productadd.css">
    <div class="product-form-container">
        <h1 class="form-title">Thêm Sản Phẩm</h1>
        <form action="productadd.php" method="post" 
              enctype="multipart/form-data" class="product-form">
            <div class="noti">
                <?php
                    if(isset($insertProduct)){
                    echo $insertProduct;
                }
                ?>
            </div>
            <table class="form-table">
                <tr>
                    <td><label for="product-name">Tên sản phẩm</label></td>
                    <td><input type="text" id="product-name" name="productName" placeholder="Nhập tên sản phẩm..." class="input-field"></td>
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
                            <option value="<?php echo $result['catId'] ?>"><?php echo $result['catName'] ?></option>
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
                            <option value="<?php echo $result['brandId'] ?>"><?php echo $result['brandName'] ?></option>
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
                        </div>
                        <button type="button" onclick="addMeasure()">Thêm thông số</button>
                    </td>
                </tr>
                <!-- ============================================== -->

                <tr class="description-row">
                    <td><label for="description">Mô tả</label></td>
                    <td><textarea id="description" name="productDesc" class="textarea-field"></textarea></td>
                </tr>

                <tr>
                    <td><label for="productPrice">Giá</label></td>
                    <td><input type="text" id="productPrice" name="productPrice" placeholder="Nhập giá..." class="input-field"></td>
                </tr>
                <!-- ============================================== -->
                <tr>
                    <td><label for="product-image">Tải ảnh lên</label></td>
                    <td>
                        <input type="file" id="product-image" name="image" onchange="previewImage(event)">
                        <div id="preview-container">
                            <img id="image-preview" src="img/no_img.png" alt="Xem trước ảnh">
                        </div>
                    </td>
                </tr>
                <!-- ============================================== -->
                <tr>
                    <td><label for="type-select">Loại sản phẩm</label></td>
                    <td>
                        <select id="type-select" name="type" class="select-field">
                            <option>Chọn loại</option>
                            <option value="1">Nổi bật</option>
                            <option value="0">Không nổi bật</option>
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
    </div>
    
    <script src="js/productadd.js"></script>

<?php 
  include 'inc/footer.php'; 
?>