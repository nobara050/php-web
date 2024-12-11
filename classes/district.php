<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class district {

        private $db;
        private $fm;

        public function __construct() {
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function get_district($id){
            $query = "SELECT * FROM district WHERE province_id = '$id'";
            $result = $this->db->select($query);
            return $result;
        }
    }
?>