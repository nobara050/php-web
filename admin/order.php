<?php 
  include 'inc/header.php'; 
  include '../classes/order.php';
  include '../classes/customer.php';
?>
<?php 
  $customer = new customer();
  $order = new order();
//   if (isset($_GET['delid'])) {
//       $id = $_GET['delid'];
//       $delCustomer = $customer->del_customer($id);
//   }
?>

<script src="js/ajax_order.js"></script>
<link rel="stylesheet" href="css/order.css">
<h1 class="dashboard-title">Đơn hàng</h1>
<div class="customer-list-wrapper">
  <div class="customer-box">
    <div class="noti">
      <?php
        // if(isset($delCustomer)){
        //   echo $delCustomer;
        // }
      ?>
    </div>
    <div class="table-wrapper">
      <table class="customer-table" id="customer-table">
        <thead>
          <tr>
            <th>Mã đơn</th>
            <th>Tên người nhận</th>
            <th>Số điện thoại</th>
            <th>Email tài khoản đặt hàng</th>
            <th>Ngày đặt</th>
            <th>Tình trạng đơn hàng</th>
            <th>Phương thức thanh toán</th>
            <th>Tình trạng thanh toán</th>
            <th>Địa chỉ</th>
            <th>Ghi chú</th>
            <th>Tổng đơn</th>
            <th>Tùy chọn</th>
            <!-- <th>Ghi chú</th>
            <th>Tổng đơn</th> -->
          </tr>
        </thead>
        <tbody>
          <?php 
            $show_order = $order->show_order();
            if ($show_order) {
              $i = 0;
              while($result = $show_order->fetch_assoc()) {
                $Cus_in_order = $customer->show_customer($result['customerId']);
                while($row_Cus_in_order = $Cus_in_order->fetch_assoc()){
          ?>
          <tr class="customer-row">
            <td><?php echo $result['orderId'] ?></td>
            <td><?php echo $result['receiverName'] ?></td>
            <td><?php echo $result['receiverPhone'] ?></td>
            <td><?php echo $row_Cus_in_order['email'] ?></td>
            <td><?php echo $result['orderDate'] ?></td>
            <td>
                <select name="status" onchange="updateStatus(this.value, <?php echo $result['orderId']; ?>)">
                    <option value="pending" <?php echo $result['status'] === 'pending' ? 'selected' : ''; ?>>Đang xử lý</option>
                    <option value="shipping" <?php echo $result['status'] === 'shipping' ? 'selected' : ''; ?>>Đang giao</option>
                    <option value="completed" <?php echo $result['status'] === 'completed' ? 'selected' : ''; ?>>Hoàn tất</option>
                    <option value="cancel" <?php echo $result['status'] === 'cancel' ? 'selected' : ''; ?>>Hủy</option>
                </select>
            </td>
            <td><?php echo $result['paymentMethod'] ?></td>
            <td>
                <select name="paymentStatus" onchange="updatePaymentStatus(this.value, <?php echo $result['orderId']; ?>)">
                    <option value="pending" <?php echo $result['paymentStatus'] === 'pending' ? 'selected' : ''; ?>>Chưa thanh toán</option>
                    <option value="completed" <?php echo $result['paymentStatus'] === 'completed' ? 'selected' : ''; ?>>Đã thanh toán</option>
                </select>
            </td>

            <td><?php echo $result['shippingAddress'] ?></td>
            <td><?php echo $result['notes'] ?></td>
            <td><?php echo number_format($result['totalAmount']) ?>đ</td>
            <td>
              <div>
                <a href="" class="action-link">Chi tiết</a> 
              </div>  
            </td>
          </tr>
          <?php 
                }
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