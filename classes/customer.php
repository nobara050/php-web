<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');

    class customer {

        private $db;
        private $fm;

        public function __construct() {
            $this->db = new Database();
            $this->fm = new Format();
        }
        
        // =========================================================
        //          Thêm người dùng, đùng khi đăng ký
        // =========================================================
        public function insert_customer($data) {
            $name = mysqli_real_escape_string($this->db->link, $data['name']);
            $email = mysqli_real_escape_string($this->db->link, $data['email']);
            $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
            $password = mysqli_real_escape_string($this->db->link, md5($data['password']));

            if ($name == "" || $email == "" || $phone == "" || $password == "") {
                return "<span class='error'>Không được để trống thông tin khi đăng ký</span>";
            } else{
                    $check_email = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1";
                    $result_check = $this->db->select($check_email);
                if ($result_check) {
                    return "<span class='error'>Email đã được đăng ký, vui lòng sử dụng email khác!</span>";
                }

                $query = "INSERT INTO tbl_customer(name, email, phone, password) 
                        VALUES('$name','$email','$phone','$password')";

                $result = $this->db->insert($query);
                if ($result) {
                    return "<span class='success'>Đăng ký thành công, xin hãy đăng nhập tài khoản</span>";
                } else {
                    return "<span class='error'>Lỗi hệ thống, vui lòng đăng ký lại sau</span>";
                }
            }
        }

    
        // =========================================================
        //    Khi người dùng login, lưu session đăng nhập là true
        // =========================================================
        public function login_customer($data) {
            $email = mysqli_real_escape_string($this->db->link, $data['email']);
            $password = mysqli_real_escape_string($this->db->link, md5($data['password']));
        
            if ($email == "" || $password == "") {
                return "<span class='error'>Bạn chưa nhập tài khoản hoặc mật khẩu</span>";
            }
        
            $check_login = "SELECT * FROM tbl_customer WHERE email = '$email' and password ='$password'";
            $result_check = $this->db->select($check_login);
        
            if ($result_check != false) {
                $value = $result_check->fetch_assoc();
                Session::set('customer_login', true);
                Session::set('customer_id', $value['id']);
                Session::set('customer_name', $value['name']);
                return "<span class='success'>Đăng nhập thành công!</span>";
            } else {
                return "<span class='error'>Tài khoản và mật khẩu không chính xác</span>";
            }
        }
     

        // =========================================================
        //           Hiện thông tin khách hàng theo id
        // =========================================================
        public function show_customer($id){
            $query = "SELECT * FROM tbl_customer WHERE id = '$id'";
            $result = $this->db->select($query);
            return $result;
        }

        // =========================================================
        //          Cập nhật thông tin khách hàng
        // =========================================================
        public function update_customer($data, $id) {
            // Kết nối đến database
            $name = isset($data['name']) ? mysqli_real_escape_string($this->db->link, $data['name']) : null;
            $email = isset($data['email']) ? mysqli_real_escape_string($this->db->link, $data['email']) : null;
            $address = isset($data['address']) ? mysqli_real_escape_string($this->db->link, $data['address']) : null;
            $phone = isset($data['phone']) ? mysqli_real_escape_string($this->db->link, $data['phone']) : null;
            $city = isset($data['city']) ? mysqli_real_escape_string($this->db->link, $data['city']) : null;
            $country = isset($data['country']) ? mysqli_real_escape_string($this->db->link, $data['country']) : null;
        
            // Kiểm tra các giá trị bắt buộc
            if (empty($name) || empty($email) || empty($phone)) {
                return "<span class='error'>Các trường bắt buộc không được để trống</span>";
            }
        
            // Danh sách các trường cần cập nhật
            $fields = [];
            if (!empty($name)) $fields[] = "name='$name'";
            if (!empty($email)) $fields[] = "email='$email'";
            if (!empty($address)) $fields[] = "address='$address'";
            if (!empty($phone)) $fields[] = "phone='$phone'";
            if (!empty($city)) $fields[] = "city='$city'";
            if (!empty($country)) $fields[] = "country='$country'";
        
            // Nếu không có trường nào cần cập nhật, trả về thông báo
            if (empty($fields)) {
                return "<span class='error'>Không có thay đổi nào để cập nhật</span>";
            }
        
            // Xây dựng câu lệnh SQL
            $fields_sql = implode(', ', $fields);
            $query = "UPDATE tbl_customer SET $fields_sql WHERE id='$id'";
        
            // Thực hiện truy vấn
            $result = $this->db->update($query);
            if ($result) {
                return "<span class='success'>Cập nhật thông tin thành công</span>";
            } else {
                return "<span class='error'>Cập nhật thất bại, vui lòng thử lại sau!</span>";
            }
        }
        
        
        public function del_customer($id) {
            $query = "DELETE FROM tbl_customer WHERE id = '$id'";
            $result =$this->db->delete($query);
            if($result) {
                $alert = "<span class='success'>Xóa khách hàng thành công</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Xóa khách hàng không thành công</span>";
                return $alert;
            } 
        }

        public function show_customer_list() {
            $query = "SELECT * FROM tbl_customer";
            $result = $this->db->select($query);
            return $result;
        }
    }
?>