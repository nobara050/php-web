<?php
  include 'inc/header.php'; 
  $login_check = Session::get('customer_login');
  if($login_check == false){
    header('Location:login.php');
  }
?>

<link rel="stylesheet" href="css/cart.css">

<!-- wrapper for content -->
<div class="wrapper">

</div>

<?php
    include 'inc/footer.php';
?>
