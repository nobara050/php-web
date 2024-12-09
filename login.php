<!-- ============================================================================== -->
<!--                Phần header do không include file login                         -->
<!-- ============================================================================== -->
<!-- Lý do không include header cho file này là vì giao diện nó khác mấy trang trước -->

<?php 
  ob_start(); 
  include 'lib/session.php';
  Session::init();
?>

<?php
  include_once 'lib/database.php';
  include_once 'helpers/format.php';

  spl_autoload_register(function($className) {
    include_once "classes/".$className.".php";
  });
  $db = new Database();
  $fm = new Format();
  $ct = new cart();
  $us = new user();
  $cat = new category();
  $product = new product();
  $brand = new brand();
  $cs = new customer();
?>

<?php
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache");
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");  
?>

<!DOCTYPE html>
<html lang="Việt">
  <head>
    <link rel="stylesheet" href="css/login.css" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng nhập || Đăng kí</title>
  
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
      integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>

<?php
  $login_check = Session::get('customer_login');
  if($login_check){
    header('Location:order.php');
  }
?>

<link rel="stylesheet" href="css/login.css">

<!-- ============================================================================== -->
<!--                          Kết thúc phần header                                  -->
<!-- ============================================================================== -->








<!-- ============================================================================== -->
<!--                  Xử lý khi nhận được submit đăng ký                            -->
<!-- ============================================================================== -->
<?php 
  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
      $insertCustomer = $cs->insert_customer($_POST);
  }
?>


<!-- ============================================================================== -->
<!--                  Xử lý khi nhận được submit đăng nhập                          -->
<!-- ============================================================================== -->
<?php 
  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
      $loginCustomer = $cs->login_customer($_POST);
  }
?>
  <body>
      <div class="container" id="container">
        <?php 
        
        ?>
      <!-- ============================================================================== -->
      <!--                            Form đăng ký                                        -->
      <!-- ============================================================================== -->
        <div class="form-container sign-up-container">
          <form action="" method="post">
            <h1>Tạo tài khoản</h1>
            <div class="infield">
              <input name="name" type="text" placeholder="Tên" />
            </div>
            <div class="infield">
              <input name="email" type="email" placeholder="Email" name="email" />
            </div>
            <div class="infield">
              <input name="phone" type="tel" placeholder="Số điện thoại" />
            </div>
            <div class="infield">
              <input name="password" type="password" placeholder="Mật khẩu" />
            </div>
            <!-- <button>ĐĂNG KÝ</button> -->
            <input class="btn-submit" type="submit" name="submit" value="ĐĂNG KÍ"></input>
          </form>
        </div>

      <!-- ============================================================================== -->
      <!--                           Form đăng nhập                                       -->
      <!-- ============================================================================== -->
        <div class="form-container sign-in-container">
          <form action="" method="post">
            <h1>Đăng nhập</h1>
            <div class="infield">
              <input name="email" type="email" placeholder="Email" name="email" />
            </div>
            <div class="infield">
              <input name="password" type="password" placeholder="Mật khẩu" />
            </div>
            <a href="#" class="forgot">Quên mật khẩu?</a>
            <?php
              if(isset($insertCustomer)){
                echo $insertCustomer;
              }
            ?>
            <?php
              if(isset($loginCustomer)){
                echo $loginCustomer;
              }
            ?>
            <input class="btn-submit" type="submit" name="login" value="Đăng nhập"></input>
          </form>
          
        </div>

      <!-- ============================================================================== -->
      <!--                          Tấm nền để cho đẹp                                    -->
      <!-- ============================================================================== -->
        <div class="overlay-container" id="overlayCon">
          <div class="overlay">
            <div class="overlay-panel overlay-left">
              <h1>Chào mừng!</h1>
              <p>Đăng nhập để luôn giữ kết nối với của hàng bạn nhé!</p>
              <button>Đăng nhập</button>
            </div>
            <div class="overlay-panel overlay-right">
              <h1>Chào bạn!</h1>
              <p>Chào mừng đến với cửa hàng phụ kiện máy tính số 1 Việt Nam</p>
              <button>Đăng kí</button>
            </div>
          </div>
          <button id="overlayBtn"></button>
        </div>
      </div>

      <!-- js code -->
    <script src="js/login.js"></script>
  </body>
</html>