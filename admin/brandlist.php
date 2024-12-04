<?php 
  include 'inc/header.php'; 
  include '../classes/brand.php'
?>
<?php 
  $brand = new brand();
  if (isset($_GET['delid'])) {
      $id = $_GET['delid'];
      $delBrand = $brand->del_brand($id);
  }
?>

<link rel="stylesheet" href="css/brandlist.css">
<h1 class="dashboard-title">Danh sách thương hiệu</h1>
<div class="brand-list-wrapper">
  <div class="brand-box">
  <?php
    if(isset($delBrand)){
      echo $delBrand;
    }
  ?>
    <div class="table-wrapper">
      <table class="brand-table" id="brand-table">
        <thead>
          <tr>
            <th>STT</th>
            <th>Thương hiệu</th>
            <th>Tùy chỉnh</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $show_brand = $brand->show_brand();
            if ($show_brand) {
              $i = 0;
              while($result = $show_brand->fetch_assoc()) {
                $i++;
          ?>
          <tr class="brand-row">
            <td><?php echo $i ?></td>
            <td><?php echo $result['brandName'] ?></td>
            <td>
              <a href="brandedit.php?brandid=<?php echo $result['brandId']; ?>" class="action-link">Sửa</a> 
              || 
              <a href="?delid=<?php echo $result['brandId']; ?>" class="action-link confirmable" data-message="Bạn có muốn xóa thương hiệu này?">Xóa</a>
            </td>
          </tr>
          <?php 
              }
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

      

<?php 
  include 'inc/footer.php'; 
?>