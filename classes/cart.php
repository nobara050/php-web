<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
?>

<?php
    class cart {

        private $db;
        private $fm;

        public function __construct() {
            $this->db = new Database();
            $this->fm = new Format();
        }

        // ================================================
        //              Thêm sản phẩm vào giỏ
        // ================================================
        public function add_to_cart($quantity, $id, $buy_now = false){
            $quantity = $this->fm->validation($quantity);
            $quantity = mysqli_real_escape_string($this->db->link, $quantity);
            $id = mysqli_real_escape_string($this->db->link, $id);
            $customerId = Session::get('customer_id');
        
            // Lấy thông tin sản phẩm
            $query = "SELECT * FROM tbl_product WHERE productId='$id'";
            $result = $this->db->select($query)->fetch_assoc();
            $image = $result["image"];
            $productPrice = $result["productPrice"];
            $productName = $result["productName"];
        
            // Kiểm tra xem sản phẩm đã có trong giỏ chưa
            $check_cart_query = "SELECT * FROM tbl_cart WHERE productId='$id' AND customerId='$customerId'";
            $check_cart = $this->db->select($check_cart_query);
        
            if ($check_cart) {
                // Nếu sản phẩm đã có, chỉ cần tăng số lượng
                $update_cart_query = "UPDATE tbl_cart 
                                      SET quantity = quantity + $quantity 
                                      WHERE productId='$id' AND customerId='$customerId'";
                $update_cart = $this->db->update($update_cart_query);
                if ($update_cart) {
                    // Thông báo sản phẩm đã được thêm vào giỏ và số lượng đã được tăng
                    $_SESSION['cart_message'] = 'Đã cập nhật số lượng sản phẩm';
                    $this->update_cart_qty();
                }
            } else {
                // Nếu sản phẩm chưa có, thêm vào giỏ hàng mới
                $query_insert = "INSERT INTO tbl_cart(productId, quantity, customerId, productPrice, image, productName) 
                                 VALUES ('$id', '$quantity', '$customerId', '$productPrice', '$image', '$productName')";
                $insert_cart = $this->db->insert($query_insert);
                if ($insert_cart) {
                    // Thông báo sản phẩm đã được thêm vào giỏ hàng
                    $_SESSION['cart_message'] = 'Đã thêm sản phẩm vào giỏ hàng';
                    $this->update_cart_qty();
                } else {
                    header('Location:404.php');
                }
            }
        
            // Nếu nhấn "Mua ngay", chuyển hướng đến giỏ hàng
            if ($buy_now) {
                unset($_SESSION['cart_message']);
                $this->update_cart_qty();
                header('Location: cart.php');
                exit();
            }
        }

        // Hàm này chỉ có cart.php dùng
        // =========================================================
        //             Tăng giảm số lượng trong giỏ hàng
        // =========================================================
        public function update_quantity_cart($quantity, $cartId) {
            $quantity = mysqli_real_escape_string($this->db->link, $quantity);
            $cartId = mysqli_real_escape_string($this->db->link, $cartId);
            $query = "UPDATE tbl_cart SET quantity = '$quantity' WHERE cartId = '$cartId'";
            $result = $this->db->update($query);
            if($result){
                $msg = "Cập nhật thành công.";
                // $this->update_cart_qty();
                header('Location:cart.php');
                return $msg;
            } else {
                $msg = "Cập nhật không thành công.";
                return $msg;
            }
        }

        // =========================================================
        //               Xóa sản phẩm trong giỏ hàng
        // =========================================================  
        public function del_product_cart($cartid) {
            $cartid = mysqli_real_escape_string($this->db->link, $cartid);
            $query = "DELETE FROM tbl_cart WHERE cartId = '$cartid'";
            $result = $this->db->delete($query);
            if($result){
                // $this->update_cart_qty();
                header('Location:cart.php');
                exit; 
            } else {
                $msg = "Cập nhật không thành công.";
                return $msg;
            }
        }

        // =========================================================
        //          Cập nhật số lượng sản phẩm trong giỏ
        // =========================================================
        public function update_cart_qty() {
            $qty = 0;
            $get_product_cart = $this->get_product_cart();
            if ($get_product_cart) {
                while ($result = $get_product_cart->fetch_assoc()) {
                    $qty += $result['quantity']; // Tính tổng số lượng
                }
            }
        
            // Cập nhật lại số lượng trong session
            Session::set('qty', $qty);
        }

        // =========================================================
        //              Kiểm tra giỏ có sản phẩm không
        // =========================================================
        public function check_cart(){
            $customerId = Session::get('customer_id');
            $query = "SELECT * FROM tbl_cart WHERE customerId='$customerId'";
            $result = $this->db->select($query);
            return $result;
        }

        // =========================================================
        //              Lấy sản phẩm từ giỏ hàng ra
        // =========================================================
        public function get_product_cart(){
            $customerId = Session::get('customer_id');
            $query = "SELECT * FROM tbl_cart WHERE customerId='$customerId'";
            $result = $this->db->select($query);
            return $result;
        }

        // =========================================================
        //              Đổ sản phẩm từ cart vào order
        // =========================================================
        public function insertOrder($customer_id, $data) {
            $customerId = Session::get('customer_id');
            $receiverName = mysqli_real_escape_string($this->db->link, $data['receiverName']);
            $receiverPhone = mysqli_real_escape_string($this->db->link, $data['receiverPhone']);
            $shippingAddress = mysqli_real_escape_string($this->db->link, $data['shippingAddress']);
            $paymentMethod = isset($data['method']) ? mysqli_real_escape_string($this->db->link, $data['method']) : null;
            $notes = mysqli_real_escape_string($this->db->link, $data['notes']); // Thêm ghi chú
        
            // Kiểm tra các trường không được để trống
            if (empty($receiverName) || empty($receiverPhone) || empty($shippingAddress) || empty($paymentMethod)) {
                return "<span class='error'>Không được để trống thông tin bắt buộc</span>";
            }
        
            $orderDate = date('Y-m-d H:i:s');
            $paymentStatus = 'pending';
            $status = 'pending';
        
            // Lấy danh sách sản phẩm từ giỏ hàng
            $query = "SELECT * FROM tbl_cart WHERE customerId = '$customerId'";
            $get_products = $this->db->select($query);
        
            if ($get_products) {
                // Tính tổng số tiền
                $totalAmount = 0;
                while ($product = $get_products->fetch_assoc()) {
                    $totalAmount += $product['quantity'] * $product['productPrice'];
                }
        
                // Chèn dữ liệu vào bảng tbl_order
                $query_order = "INSERT INTO tbl_order (
                    customerId, orderDate, shippingAddress, paymentMethod, paymentStatus, totalAmount, status, notes, receiverName, receiverPhone
                ) VALUES (
                    '$customer_id', '$orderDate', '$shippingAddress', '$paymentMethod', '$paymentStatus', '$totalAmount', '$status', '$notes', '$receiverName', '$receiverPhone'
                )";
        
                $insert_order = $this->db->insert($query_order);
        
                if ($insert_order) {
                    // Lấy ID của đơn hàng vừa tạo
                    $orderId = $this->db->link->insert_id;
        
                    // Thêm sản phẩm vào bảng tbl_order_details
                    $get_products->data_seek(0); // Reset con trỏ kết quả để duyệt lại
                    while ($product = $get_products->fetch_assoc()) {
                        $productId = $product['productId'];
                        $quantity = $product['quantity'];
                        $unitPrice = $product['productPrice'];
                        $totalPrice = $quantity * $unitPrice;
        
                        $query_order_details = "INSERT INTO tbl_order_details (
                            orderId, productId, quantity, unitPrice, totalPrice
                        ) VALUES (
                            '$orderId', '$productId', '$quantity', '$unitPrice', '$totalPrice'
                        )";
        
                        $this->db->insert($query_order_details);
                    }
        
                    // Xóa giỏ hàng sau khi đặt hàng thành công
                    $this->db->delete("DELETE FROM tbl_cart WHERE customerId = '$customerId'");
        
                    return "<span class='success'>Đơn hàng đã được tạo thành công!</span>";
                } else {
                    return "<span class='error'>Lỗi khi tạo đơn hàng. Vui lòng thử lại!</span>";
                }
            } else {
                return "<span class='error'>Giỏ hàng trống. Không thể tạo đơn hàng!</span>";
            }
        }
        
            public function number_item($customerId){
                $query = "SELECT SUM(quantity) AS total_quantity FROM tbl_cart WHERE customerId='$customerId'";
                $result = $this->db->select($query);
                
                // Kiểm tra nếu có kết quả
                if ($result) {
                    // Lấy số lượng sản phẩm tổng cộng
                    $row = $result->fetch_assoc();
                    return $row['total_quantity']; // Trả về tổng số lượng sản phẩm
                }
                return 0; // Nếu không có sản phẩm nào trong giỏ hàng, trả về 0
            }
        }

?>