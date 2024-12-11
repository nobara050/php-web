<?php 
  include 'inc/header.php'; 
  include '../classes/admin.php';
  $cs = new admin();
?>

<?php 
    if (!isset($_GET['adminid']) || $_GET['adminid'] == NULL) {
        echo "<script>window.location = 'adminlist.php'</script>";
    } else {
        $id = $_GET['adminid'];
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $updateadmin = $cs->update_admin($_POST,$id);
    }
?> 

<link rel="stylesheet" href="css/adminedit.css">

<div class="container">
    <div>
        <h1>Sửa đổi thông tin tài khoản nội bộ</h1>
    </div>
    <?php
        $get_admin = $cs->show_admin($id);
        if($get_admin){
            while($result = $get_admin->fetch_assoc()){
    ?>
        <div class="user-info-wrapper">

            <!-- ============================================================================== -->
            <form action="" method="post">
                <div class="title-form">
                    <h3>Thông tin tài khoản</h3>
                </div>
                <table style="border-collapse: collapse">
                    <tr>
                        <td>Họ và tên:</td>
                        <td>
                            <input
                            name="adminName"
                            type="text"
                            value = '<?php echo $result['adminName'] ?>'
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>
                            <input
                            name="adminEmail"
                            type="tel"
                            value = '<?php echo $result['adminEmail'] ?>'
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Điện thoại</td>
                        <td>
                            <input
                            name="adminPhone"
                            type="tel"
                            value = '<?php echo $result['adminPhone'] ?>'
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Tên đăng nhập</td>
                        <td>
                            <input
                            name="adminUser"
                            type="text"
                            value = '<?php echo $result['adminUser'] ?>'
                            />
                        </td>
                    </tr>
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
