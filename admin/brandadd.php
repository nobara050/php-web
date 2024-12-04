<?php 
  include 'inc/header.php'; 
  include '../classes/brand.php'
?>

<?php 
  $brand = new brand();
  if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $brandName = $_POST['brandName'];
      $insertBrand = $brand->insert_brand($brandName);
  }
?>

      <link rel="stylesheet" href="css/brandadd.css">
      <h1 class="dashboard-title">Thêm thương hiệu</h1>
      <div class="brand-form-wrapper">
        <div class="brand-box">
          <?php
            if(isset($insertBrand)){
              echo $insertBrand;
            }
          ?>
          <form action="brandadd.php" method="post">
            <table class="form-table">
              <tr>
                <td>
                    <input type="text" name="brandName" placeholder="Nhập thương hiệu sản phẩm cần thêm..." class="input-medium">
                </td>
              </tr>
              <tr>
                <td>
                    <input type="submit" name="submit" value="Save" class="submit-button">
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div>

<?php 
  include 'inc/footer.php'; 
?>