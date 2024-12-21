<?php 
  include 'inc/header.php'; 
  include '../classes/customer.php'
?>
<?php 
  $customer = new customer();
  if (isset($_GET['delid'])) {
      $id = $_GET['delid'];
      $delCustomer = $customer->del_customer($id);
  }
?>

<link rel="stylesheet" href="css/customerlist.css">
<h1 class="dashboard-title">Tài khoản khách hàng</h1>
<div class="customer-list-wrapper">
  <div class="customer-box">
    <div class="noti">
      <?php
        if(isset($delCustomer)){
          echo $delCustomer;
        }
      ?>
    </div>
    <div class="table-wrapper">
      <table class="customer-table" id="customer-table">
        <thead>
          <tr>
            <th>STT</th>
            <th>Họ và tên</th>
            <th>Địa chỉ</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Tùy chọn</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $show_customer_list = $customer->show_customer_list();
            if ($show_customer_list) {
              $i = 0;
              while($result = $show_customer_list->fetch_assoc()) {
                $i++;
          ?>
          <tr class="customer-row">
            <td><?php echo $i ?></td>
            <td><?php echo $result['name'] ?></td>
            <td><?php echo $result['address'] ?></td>
            <td><?php echo $result['email'] ?></td>
            <td><?php echo $result['phone'] ?></td>
            <td  class="flex_td">
              <a href="customeredit.php?customerid=<?php echo $result['id']; ?>" class="action-link">Sửa</a> 
              
              <a href="?delid=<?php echo $result['id']; ?>" class="action-link confirmable" data-message="Bạn có muốn xóa danh mục này?">Xóa</a>
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