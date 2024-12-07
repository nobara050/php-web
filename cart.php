<?php
  include 'inc/header.php'; 
 
  if (isset($_GET['cartid'])) {
    $cartid = $_GET['cartid'];
    $delcart = $ct->del_product_cart($cartid);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartId']) && isset($_POST['quantity'])) {
    $cartId = $_POST['cartId'];  // Lấy cartId từ POST
    $quantity = $_POST['quantity'];  // Lấy quantity từ POST
    $update_quantity_cart = $ct->update_quantity_cart($quantity, $cartId);
  }  
?>


<link rel="stylesheet" href="css/cart.css">

<!-- wrapper for content -->
<div class="wrapper">
  <div class="wraper-cart-title">
    <span class="cart-title">Giỏ hàng</span>
  </div>
  <div class="wrapper-cart-items">
    <?php
      if(isset($delcart)){
        echo "<span class='success'>" . $delcart . "</span>";
      }
      if (isset($update_quantity_cart)) {
        echo "<span class='success'>" . $update_quantity_cart . "</span>";
      }
    ?>
    <!-- =============================== -->
    <?php 
      $qty = 0;
      $get_product_cart = $ct->get_product_cart();
      if($get_product_cart){
        $subtotal = 0;
        while($result =$get_product_cart->fetch_assoc()){
          // Lấy thông số kỹ thuật của sản phẩm
          $measures = $product->get_measures_by_product($result['productId']);
          $measureText = $result['productName']; // Bắt đầu với tên sản phẩm
          if ($measures) {
              while ($measure = $measures->fetch_assoc()) {
                  $measureText .= " / " . $measure['measureName'] . " " . $measure['measureValue'];
              }
          }
          
    ?>
    <form method="POST" action="">
    <div class="cart-item-info-button">
      <div class="cart-item-info">
        <div class="cart-item-name-image">
          <div class="cart-item-image">
            <img 
            src="admin/upload/<?php echo $result['image']; ?>" 
            alt="Hình ảnh sản phẩm" />
          </div>
          <span class="cart-item-name"><?php echo $measureText; ?></span>
        </div>
        <div class="cart-item-price"><?php echo number_format($result['price'], 0, ',', '.'); ?>đ</div>
      </div>
      
      <div class="cart-button">
          <button class="reset-this-item" ><a href="?cartid=<?php echo $result['cartId'] ?>">Xóa</a></button>
        <button class="minus-item" name="minus" value="minus">
          <img src="../img/minus.png" alt="-" />
        </button>
        <input
          type="hidden"
          name="cartId"
          value="<?php echo $result['cartId']; ?>"
        />
        <input
          type="number"
          name="quantity"
          class="quantity-input"
          value="<?php echo $result['quantity']; ?>"
          required
          min="1"
          step="1"
        />
        <button class="add-item" name="add" value="add">
          <img src="../img/plus.png" alt="+" />
        </button>
      </div>
    </div>
    </form>

    <hr>
    <?php
        $qty = $qty + $result['quantity'];
        $total = $result['price'] * $result['quantity'];
        $subtotal = $subtotal + $total;
        }
      }
    ?>
    <?php
      $check_cart =$ct->check_cart();
      if($check_cart){
    ?>
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
    <?php
      } else {
        echo "<div class='not-choose'><img src='img/cart-empty.png' alt=''></div>";
        echo "Giỏ hàng chưa có gì.";
      }
    ?>
    <!-- =============================== -->

  </div>
</div>

<script src="js/cart.js"></script>
<?php
    include 'inc/footer.php';
?>
