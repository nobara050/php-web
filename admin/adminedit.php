<?php 
    include 'inc/header.php'; 
    include '../classes/admin.php';
    include '../classes/province.php';
    include '../classes/district.php';
    include '../classes/wards.php';
    $cs = new admin();
    $prv = new province();
    $disc = new district();
    $wards = new wards();
    
?>
<!-- CSS -->
<link rel="stylesheet" href="css/adminedit.css">

<!-- ============================================================================== -->
<!--            Nếu không có admin được chọn thì load trang list lên                -->
<!-- ============================================================================== -->
<?php 
    if (!isset($_GET['adminid']) || $_GET['adminid'] == NULL) {
        echo "<script>window.location = 'adminlist.php'</script>";
    } else {
        $id = $_GET['adminid'];
    }
// <!-- ============================================================================== -->





// <!-- ============================================================================== -->
// <!--                 Nếu bấm nút update thì sửa lại thông tin                       -->
// <!-- ============================================================================== -->
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updateadmin = $cs->update_admin($_POST,$id);
    }
?> 
<!-- ================================================================================== -->





<div class="container">
    <div>
        <h1>Sửa đổi thông tin tài khoản nội bộ</h1>
    </div>
<!-- ============================================================================== -->
<!--                 Load thông tin người dùng từ biến $get_admin                   -->
<!-- ============================================================================== -->
    <?php
        $get_admin = $cs->show_admin($id);
        if($get_admin){
            while($result = $get_admin->fetch_assoc()){
    ?>
        <div class="user-info-wrapper">

            <!-- ================================================================= -->
            <!--                Form sửa thông tin tài khoản                       -->
            <!-- ================================================================= -->
            <form action="" method="post">
                <div class="title-form">
                    <h3>Thông tin tài khoản</h3>
                </div>
                <table style="border-collapse: collapse">
                    <tr>
                        <td>Họ và tên:</td>
                        <td>
                            <input name="adminName" type="text" value = '<?php echo $result['adminName'] ?>'/>
                        </td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>
                            <input name="adminEmail" type="tel" value = '<?php echo $result['adminEmail'] ?>'/>
                        </td>
                    </tr>
                    <tr>
                        <td>Điện thoại</td>
                        <td>
                            <input name="adminPhone" type="tel" value = '<?php echo $result['adminPhone'] ?>'/>
                        </td>
                    </tr>
                    <tr>
                        <td>Tên đăng nhập</td>
                        <td>
                            <input name="adminUser" type="text" value = '<?php echo $result['adminUser'] ?>'/>
                        </td>
                    </tr>

                    <!-- #######   Form này để chọn địa chỉ      ######## -->
                    <?php
                        // Truy vấn danh sách province
                        $resultaddress = $prv->get_province();
                        $resultaddress_provinceName =  $prv->getprovincebyId($result['province']);
                        $resultaddress_districtName =  $disc->getdistrictbyId($result['district']);
                        $resultaddress_wardsName =  $wards->getwardsbyId($result['wards']);
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
                    <!-- #################################### -->


                    <tr>
                        <td>Level</td>
                        <td>
                            <input
                            name="level"
                            type="number"
                            step="1"
                            min="0"
                            max="10"
                            value = '<?php echo $result['level'] ?>'
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Avatar</td>
                        <td>
                            <div class="div-anh">
                                <img src="../img/lapgaming.png" alt="">
                            </div>
                        </td>
                    </tr>
                </table>
                

                <!-- Xuất thông báo khi sửa đổi và nút sửa đổi -->
                <div class="div-update-profile">
                <?php
                    if(isset($updateadmin)){
                        echo $updateadmin;
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
