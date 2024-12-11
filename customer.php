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
        // header('Location: customer.php');
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



<!--  -->
<?php
// Replace with your MySQL server settings
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "website_mvc"; 

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}



$sql = "SELECT * FROM province";
$result = mysqli_query($conn, $sql);

if (isset($_POST['add_sale'])) {
    echo "<pre>";
    print_r($_POST);
    die();
}

?>
<form id="myForm" class="mt-5" method="POST">
            <h1 class="py-5">Chọn địa chỉ khi đặt hàng trong website</h1>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="province">Tỉnh/Thành phố</label>
                        <select id="province" name="province" class="form-control">
                            <option value="">Chọn một tỉnh</option>
                            <!-- populate options with data from your database or API -->
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <option value="<?php echo $row['province_id'] ?>"><?php echo $row['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="district">Quận/Huyện</label>
                        <select id="district" name="district" class="form-control">
                            <option value="">Chọn một quận/huyện</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="wards">Phường/Xã</label>
                        <select id="wards" name="wards" class="form-control">
                            <option value="">Chọn một xã</option>
                        </select>
                    </div>
                    <input type="submit" name="add_sale" class="btn btn-primary w-100 form-input my-3" value="Đặt hàng">

                </div>
            </div>
        </form>
<!--  -->

</div>
<?php
    include 'inc/footer.php';
?>
