<?php
  include 'inc/header.php'; 
  $login_check = Session::get('customer_login');
  if($login_check == false){
    header('Location:login.php');
  }
?>
<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'])) {
        $id = $_POST['orderId'];
        Session::set('orderId', $_POST['orderId']);
        header("Location: order_details.php");  // Redirect tới chính trang nhưng không gây lỗi khi reload
        exit();
    } elseif (Session::get('orderId') == null){
        header("Location: page404.php");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])) {
        $id = Session::get('orderId');
    
        // Gọi hàm cancel_order từ đối tượng của bạn
        $cancel_order = $ord->cancel_order($id);
        header("Location: order_details.php");
        exit();
    } 

    // if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['repending'])) {
    //     $id = Session::get('orderId');
    //     // Gọi hàm cancel_order từ đối tượng của bạn
    //     $repending_order = $ord->repending_order($id);
    //     header("Location: order_details.php");
    //     exit();
    // } 

    $id = Session::get('orderId');
    if ($id !== false) {
        $showOrderDetails = $ord->show_order_details($id);
    }
?>
<link rel="stylesheet" href="css/order.css">
<link rel="stylesheet" href="css/order_details.css">
<!-- wrapper for content -->
<div class="wrapper">
    <div class="custom-table-container">
      <table class="custom-table">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th> 
                    <th>Hình ảnh</th>
                    <th>Số lượng</th>
                    <th>Giá sản phẩm</th>
                    <th>Tạm tính</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if(isset($showOrderDetails)){
                    while($result = $showOrderDetails->fetch_assoc()){
                        $get_product_details = $product->get_details($result['productId']);
                        $get_measures_by_product = $product->get_measures_by_product($result['productId']);
                        $measures = [];
                        if ($get_measures_by_product) {
                            while ($measure = $get_measures_by_product->fetch_assoc()) {
                                $measures[] = $measure;
                            }
                        }
                        if($get_product_details) {
                            while($result_details = $get_product_details->fetch_assoc()){
            ?>
                <tr>
                    <td class="td-table-name-column">
                        <div class="table-name-column">
                            <?php echo $result_details['productName']; ?>
                            <?php 
                                // Hiển thị thông số kỹ thuật trong tiêu đề
                                foreach ($measures as $measure) {
                                    echo $measure['measureName'] . ' ' . $measure['measureValue'] . '/';
                                }
                            ?>
                        </div>
                    </td>
                    <td> 
                        <div class="table-img-column">
                            <img src="admin/upload/<?php echo $result_details['image']; ?>" alt="Product Image" class="main-image" />
                        </div>       
                    </td>
                    <td><?php echo $result['quantity'] ?></td>
                    <td><?php echo number_format($result['unitPrice'], 0, ',', '.'); ?>đ</td>
                    <td><?php echo number_format($result['totalPrice'], 0, ',', '.'); ?>đ</td>
                    
                </tr>
            <?php
                            }
                        }
                    }
                }
            ?>
          </tbody>
      </table>
        <?php

            // Gọi hàm check_cancel để lấy status
            $status = $ord->check_cancel($id);
            // Kiểm tra giá trị status và xử lý hiển thị form
            if ($status !== 'completed'){
                if ($status === 'cancelled') {
                    // Nếu đơn hàng đã bị hủy, hiển thị thông báo hủy đơn
                    echo "
                        <div class='btn-cancel-wrp'>
                            <div class='btrepending'>Đơn hàng đã bị hủy</div>
                        </div>
                    ";
                } else {
                    // Nếu đơn hàng chưa bị hủy, hiển thị nút hủy đơn
                    echo "
                    <form action='' method='post'>
                        <div class='btn-cancel-wrp'>
                            <input class='btnhuy' name='cancel' type='submit' value='Hủy đơn'>
                        </div>
                    </form>
                    ";
                    
                }
            }

        
        ?>
  </div>
</div>

<?php
    include 'inc/footer.php';
?>
