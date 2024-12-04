<?php 
    include 'inc/header.php'; 
    include '../classes/category.php'
?>

<?php 
    $cat = new category();
    if (!isset($_GET['catid']) || $_GET['catid'] == NULL) {
        echo "<script>window.location = 'catlist.php'</script>";
    } else {
        $id = $_GET['catid'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $catName = $_POST['catName'];
        $updateCat = $cat->update_category($catName,$id);
    }
?> 

      <link rel="stylesheet" href="css/catadd.css">
      <h1 class="dashboard-title">Sửa danh mục</h1>
      <div class="category-form-wrapper">
        <div class="category-box">
          <?php
            if(isset($updateCat)){
              echo $updateCat;
            }
          ?>
          <?php 
            $get_cate_name = $cat->getcatbyID($id);
            if($get_cate_name) {
                while($result = $get_cate_name->fetch_assoc()){
            
          ?>
          <form action="" method="post">
            <table class="form-table">
              <tr>
                <td>
                    <input type="text" name="catName" value="<?php echo $result['catName'] ?>" placeholder="Sửa danh mục..." class="input-medium">
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