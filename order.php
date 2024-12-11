<?php
  include 'inc/header.php'; 
  $login_check = Session::get('customer_login');
  if($login_check == false){
    header('Location:login.php');
  }
?>

<link rel="stylesheet" href="css/order.css">

<!-- wrapper for content -->
<div class="wrapper">

  <div class="custom-table-container">
      <table class="custom-table">
          <thead>
              <tr>
                  <th>Đơn hàng</th> 
                  <th>Trạng thái</th>
                  <th>Địa chỉ nhận hàng</th>
                  <th>Phương thức thanh toán</th>
                  <th>Thành tiền</th>
                  <th>Ngày đặt</th>
                  <th>Ghi chú</th>
                  <th>Tùy chọn</th>
              </tr>
          </thead>
          <tbody>
            <?php
                $get_order = $ord->show_order();
                if($get_order){
                  $i=0;
                  while($result = $get_order->fetch_assoc()){
                    $i++;
            ?>
              <tr>
                  <td><?php echo $i ?></td>
                  <td>
                  <?php
                    $status = $result['status'];

                    switch ($status) {
                        case 'pending':
                            echo '<span style="color: green;">Chờ xử lý</span>';
                            break;
                        case 'processing':
                            echo '<span style="color: green;">Đang xử lý</span>';
                            break;
                        case 'shipped':
                            echo '<span style="color: green;">Đã giao hàng</span>';
                            break;
                        case 'delivered':
                            echo '<span style="color: green;">Đã giao</span>';
                            break;
                        case 'cancelled':
                            echo '<span style="color: red;">Đã hủy</span>';
                            break;
                        case 'refunded':
                            echo '<span style="color: red;">Hoàn tiền</span>';
                            break;
                        case 'failed':
                            echo '<span style="color: red;">Thất bại</span>';
                            break;
                        case 'on_hold':
                            echo '<span style="color: red;">Tạm giữ</span>';
                            break;
                        case 'returned':
                            echo '<span style="color: darkorange;">Đã trả lại</span>';
                            break;
                        default:
                            echo '<span style="color: black;">Không xác định</span>';
                            break;
                    }
                  ?>
                  </td>
                  <td><?php echo $result['shippingAddress'] ?></td>
                  <td>
                    <?php 
                      if($result['paymentMethod']=='direct'){
                        echo 'Khi nhận hàng';
                      } else {
                        echo 'Trực tuyến';
                      }
                    ?></td>
                  <td><?php echo number_format($result['totalAmount'], 0, ',', '.'); ?>đ</td>
                  <td><?php echo $result['orderDate'] ?></td>
                  <td><?php echo $result['notes'] ?></td>
                  <td class="detail-order">
                  <form action="order_details.php" method="post">
                    <input type="hidden" name="orderId" value="<?php echo $result['orderId']; ?>">
                    <input type="submit" value="Chi tiết">
                  </form>    
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

<?php
    include 'inc/footer.php';
?>
