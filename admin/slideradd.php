<?php 
  include 'inc/header.php'; 
  include '../classes/product.php';

?>

<?php 
  $product = new product();
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $insertSlider = $product->insert_slider($_POST, $_FILES);
  }

?>

<h1 class="dashboard-title">Thêm banner</h1>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New Slider</h2>
        <div class="block">
          <?php
            if(isset($insertSlider)){
              echo $insertSlider;
            }
          ?>
            <form action="slideradd.php" method="post" enctype="multipart/form-data">
                <table class="form">
                    <tr>
                        <td>
                            <label>Title</label>
                        </td>
                        <td>
                            <input type="text" name="sliderName" placeholder="Enter Slider Title..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Image</label>
                        </td>
                        <td>
                            <input type="file" name="image" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                          <label for="">Type</label>
                        </td>
                        <td>
                          <select name="type" id="">
                            <option value="1">On</option>
                            <option value="2">Off</option>
                          </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Save" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php 
  include 'inc/footer.php'; 
?>