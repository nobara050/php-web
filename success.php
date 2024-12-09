<?php
    include 'inc/header.php';
    $login_check = Session::get('customer_login');
    if($login_check == false){
      header('Location:login.php');
    }
?>

<link rel="stylesheet" href="css/success.css">
<!-- wrapper for content -->
<div class="wrapper">
    <div class="frame-success">
        <img src="img/success-order.png" alt="Thành công">
    </div>
</div>

<?php
    include 'inc/footer.php';
?>
