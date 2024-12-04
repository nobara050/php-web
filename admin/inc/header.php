<?php 
  include '../lib/session.php';
  Session::checkSession();
?>

<?php
  if (isset($_GET['action']) && $_GET['action'] === 'logout') {
      Session::destroy();
      // exit(); // Đảm bảo không có gì khác được xử lý
  }
?>

<?php
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache");
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/png" href="img/admin_favicon.png">
  </head>
  <body>
    <!-- Sidebar -->
    <div class="sidebar-wrapper">
      <div class="sidebar">
        <div class="logo">Idibo <span>Admin</span></div>
        <ul>
          <li><a href="index.php">Trang chủ</a></li>
          <li>
            <a class="menuitem">Danh mục</a>
            <ul class="submenu">
              <li><a href="catadd.php">Thêm danh mục</a></li>
              <li><a href="catlist.php">Danh sách danh mục</a></li>
            </ul>
          </li>
          <li>
            <a class="menuitem">Thương hiệu</a>
            <ul class="submenu">
              <li><a href="brandadd.php">Thêm thương hiệu</a></li>
              <li><a href="brandlist.php">Danh sách thương hiệu</a></li>
            </ul>
          </li>
          <li>
            <a class="menuitem">Sản phẩm</a>
            <ul class="submenu">
              <li><a href="productadd.php">Thêm sản phẩm</a></li>
              <li><a href="productlist.php">Danh sách sản phẩm</a></li>
            </ul>
          </li>
          <li><a href="#">Slider</a></li>
          <li><a href="#">Nội bộ</a></li>
          <li><a href="#">Khách hàng</a></li>
        </ul>
      </div>
    </div>

    <!-- Main Content -->
    <div class="content">
      <div class="topbar">
        <div class="user-info"><?php echo Session::get('adminName'); ?></div>
        <a id="btnlogout" href="?action=logout" class="confirmable" data-message="Bạn có muốn đăng xuất khỏi tài khoản?">Đăng xuất</a>
      </div>
    
      <div id="confirm-dialog" class="dialog hidden">
        <div class="dialog-content">
          <p id="confirm-message">Bạn có chắc chắn muốn thực hiện hành động này không?</p>
          <button id="confirm-yes" class="btn btn-yes">Đồng ý</button>
          <button id="confirm-no" class="btn btn-no">Hủy</button>
        </div>
      </div>
