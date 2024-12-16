<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class wards {

        private $db;
        private $fm;

        public function __construct() {
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function getwardsbyId($id) {
            // Truy vấn cơ sở dữ liệu
            $query = "SELECT * FROM wards WHERE wards_id = '$id' ORDER BY name ASC";
            $result = $this->db->select($query);
        
            // Kiểm tra nếu truy vấn thành công và có dữ liệu
            if ($result && $result->num_rows > 0) {
                return $result;  // Trả về đối tượng kết quả
            } else {
                return null;  // Nếu không có dữ liệu, trả về null
            }
        }
    }
?>