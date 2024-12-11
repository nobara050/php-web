<?php 
  include 'inc/header.php'; 
  include '../classes/customer.php';
  $cs = new customer();
?>

<?php 
    if (!isset($_GET['customerid']) || $_GET['customerid'] == NULL) {
        echo "<script>window.location = 'customerlist.php'</script>";
    } else {
        $id = $_GET['customerid'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updatecustomer = $cs->update_customer($_POST,$id);
    }
?> 

<link rel="stylesheet" href="css/customeredit.css">

<div class="container">
    <div>
        <h1>Sửa đổi thông tin khách hàng</h1>
    </div>
    <?php
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
                            name="province"
                            type="text"
                            value = '<?php echo $result['province'] ?>'
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Quận huyện:</td>
                        <td>
                            <input
                            name="district"
                            type="text"
                            value = '<?php echo $result['district'] ?>'
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
