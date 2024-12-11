<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class admin {

        private $db;
        private $fm;

        public function __construct() {
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function insert_admin($data, $files) {
            // Xử lý dữ liệu đầu vào
            $adminName = mysqli_real_escape_string($this->db->link, $data['adminName']);
            $adminEmail = mysqli_real_escape_string($this->db->link, $data['adminEmail']);
            $adminPhone = mysqli_real_escape_string($this->db->link, $data['adminPhone']);
            $adminUser = mysqli_real_escape_string($this->db->link, $data['adminUser']);
            $adminPass = mysqli_real_escape_string($this->db->link, md5($data['adminPass']));
        
            // Kiểm tra thông tin đầu vào
            if ($adminName == "" || $adminEmail == "" || $adminPhone == "" || $adminUser == "" || $adminPass == "") {
                return "<span class='error'>Không được để trống thông tin khi đăng ký</span>";
            }
        
            // Kiểm tra hình ảnh
            $permitted = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
            $uploaded_image = "./upload/" . $unique_image;
        
            // Nếu không tải hình ảnh
            if (empty($file_name)) {
                return "<span class='error'>Vui lòng tải lên hình ảnh</span>";
            }
        
            // Kiểm tra loại file hợp lệ
            if (!in_array($file_ext, $permitted)) {
                return "<span class='error'>Chỉ chấp nhận các định dạng: " . implode(", ", $permitted) . "</span>";
            }
        
            // Kiểm tra tài khoản đã tồn tại
            $check_user = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' LIMIT 1";
            $result_check = $this->db->select($check_user);
            if ($result_check) {
                return "<span class='error'>Tên đăng nhập đã tồn tại, vui lòng sử dụng tên khác!</span>";
            }
        
            // Upload ảnh và thêm vào database
            move_uploaded_file($file_temp, $uploaded_image);
        
            $query = "INSERT INTO tbl_admin(adminName, adminEmail, adminPhone, adminUser, adminPass, adminAvatar) 
                      VALUES('$adminName', '$adminEmail', '$adminPhone', '$adminUser', '$adminPass', '$unique_image')";
        
            $result = $this->db->insert($query);
            if ($result) {
                return "<span class='success'>Tạo thành công thành viên mới</span>";
            } else {
                return "<span class='error'>Lỗi hệ thống, vui lòng đăng ký lại sau</span>";
            }
        }
        

        public function show_admin($id){
            $query = "SELECT * FROM tbl_admin WHERE adminId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }

        public function update_admin($data, $id) {
            $adminName = mysqli_real_escape_string($this->db->link, $data['adminName']);
            $adminEmail = mysqli_real_escape_string($this->db->link, $data['adminEmail']);
            $adminPhone = mysqli_real_escape_string($this->db->link, $data['adminPhone']);
            $adminUser = mysqli_real_escape_string($this->db->link, $data['adminUser']);
            $adminPass = !empty($data['adminPass']) 
                ? ", adminPass = '" . mysqli_real_escape_string($this->db->link, md5($data['adminPass'])) . "'"
                : ""; // Nếu mật khẩu trống, không cập nhật cột này
            $level = mysqli_real_escape_string($this->db->link, $data['level']);
        
            if ($adminName == "" || $adminEmail == "" || $adminPhone == "" || $adminUser == "" || $level == "") {
                return "<span class='error'>Không được để trống thông tin bắt buộc</span>";
            } else {
                // Kiểm tra tên tài khoản đã tồn tại chưa
                $check_user = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' AND adminId != '$id' LIMIT 1";
                $result_check = $this->db->select($check_user);
                if ($result_check) {
                    return "<span class='error'>Tên tài khoản đã được sử dụng, vui lòng chọn tên khác!</span>";
                }
        
                // Cập nhật thông tin admin
                $query = "UPDATE tbl_admin 
                          SET adminName = '$adminName', 
                              adminEmail = '$adminEmail', 
                              adminPhone = '$adminPhone', 
                              adminUser = '$adminUser', 
                              level = '$level' 
                              $adminPass 
                          WHERE adminId = '$id'";
        
                $result = $this->db->update($query);
                if ($result) {
                    return "<span class='success'>Cập nhật thông tin thành công</span>";
                } else {
                    return "<span class='error'>Lỗi hệ thống, vui lòng thử lại sau</span>";
                }
            }
        }
        
        
        
        public function del_admin($id) {
            $query = "DELETE FROM tbl_admin WHERE adminId = '$id'";
            $result =$this->db->delete($query);
            if($result) {
                $alert = "<span class='success'>Xóa khách hàng thành công</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Xóa khách hàng không thành công</span>";
                return $alert;
            } 
        }

        public function show_admin_list() {
            $query = "SELECT * FROM tbl_admin";
            $result = $this->db->select($query);
            return $result;
        }
    }

    
?>