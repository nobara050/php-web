<?php
  include 'inc/header.php'; 
 
  // =============================================================================
  //             Khi nhấn vào tag a có href="?cartid thì sẽ xóa sản phẩm
  // =============================================================================

  if (isset($_GET['cartid'])) {
    $cartid = $_GET['cartid'];
    $delcart = $ct->del_product_cart($cartid);
  }

  // =============================================================================
  //     Khi nhấn button add-item và minus-item sẽ nộp form thay đổi số lượng
  // =============================================================================
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartId']) && isset($_POST['quantity'])) {
    $cartId = $_POST['cartId'];  // Lấy cartId từ POST
    $quantity = $_POST['quantity'];  // Lấy quantity từ POST
    $update_quantity_cart = $ct->update_quantity_cart($quantity, $cartId);
  }  

  // =============================================================================
  //                  Cập nhật số lượng của bandge giỏ hàng
  // =============================================================================
  $check_cart_reset = $ct->check_cart();
  if($check_cart){
    Session::get('qty');
  }
?>


<link rel="stylesheet" href="css/cart.css">

<!-- Nội dung trang -->
<div class="wrapper">
  <div class="wraper-cart-title">
    <span class="cart-title">Giỏ hàng</span>
  </div>
  <div class="wrapper-cart-items">

    <!-- ============================================================================== -->
    <!--           Xuất thông báo sau khi update hoặc delete thay vì ajax               -->
    <!-- ============================================================================== -->
    <?php
      if(isset($delcart)) {
        echo "<span class='success'>" . $delcart . "</span>";
      }
      if (isset($update_quantity_cart)) {
        echo "<span class='success'>" . $update_quantity_cart . "</span>";
      }
    ?>

    <!-- ============================================================================== -->
    <!--     Trường hợp nếu có sản phẩm trong giỏ hàng thì sẽ xuất ra list sản phẩm     -->
    <!-- ============================================================================== -->
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
    ?>
      <!-- form để tăng giảm số lượng sản phẩm -->
      <!-- ============================================================================== -->
        <!-- Phần thông tin -->
          <!-- ============================================================================== -->
          <form method="POST" action="">
          <div class="cart-item-info-button">
            <div class="cart-item-info">
              <div class="cart-item-name-image">
                <div class="cart-item-image">
                  <img
                    src="admin/upload/<?php echo $result['image']; ?>"
                    alt="Hình ảnh sản phẩm"
                  />
                </div>
                <span class="cart-item-name"><?php echo $measureText; ?></span>
              </div>
              <div class="cart-item-price">
                <?php echo number_format($result['price'], 0, ',', '.'); ?>đ
              </div>
            </div>
        <!-- Phần nút xóa và tăng giảm -->
          <!-- ============================================================================== -->
              <div class="cart-button">
                <!-- ========================== -->
                <!-- Nút xóa -->
                <button class="reset-this-item">
                  <a href="?cartid=<?php echo $result['cartId'] ?>">Xóa</a>
                </button>

                <!-- ========================== -->
                <!-- Nút giảm -->
                <button class="minus-item" name="minus" value="minus">
                  <img src="../img/minus.png" alt="-" />
                </button>

                <!-- ========================== -->
                <!-- Input này chứa cartID và hidden để phục vụ tính toán, không có mục đích gì thêm -->
                <input
                  type="hidden"
                  name="cartId"
                  value="<?php echo $result['cartId']; ?>"
                />
                <!-- Input số -->
                <input
                  type="number"
                  name="quantity"
                  class="quantity-input"
                  value="<?php echo $result['quantity']; ?>"
                  required
                  min="1"
                  step="1"
                />

                <!-- ========================== -->
                <!-- Nút thêm -->
                <button class="add-item" name="add" value="add">
                  <img src="../img/plus.png" alt="+" />
                </button>
              </div>
            </div>
          </form>
          <hr>
      <!-- ============================================================================== -->
    <?php
        // Tính tổng tiền = giá mỗi món nhân số lượng
        $qty = $qty + $result['quantity'];
        $total = $result['price'] * $result['quantity'];
        $subtotal = $subtotal + $total;
        }
      }
    ?>

    <!-- ============================================================================== -->
    <!--     Trường hợp nếu có sản phẩm trong giỏ hàng thì sẽ xuất ra tổng giá tiền     -->
    <!-- ============================================================================== -->
    <?php
    // Kiểm tra có sản phẩm trong giỏ hay không
      $check_cart =$ct->check_cart();
      if($check_cart){
    ?>
    <!-- Nếu có tiến hành in ra tổng tiền -->
      <div class="total">
        <p>Tạm tính:</p>
        <p id="subtotal">
          <?php 
            echo number_format($subtotal, 0, ',', '.'); 
          ?>đ</p>
      </div>
      <div class="vat">
        <p>Thuế:</p>
        <p id="vat">10%</p> <!-- ID để JavaScript có thể cập nhật -->
      </div>
    <?php 
      $grandtotal = $subtotal * 110 / 100;
      Session::set('qty',$qty);
    ?>
      <div class="grandtotal">
        <p>Tổng:</p>
        <p id="grandtotal"><?php echo number_format($grandtotal, 0, ',', '.'); ?>đ</p> <!-- ID để JavaScript có thể cập nhật -->
      </div>
      
    <!-- ============================================================================== -->
    <!--  Trường hợp nếu không có sản phẩm trong giỏ hàng thì sẽ xuất ra giỏ hàng trống -->
    <!-- ============================================================================== -->
    <?php
      } else {
        echo "<div class='not-choose'><img src='img/cart-empty.png' alt=''></div>";
        echo "Giỏ hàng chưa có gì.";
      }
    ?>

  </div>
</div>

<script src="js/cart.js"></script>
<?php
    include 'inc/footer.php';
?>
