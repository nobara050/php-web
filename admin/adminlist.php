<?php 
  include 'inc/header.php'; 
  include '../classes/admin.php'
?>
<?php 
  $admin = new admin();
  if (isset($_GET['delid'])) {
      $id = $_GET['delid'];
      $deladmin = $admin->del_admin($id);
  }
?>

<link rel="stylesheet" href="css/adminlist.css">
<h1 class="dashboard-title">Tài khoản nhân viên</h1>
<div class="admin-list-wrapper">
  <div class="admin-box">
    <div class="noti">
      <?php
        if(isset($deladmin)){
          echo $deladmin;
        }
      ?>
    </div>
    <div class="table-wrapper">
      <table class="admin-table" id="admin-table">
        <thead>
          <tr>
            <th>STT</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Tên đăng nhập</th>
            <th>Số điện thoại</th>
            <th>Cấp độ</th>
            <th>Lần cuối đăng nhập</th>
            <th>Tùy chọn</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $show_admin_list = $admin->show_admin_list();
            if ($show_admin_list) {
              $i = 0;
              while($result = $show_admin_list->fetch_assoc()) {
                $i++;
          ?>
          <tr class="admin-row">
            <td><?php echo $i ?></td>
            <td><?php echo $result['adminName'] ?></td>
            <td><?php echo $result['adminEmail'] ?></td>
            <td><?php echo $result['adminUser'] ?></td>
            <td><?php echo $result['adminPhone'] ?></td>
            <td><?php echo $result['level'] ?></td>
            <td><?php echo date("H:i d/m/Y", strtotime($result['lastLogin'])); ?></td>
            <td class="flex_td">
              <a href="adminedit.php?adminid=<?php echo $result['adminId']; ?>" class="action-link">Sửa</a> 
              <a href="?delid=<?php echo $result['adminId']; ?>" class="action-link confirmable" data-message="Bạn có muốn xóa danh mục này?">Xóa</a>
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