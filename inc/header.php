<?php 
  ob_start(); 
  include_once 'lib/session.php';
  Session::init();
  header('Content-Type: text/html; charset=utf-8');

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
  $cat = new category();
  $product = new product();
  $brand = new brand();
  $cs = new customer();
  $ord = new order();
?>

<?php
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache");
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");  

?>

<?php
  if(isset($_GET['customerid'])) {
    Session::destroy();
    header("Location: index.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ididong.com - Điện thoại, máy tính, thiết bị điện tử</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="icon" type="image/x-icon" href="img/favicon.png" />
  </head>
  <body>
  <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
  
    <!-- nav -->
    <nav>
      <!-- Logo -->
      <a href="index.php" class="nav-logo">
        <img src="img/logo.png" alt="Logo" />
      </a>

      
      <!-- Thanh search test (LINH làm để test) -->
       <form action="index.php?act=" method = "post">
          <div class="search-container">
            <input class = "nav-search" name = "search-bar" type="text" id="search-input" placeholder="Tìm kiếm sản phẩm..." onkeyup="suggestProducts(this.value)">
            <div id="suggestions"></div>
          </div>
       </form>
      
<script>
    function suggestProducts(query) {
        if (query.length == 0) {
            document.getElementById("suggestions").innerHTML = "";
            return;
        }
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var suggestions = JSON.parse(this.responseText);
                var suggestionsHTML = "";
                for (var i = 0; i < suggestions.length; i++) {
                    suggestionsHTML += "<p>" + suggestions[i].productName + "</p>";
                }
                document.getElementById("suggestions").innerHTML = suggestionsHTML;
            }
        };
        xhr.open("GET", "suggest.php?q=" + query, true);
        xhr.send();
    }
