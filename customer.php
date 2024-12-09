<?php
  include 'inc/header.php'; 
  $login_check = Session::get('customer_login');
  if($login_check == false){
    header('Location:login.php');
  }
?>

<!-- ============================================================================== -->
<!--                 Xử lý khi nhận được submit sửa profile                         -->
<!-- ============================================================================== -->
<?php
    $id = Session::get('customer_id');
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateprofile'])) {
        $updatecustomer = $cs->update_customer($_POST,$id);
    }
?>

<link rel="stylesheet" href="css/user.css">

<!-- ============================================================================== -->
<!--                   Load thông tin người dùng lên                                -->
<!-- ============================================================================== -->
<!-- Nội dung trang -->
<div class="wrapper">
    <?php
        $id = Session::get('customer_id');
        $get_customer = $cs->show_customer($id);
        if($get_customer){
            while($result = $get_customer->fetch_assoc()){
    ?>
        <div class="user-info-wrapper">
            <h3>Thông tin tài khoản</h3>


            <!-- ============================================================================== -->
            <form action="" method="post">
                <table style="border-collapse: collapse">
                    <tr>
                        <td>Họ và tên:</td>
                        <td>
                            <input
                            name="name"
                            type="text"
                            value = '<?php echo $result['name'] ?>'
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Điện thoại:</td>
                        <td>
                            <input
                            name="phone"
                            type="tel"
                            value = '<?php echo $result['phone'] ?>'
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>
                            <input
                            name="email"
                            type="email"
                            value = '<?php echo $result['email'] ?>'
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Địa chỉ:</td>
                        <td>
                            <input
                            name="address"
                            type="text"
                            value = '<?php echo $result['address'] ?>'
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Thành phố:</td>
                        <td>
                            <input
                            name="city"
                            type="text"
                            value = '<?php echo $result['city'] ?>'
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Quận huyện:</td>
                        <td>
                            <input
                            name="country"
                            type="text"
                            value = '<?php echo $result['country'] ?>'
                            />
                        </td>
                    </tr>
                </table>

                <!-- Xuất thông báo khi sửa đổi và nút sửa đổi -->
                <div class="div-update-profile">
                <?php
                    if(isset($updatecustomer)){
                        echo $updatecustomer;
                    }
                ?>
                    <input type="submit" name="updateprofile" class="save-btn" value="Sửa thông tin" />
                </div>
            </form>
            <!-- ============================================================================== -->


        </div>
    <?php
            }
        }
    ?>
</div>
<?php
    include 'inc/footer.php';
?>
