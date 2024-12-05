<?php 
    include 'inc/header.php'; 
    include '../classes/brand.php'
?>

<?php 
    $brand = new brand();
    if (!isset($_GET['brandid']) || $_GET['brandid'] == NULL) {
        echo "<script>window.location = 'brandlist.php'</script>";
    } else {
        $id = $_GET['brandid'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $brandName = $_POST['brandName'];
        $updateBrand = $brand->update_brand($brandName,$id);
    }
?> 

      <link rel="stylesheet" href="css/brandadd.css">
      <h1 class="dashboard-title">Sửa thương hiệu</h1>
      <div class="brand-form-wrapper">
        <div class="brand-box">
          <?php
            if(isset($updateBrand)){
              echo $updateBrand;
            }
          ?>
          <?php 
            $get_brand_name = $brand->getbrandbyId($id);
            if($get_brand_name) {
                while($result = $get_brand_name->fetch_assoc()){
            
          ?>
          <form action="" method="post">
            <table class="form-table">
              <tr>
                <td>
                    <input type="text" name="brandName" value="<?php echo $result['brandName'] ?>" placeholder="Sửa thương hiệu..." class="input-medium">
                </td>
              </tr>
              <tr>
                <td>
                    <input type="submit" name="submit" value="Sửa" class="submit-button">
                </td>
              </tr>
            </table>
          </form>
          <?php 
                }
            }
          ?>
        </div>
      </div>

<?php 
    include 'inc/footer.php'; 
?>