</script>

      <ul class="nav-option">
      <?php
        $login_check = Session::get('customer_login');
        if($login_check == false){
          echo "  
            <li class='nav-hover'>
              <a href='login.php'> 
                <img src='img/nav_user.png' alt='icon' />
                <span>Đăng nhập</span>
              </a>
            </li>";
        } else {
          echo "
            <li class='nav-hover nav-login-hover-relative'>
              <a>
                <img src='img/nav_user.png' alt='icon' />
                <span>". Session::get('customer_name'). "</span>
              </a>
              <div class='nav-login-hover-absolute'>
                <ul class='nav-login-hover-absolute-element'>
                  <li><a href='customer.php'>Tài khoản</a></li>
                  <li><a href='order.php'>Đơn hàng</a></li>
                  <li>
                    <a href='?customerid=" . Session::get('customer_id') . "'>Đăng xuất</a>
                  </li>
                </ul>
              </div>
            </li> 
          ";
        }
      ?>
        <li class="nav-hover cart-note-relative">
          <a href="cart.php">
            <img src="img/nav_cart.png" alt="icon" />
            <span>Giỏ hàng</span>
          </a>
          <a href="cart.php" class="cart-note-absolute">
            <?php
              $check_cart = $ct->check_cart();
              if($check_cart){
                $qty = Session::get('qty');
                echo $qty;
              } else {
                echo '0';
              }
            ?>
          </a>
        </li>
      </ul>
    </nav>
    <!-- ul category -->
    <ul class="category">
      <!-- laptop -->
      <li class="category-hover">
        <a href="#" class="category-hover-click">
          <img src="img/category_laptop.png" alt="icon" />
          <span>Laptop</span>
        </a>
        <div class="category-child-laptop">
          <div class="category-child-laptop-warpper">
            <div class="category-child-laptop-warpper-log">
              <span class="category-child-title">Thương hiệu</span>
              <a href="#">
                <span>ASUS</span>
              </a>
              <a href="#">
                <span>ACER</span>
              </a>
              <a href="#">
                <span>MSI</span>
              </a>
              <a href="#">
                <span>DELL</span>
              </a>
              <a href="#">
                <span>LENOVO</span>
              </a>
            </div>
            <div class="category-child-laptop-warpper-log">
              <span class="category-child-title">CPU Intel - AMD</span>
              <a href="#">
                <span>Intel Core i3</span>
              </a>
              <a href="#">
                <span>Intel Core i5</span>
              </a>
              <a href="#">
                <span>Intel Core i7</span>
              </a>
              <a href="#">
                <span>Intel Core i9</span>
              </a>
              <a href="#">
                <span>AMD Ryzen</span>
              </a>
            </div>
          </div>
        </div>
      </li>
      <!-- main,cpu,vga -->
      <li class="category-hover">
        <a href="#" class="category-hover-click">
          <img src="img/category_pc.png" alt="icon" />
          <span>Main,CPU,VGA</span>
        </a>
        <div class="category-child-maincpu">
          <div class="category-child-maincpu-warpper">
            <div class="category-child-maincpu-warpper-log">
              <span class="category-child-title">Bộ vi xử lý Intel</span>
              <a href="#">
                <span>CPU Intel 9</span>
              </a>
              <a href="#">
                <span>CPU Intel 7</span>
              </a>
              <a href="#">
                <span>CPU Intel 5</span>
              </a>
              <a href="#">
                <span>CPU Intel 3</span>
              </a>
            </div>
            <div class="category-child-maincpu-warpper-log">
              <span class="category-child-title">Bộ vi xử lý AMD</span>
              <a href="#">
                <span>AMD X870</span>
              </a>
              <a href="#">
                <span>AMD X670</span>
              </a>
              <a href="#">
                <span>AMD X570</span>
              </a>
            </div>
            <div class="category-child-maincpu-warpper-log">
              <span class="category-child-title">VGA-Card màn hình</span>
              <a href="#">
                <span>NVIDIA Quadro</span>
              </a>
              <a href="#">
                <span>AMD Radeon</span>
              </a>
            </div>
            <div class="category-child-maincpu-warpper-log">
              <span class="category-child-title">Bo mạch chủ</span>
              <a href="#">
                <span>Intel</span>
              </a>
              <a href="#">
                <span>AMD</span>
              </a>
            </div>
          </div>
        </div>
      </li>
      <!-- Case,Nguồn,Tản -->
      <li class="category-hover">
        <a href="#" class="category-hover-click">
          <img src="img/category_pc.png" alt="icon" />
          <span>Case,Nguồn,Tản</span>
        </a>
      </li>
      <!-- Ổ cứng, RAN -->
      <li class="category-hover">
        <a href="#" class="category-hover-click">
          <img src="img/category_memory.png" alt="icon" />
          <span>Ổ cứng,RAM,Thẻ nhớ</span>
        </a>
        <div class="category-child-thenho">
          <div class="category-child-thenho-warpper">
            <div class="category-child-thenho-warpper-log">
              <span class="category-child-title">Dung lượng RAM</span>
              <a href="#">
                <span>8 GB</span>
              </a>
              <a href="#">
                <span>16 GB</span>
              </a>
              <a href="#">
                <span>32 GB</span>
              </a>
              <a href="#">
                <span>64 GB</span>
              </a>
            </div>
            <div class="category-child-thenho-warpper-log">
              <span class="category-child-title">Ổ cứng</span>
              <a href="#">
                <span>120GB - 128GB</span>
              </a>
              <a href="#">
                <span>250GB - 256GB</span>
              </a>
              <a href="#">
                <span>480GB - 512GB</span>
              </a>
              <a href="#">
                <span>Trên 1TB</span>
              </a>
            </div>
          </div>
        </div>
      </li>
      <!-- Loa,Micro,Webcam -->
      <li class="category-hover">
        <a href="#" class="category-hover-click">
          <img src="img/category_earphone.png" alt="icon" />
          <span>Loa,Micro,Webcam</span>
        </a>
      </li>
      <!-- Màn hình -->
      <li class="category-hover">
        <a href="#" class="category-hover-click">
          <img src="img/category_laptop.png" alt="icon" />
          <span>Màn hình</span>
        </a>
        <div class="category-child-manhinh">
          <div class="category-child-manhinh-warpper">
            <div class="category-child-manhinh-warpper-log">
              <span class="category-child-title">Thương hiệu</span>
              <a href="#">
                <span>MSI</span>
              </a>
              <a href="#">
                <span>Lenovo</span>
              </a>
              <a href="#">
                <span>Samsung</span>
              </a>
              <a href="#">
                <span>Philips</span>
              </a>
              <a href="#">
                <span>E-Dra</span>
              </a>
            </div>
            <div class="category-child-manhinh-warpper-log">
              <span class="category-child-title">Giá tiền</span>
              <a href="#">
                <span>Dưới 5 triệu</span>
              </a>
              <a href="#">
                <span>Từ 5 đến 10 triệu</span>
              </a>
              <a href="#">
                <span>Từ 10 đến 20 triệu</span>
              </a>
              <a href="#">
                <span>Trên 30 triệu</span>
              </a>
            </div>
          </div>
        </div>
      </li>
      <!-- Chuột -->
      <li class="category-hover">
        <a href="#" class="category-hover-click">
          <img src="img/category_mouse.png" alt="icon" />
          <span>Chuột</span>
        </a>
        <div class="category-child-chuot">
          <div class="category-child-chuot-warpper">
            <div class="category-child-chuot-warpper-log">
              <span class="category-child-title">Thương hiệu</span>
              <a href="#">
                <span>Logitech</span>
              </a>
              <a href="#">
                <span>Razer</span>
              </a>
              <a href="#">
                <span>Corsair</span>
              </a>
              <a href="#">
                <span>Pulsar</span>
              </a>
              <a href="#">
                <span>Khác</span>
              </a>
            </div>
          </div>
        </div>
      </li>
      <!-- Bàn phím -->
      <li class="category-hover">
        <a href="#" class="category-hover-click">
          <img src="img/category_banphim.png" alt="icon" />
          <span>Bàn phím</span>
        </a>
        <div class="category-child-banphim">
          <div class="category-child-banphim-warpper">
            <div class="category-child-banphim-warpper-log">
              <span class="category-child-title">Thương hiệu</span>
              <a href="#">
                <span>AKKO</span>
              </a>
              <a href="#">
                <span>Dare-U</span>
              </a>
              <a href="#">
                <span>Rapoo</span>
              </a>
              <a href="#">
                <span>Corsair</span>
              </a>
              <a href="#">
                <span>Khác</span>
              </a>
            </div>
          </div>
        </div>
      </li>
    </ul>