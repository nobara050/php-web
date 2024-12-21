<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
?>

<?php
    class order {

        private $db;
        private $fm;

        public function __construct() {
            $this->db = new Database();
            $this->fm = new Format();
        }

        // =========================================================
        //              Hiện list đơn đặt hàng
        // =========================================================
        public function show_order() {
            $query = "SELECT * FROM tbl_order ORDER BY orderId DESC";
            $result =$this->db->select($query);
            return $result;
        }

        // =========================================================
        //                  Hiện chi tiết list
        // =========================================================
        public function show_order_details($id) {
            $query = "SELECT * FROM tbl_order_details WHERE orderId = '$id' ORDER BY orderDetailId DESC";
            $result =$this->db->select($query);
            return $result;
        }

        public function cancel_order($orderId) {
            // Xử lý đầu vào (kiểm tra và bảo vệ dữ liệu)
            $orderId = mysqli_real_escape_string($this->db->link, $orderId);
        
            // Kiểm tra nếu orderId không rỗng
            if (empty($orderId)) {
                $alert = "<span class='error'>ID đơn hàng không hợp lệ</span>";
                return $alert;
            } else {
                // Câu lệnh SQL để cập nhật trạng thái đơn hàng thành 'cancel'
                $query = "UPDATE tbl_order SET status = 'cancel' WHERE orderId = '$orderId'";
                // Gọi hàm thực thi câu lệnh SQL
                $result = $this->db->update($query); // Hàm insert của bạn sẽ thực thi câu lệnh này
        
                // Kiểm tra nếu cập nhật thành công
                if ($result) {
                    $alert = "<span class='success'>Đơn hàng đã được hủy thành công</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Có lỗi xảy ra khi hủy đơn hàng</span>";
                    return $alert;
                }
            }
        }

        public function check_cancel($orderId) {
            $orderId = mysqli_real_escape_string($this->db->link, $orderId);
            $query = "SELECT status FROM tbl_order WHERE orderId = '$orderId'";
            $result = $this->db->select($query);
        
            // Kiểm tra xem có kết quả không
            if ($result && $row = $result->fetch_assoc()) {
                return $row['status']; // Trả về giá trị 'status'
            }
            return false; // Trả về false nếu không có kết quả
        }
        
        // public function repending_order($orderId){
        //     // Xử lý đầu vào (kiểm tra và bảo vệ dữ liệu)
        //     $orderId = mysqli_real_escape_string($this->db->link, $orderId);
        
        //     // Kiểm tra nếu orderId không rỗng
        //     if (empty($orderId)) {
        //         $alert = "<span class='error'>ID đơn hàng không hợp lệ</span>";
        //         return $alert;
        //     } else {
        //         // Câu lệnh SQL để cập nhật trạng thái đơn hàng thành 'cancel'
        //         $query = "UPDATE tbl_order SET status = 'pending' WHERE orderId = '$orderId'";
        //         // Gọi hàm thực thi câu lệnh SQL
        //         $result = $this->db->update($query); // Hàm insert của bạn sẽ thực thi câu lệnh này
        
        //         // Kiểm tra nếu cập nhật thành công
        //         if ($result) {
        //             $alert = "<span class='success'>Đơn hàng đã được đặt lại thành công</span>";
        //             return $alert;
        //         } else {
        //             $alert = "<span class='error'>Có lỗi xảy ra khi đặt lại đơn hàng</span>";
        //             return $alert;
        //         }
        //     }
        // }
        
    }
?>