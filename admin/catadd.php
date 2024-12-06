<?php 
  include 'inc/header.php'; 
  include '../classes/category.php'
?>

<?php 
  $cat = new category();
  if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $catName = $_POST['catName'];
      $insertCat = $cat->insert_category($catName);
  }
?>

      <link rel="stylesheet" href="css/catadd.css">
      <h1 class="dashboard-title">Thêm danh mục</h1>
      <div class="category-form-wrapper">
        <div class="category-box">
          <div class="noti">
            <?php
              if(isset($insertCat)){
                echo $insertCat;
              }
            ?>
          </div>
          <form action="catadd.php" method="post">
            <table class="form-table">
              <tr>
                <td>
                    <input type="text" name="catName" placeholder="Nhập danh mục sản phẩm cần thêm..." class="input-medium">
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