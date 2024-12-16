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
                    <?php
                        // Truy vấn danh sách province
                        $resultaddress = $prv->get_province();
                        $resultaddress_provinceName = $prv->getprovincebyId($result['province']);
                        $resultaddress_districtName = $disc->getdistrictbyId($result['district']);
                        $resultaddress_wardsName = $wards->getwardsbyId($result['wards']);
                    ?>
                    
                    <tr>
                        <td><label for="province">Tỉnh/Thành phố</label></td>
                        <td class="td-prv-dis-ward">
                        <?php
                            // Kiểm tra nếu có kết quả cho tỉnh
                            if ($resultaddress_provinceName && $rowtest = $resultaddress_provinceName->fetch_assoc()) {
                        ?>
                            <input class="pro-dis-wards" type="text" value="<?php echo $rowtest['name'];?>" readonly>
                        <?php
                            }
                        ?>
                            <select id="province" name="province" class="form-control">
                            <option value="">Chọn một tỉnh</option>
                                <?php
                                    while ($row = $resultaddress->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $row['province_id'] ?>"><?php echo $row['name'] ?></option>
                                <?php
                                    }
                                ?>                            
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="district">Quận/Huyện</label></td>
                        <td class="td-prv-dis-ward">
                        <?php
                            // Kiểm tra nếu có kết quả cho tỉnh
                            if ($resultaddress_districtName && $rowtest = $resultaddress_districtName->fetch_assoc()) {
                        ?>
                            <input class="pro-dis-wards" type="text" value="<?php echo $rowtest['name'];?>" readonly>
                        <?php
                            }
                        ?>
                            <select id="district" name="district" class="form-control">
                                <option value="">Chọn một quận/huyện</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="wards">Phường/Xã</label></td>
                        <td class="td-prv-dis-ward">
                        <?php
                            // Kiểm tra nếu có kết quả cho tỉnh
                            if ($resultaddress_wardsName && $rowtest = $resultaddress_wardsName->fetch_assoc()) {
                        ?>
                            <input class="pro-dis-wards" type="text" value="<?php echo $rowtest['name'];?>" readonly>
                        <?php
                            }
                        ?>
                            <select id="wards" name="wards" class="form-control">
                                <option value="">Chọn một xã</option>
                            </select>
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
