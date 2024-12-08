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

        // Dùng thêm sản phẩm trong detail vào cart
        public function add_to_cart($quantity, $id, $buy_now = false){
            $quantity = $this->fm->validation($quantity);
            $quantity = mysqli_real_escape_string($this->db->link, $quantity);
            $id = mysqli_real_escape_string($this->db->link, $id);
            $sId = session_id();
        
            // Lấy thông tin sản phẩm
            $query = "SELECT * FROM tbl_product WHERE productId='$id'";
            $result = $this->db->select($query)->fetch_assoc();
            $image = $result["image"];
            $price = $result["price"];
            $productName = $result["productName"];
        
            // Kiểm tra xem sản phẩm đã có trong giỏ chưa
            $check_cart_query = "SELECT * FROM tbl_cart WHERE productId='$id' AND sId='$sId'";
            $check_cart = $this->db->select($check_cart_query);
        
            if ($check_cart) {
                // Nếu sản phẩm đã có, chỉ cần tăng số lượng
                $update_cart_query = "UPDATE tbl_cart 
                                      SET quantity = quantity + $quantity 
                                      WHERE productId='$id' AND sId='$sId'";
                $update_cart = $this->db->update($update_cart_query);
                if ($update_cart) {
                    // Thông báo sản phẩm đã được thêm vào giỏ và số lượng đã được tăng
                    $_SESSION['cart_message'] = 'Đã cập nhật số lượng sản phẩm';
                    $this->update_cart_qty();
                }
            } else {
                // Nếu sản phẩm chưa có, thêm vào giỏ hàng mới
                $query_insert = "INSERT INTO tbl_cart(productId, quantity, sId, price, image, productName) 
                                 VALUES ('$id', '$quantity', '$sId', '$price', '$image', '$productName')";
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

        public function check_cart(){
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart WHERE sId='$sId'";
            $result = $this->db->select($query);
            return $result;
        }

        public function get_product_cart(){
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart WHERE sId='$sId'";
            $result = $this->db->select($query);
            return $result;
        }
    }
?>