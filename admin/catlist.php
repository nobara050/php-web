<?php 
  include 'inc/header.php'; 
  include '../classes/category.php'
?>
<?php 
  $cat = new category();
  if (isset($_GET['delid'])) {
      $id = $_GET['delid'];
      $delCat = $cat->del_category($id);
  }
?>

<link rel="stylesheet" href="css/catlist.css">
<h1 class="dashboard-title">Danh sách danh mục</h1>
<div class="category-list-wrapper">
  <div class="category-box">
    <div class="noti">
      <?php
        if(isset($delCat)){
          echo $delCat;
        }
      ?>
    </div>
    <div class="table-wrapper">
      <table class="category-table" id="category-table">
        <thead>
          <tr>
            <th>STT</th>
            <th>Danh mục</th>
            <th>Tùy chỉnh</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $show_cate = $cat->show_category();
            if ($show_cate) {
              $i = 0;
              while($result = $show_cate->fetch_assoc()) {
                $i++;
          ?>
          <tr class="category-row">
            <td><?php echo $i ?></td>
            <td><?php echo $result['catName'] ?></td>
            <td>
              <a href="catedit.php?catid=<?php echo $result['catId']; ?>" class="action-link">Sửa</a> 
              || 
              <a href="?delid=<?php echo $result['catId']; ?>" class="action-link confirmable" data-message="Bạn có muốn xóa danh mục này?">Xóa</a>
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