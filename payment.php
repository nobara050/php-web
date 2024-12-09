<?php
    include 'inc/header.php';
    $login_check = Session::get('customer_login');
    if($login_check == false){
      header('Location:login.php');
    }
?>

<?php

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order'])) {
    $customer_id = $_SESSION['customer_id']; // Lấy ID khách hàng từ session
    $order_message = $ct->insertOrder($customer_id, $_POST);
    
    // Kiểm tra nếu thành công thì chuyển hướng
    if (strpos($order_message, 'success') !== false) {
      header('Location: success.php');
      exit(); // Dừng thực thi mã sau khi chuyển hướng
    } 
  }

?>

<link rel="stylesheet" href="css/payment.css">

<div class="wrapper">
  <div class="thanhtoan-content">
  <!-- ============================================================================== -->
  <!--                                  Giỏ hàng                                      -->
  <!-- ============================================================================== -->
    <div class="wrapper-cart-items">
      <table class="custom-cart-table">
        <!-- Mỗi sản phẩm -->
        <thead>
          <tr>
            <th class="product-column">Sản phẩm</th>
            <th class="image-column">Hình ảnh</th>
            <th class="price-column">Giá</th>
            <th class="quantity-column">Số lượng</th>
            <th class="subtotal-column">Tạm tính</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $qty = 0;
            $get_product_cart = $ct->get_product_cart();
            if($get_product_cart){
              $subtotal = 0;
              while($result =$get_product_cart->fetch_assoc()){
                // Lấy thông số kỹ thuật của sản phẩm và gắn vào tên để hiện thị đẹp hơn
                $measures = $product->get_measures_by_product($result['productId']);
                $measureText = $result['productName']; 
                if ($measures) {
                    while ($measure = $measures->fetch_assoc()) {
                        $measureText .= " / " . $measure['measureName'] . " " . $measure['measureValue'];
                    }
                } 
                $total = $result['price'] * $result['quantity']; 
          ?>
            <tr>
              <td class="product-column">
              <div class="product-column-div">
                <?php echo $measureText; ?></td>
              </div>
              <td class="image-column">
                <img
                  src="admin/upload/<?php echo $result['image']; ?>"
                  alt="Hình ảnh sản phẩm"
                />
              </td>
              <td class="price-column">
                <?php echo number_format($result['price'], 0, ',', '.'); ?>đ
              </td>
              <td class="quantity-column">
                <?php echo $result['quantity']; ?>
              </td>
              <td class="subtotal-column">
                <?php echo number_format($total, 0, ',', '.'); ?>đ
              </td>
            </tr>
            <!-- Dòng sản phẩm mẫu này có thể được thay thế bằng dữ liệu PHP -->
          <?php
              // Tính tổng tiền = giá mỗi món nhân số lượng
              $subtotal = $subtotal + $total;
              }
            }
          ?>
          <tr class="total-row">
            <td colspan="5" class="total-label">Tổng tiền: <?php echo number_format($subtotal, 0, ',', '.'); ?>đ</td>
          </tr>
        </tbody>
      </table>
    </div>

  <!-- ============================================================================== -->
  <!--                       Thông tin đơn hàng                                       -->
  <!-- ============================================================================== -->
  <?php
    $id = Session::get('customer_id');
    $get_customer = $cs->show_customer($id);
    if($get_customer){
        while($result = $get_customer->fetch_assoc()){
  ?>
    <div class="delivery-info-container">
      <div class="delivery-info-header">
        <h2>Thông tin giao hàng</h2>
      </div>
      <?php
        if(isset($order_message)){
          echo "
          <div class='delivery-info-error'>
            <span class='delivery-info-error-icon'>⚠️</span>
            <span>$order_message</span>
          </div>";
        }
      ?>
      <div class="delivery-info-form">
        <div class="delivery-title-info">
          <h3>Thông tin người đặt</h3>
        </div>
        <!-- ======================================= -->
        <form class="delivery-info-field-form" action="?order=order" method="post">
          <div class="delivery-info-field">
            <input
              type="text"
              class="delivery-info-input"
              placeholder="Họ và Tên"
              value="<?php echo $result['name'] ?>"
              name="receiverName"
            />
          </div>
          <div class="delivery-info-field">
            <input
              type="text"
              class="delivery-info-input"
              placeholder="Số điện thoại"
              value = '<?php echo $result['phone'] ?>'
              name="receiverPhone"
            />
          </div>
          <div class="delivery-info-field">
            <input
              type="text"
              class="delivery-info-input"
              placeholder="Địa chỉ giao hàng"
              value = '<?php echo $result['address'] ?>'
              name="shippingAddress"
            />
          </div>
          <div class="delivery-info-field">
            <input
              type="text"
              class="delivery-info-input"
              placeholder="Ghi chú của khách hàng"
              value = ''
              name="notes"
            />
          </div>
  <?php
      }
    }
  ?>
          <div class="title-method"><h3>Hình thức thanh toán</h3></div>
          <div class="list-method">
            <input type="radio" id="direct" name="method" value="direct" />
            <label for="direct">Thanh toán trực tiếp</label><br />

            <input
              type="radio"
              id="non-direct"
              name="method"
              value="nondirect"
            />
            <label for="non-direct">Thanh toán online</label><br />
          </div>
        <input class="thanhtoanbtn" name="order" type="submit" value="Xác nhận" />
      </form>
    </div>
  </div>
</div>
</div>




<?php
    include 'inc/footer.php';
?>