<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
 ?>
 
 <?php 
    class product {
        private $db;
        private $fm;

        public function __construct() {
            $this->db =new Database();
            $this->fm =new Format();
        }

        // ================================================
        //            Insert sản phẩm trong admin
        // ================================================
        public function insert_product($data,$files) {
            $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
            $category = mysqli_real_escape_string($this->db->link, $data['category']);
            $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
            $productDesc = mysqli_real_escape_string($this->db->link, $data['productDesc']);
            $productPrice = mysqli_real_escape_string($this->db->link, $data['productPrice']);
            $type = mysqli_real_escape_string($this->db->link, $data['type']);
            
            $permitted = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
            $uploaded_image = "./upload/" . $unique_image;

            if($productName =="" || $category =="" || $brand =="" || 
               $productPrice =="" || $type =="" || $file_name = "" ) {
                $alert = "<span class='error'>Không được để trống thông tin</span>";
                return $alert;
            } else {
                move_uploaded_file($file_temp,$uploaded_image);
                $query = "INSERT INTO tbl_product(productName,catID,brandId,productDesc,productPrice,type, image) 
                VALUES('$productName','$category','$brand','$productDesc','$productPrice','$type','$unique_image')";
                $result =$this->db->insert($query);
                


                if ($result) {
                    // Lấy ID sản phẩm vừa thêm bằng cách sử dụng LAST_INSERT_ID()
                    $queryLastId = "SELECT LAST_INSERT_ID() as lastId";
                    $getLastIdResult = $this->db->select($queryLastId);
                    if ($getLastIdResult) {
                        $row = $getLastIdResult->fetch_assoc();
                        $productId = $row['lastId'];
                
                        // Lưu thông số kỹ thuật vào tbl_measure
                        if (!empty($data['measureName']) && !empty($data['measureValue'])) {
                            foreach ($data['measureName'] as $key => $measureName) {
                                $measureValue = $data['measureValue'][$key];
                                if (!empty($measureName) && !empty($measureValue)) {
                                    $measureQuery = "INSERT INTO tbl_measure(productId, measureName, measureValue) 
                                                     VALUES('$productId', '$measureName', '$measureValue')";
                                    $this->db->insert($measureQuery);
                                }
                            }
                        }
                        return "<span class='success'>Thêm sản phẩm thành công</span>";
                    } else {
                        return "<span class='error'>Không thể lấy ID sản phẩm vừa thêm</span>";
                    }
                } else {
                    return "<span class='error'>Thêm sản phẩm không thành công</span>";
                }
            }
        }

        public function get_measures_by_product($productId) {
            $query = "SELECT measureName, measureValue 
                      FROM tbl_measure 
                      WHERE productId = '$productId'";
            $result = $this->db->select($query);
            return $result;
        }

        // ================================================
        //              Hiện list sản phẩm 
        // ================================================
        public function show_product() {
            $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
                      FROM tbl_product
                      INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
                      INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
                      ORDER BY tbl_product.productId DESC";        
            $result = $this->db->select($query);
            return $result;
        }

        // ================================================
        //           Lấy sản phẩm theo Id
        // ================================================
        public function getproductbyId($id) {
            $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
            $result =$this->db->select($query);
            return $result;
        }

        // ================================================
        //            Update sản phẩm trong admin
        // ================================================
        public function update_product($data, $files, $id) {
            $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
            $category = mysqli_real_escape_string($this->db->link, $data['category']);
            $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
            $productDesc = mysqli_real_escape_string($this->db->link, $data['productDesc']);
            $productPrice = mysqli_real_escape_string($this->db->link, $data['productPrice']);
            $type = mysqli_real_escape_string($this->db->link, $data['type']);
            
            $permitted = array('jpg', 'jpeg', 'png', 'gif');
            
            // Lấy ảnh cũ từ cơ sở dữ liệu
            $query = "SELECT image FROM tbl_product WHERE productId = '$id'";
            $result = $this->db->select($query);
            $old_image = '';
            if ($result) {
                $row = $result->fetch_assoc();
                $old_image = $row['image']; // Lưu ảnh cũ vào biến
            }
        
            // Kiểm tra các trường bắt buộc (trừ productDesc)
            if ($productName == "" || $category == "" || $brand == "" || $productPrice == "" || $type == "") {
                $alert = "<span class='error'>Không được để trống thông tin</span>";
                return $alert;
            } else {
                // Nếu có ảnh mới
                if (!empty($files['image']['name'])) {
                    $file_name = $files['image']['name'];
                    $file_size = $files['image']['size'];
                    $file_temp = $files['image']['tmp_name'];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
                    $uploaded_image = "./upload/" . $unique_image;
        
                    // Kiểm tra kích thước và định dạng ảnh
                    if ($file_size > 1048567) {
                        $alert = "<span class='error'>Độ phân giải ảnh quá 10MB</span>";
                        return $alert;
                    } elseif (!in_array($file_ext, $permitted)) {
                        $alert = "<span class='error'>Bạn chỉ có thể upload file: ".implode(',', $permitted) . "</span>";
                        return $alert;
                    }
        
                    // Move ảnh mới vào thư mục upload
                    move_uploaded_file($file_temp, $uploaded_image);
        
                    // Xóa ảnh cũ nếu có
                    if (!empty($old_image) && file_exists("./upload/" . $old_image)) {
                        unlink("./upload/" . $old_image);
                    }
        
                    // Cập nhật sản phẩm với ảnh mới
                    $query = "UPDATE tbl_product 
                              SET 
                                productName = '$productName',
                                catId = '$category',
                                brandId = '$brand',
                                productDesc = '$productDesc',
                                productPrice = '$productPrice',
                                image = '$unique_image',
                                type = '$type'
                              WHERE productId = '$id'";
                } else {
                    // Nếu không có ảnh mới, giữ nguyên ảnh cũ
                    $query = "UPDATE tbl_product 
                              SET 
                                productName = '$productName',
                                catId = '$category',
                                brandId = '$brand',
                                productDesc = '$productDesc',
                                productPrice = '$productPrice',
                                type = '$type'
                              WHERE productId = '$id'";
                }
        
                // Kiểm tra nếu có thông số kỹ thuật (measureName và measureValue)
                $measureUpdateSuccess = true; // Cờ theo dõi trạng thái

                // Kiểm tra nếu mảng thông số kỹ thuật có dữ liệu không 
                // (nếu có tức thì sẽ đổi thực hiện lại, dù người dùng không update thì vẫn sẽ gửi form mới)
                if (isset($data['measureName']) && isset($data['measureValue'])) {
                    $measureNames = $data['measureName'];
                    $measureValues = $data['measureValue'];
                    // Xóa tất cả thông số kỹ thuật cũ
                    $delete_query = "DELETE FROM tbl_measure WHERE productId = '$id'";
                    $delete_result = $this->db->delete($delete_query);

                    // Thêm lại các thông số mới
                    foreach ($measureNames as $index => $measureName) {
                        $measureValue = $measureValues[$index];
                        if (!empty($measureName) && !empty($measureValue)) {
                            $insert_query = "INSERT INTO tbl_measure (productId, measureName, measureValue)
                                            VALUES ('$id', '$measureName', '$measureValue')";
                            $insert_result = $this->db->insert($insert_query);

                            // Nếu một insert thất bại, gán cờ thất bại
                            if (!$insert_result) {
                                $measureUpdateSuccess = false;
                                break;
                            }
                        }
                    }
                } else {
                // Nếu xóa hết độ đo thì không có độ đo nào được gửi, xóa tất cả thông số kỹ thuật cũ
                    $delete_query = "DELETE FROM tbl_measure WHERE productId = '$id'";
                    $delete_result = $this->db->delete($delete_query);
                }
        
                // Thực hiện query
                $result = $this->db->update($query);
                if ($result && $measureUpdateSuccess) {
                    $alert = "<span class='success'>Sửa sản phẩm và thông số kỹ thuật thành công</span>";
                } elseif ($result) {
                    $alert = "<span class='error'>Sản phẩm đã được cập nhật nhưng thông số kỹ thuật không thể sửa</span>";
                } elseif ($measureUpdateSuccess) {
                    $alert = "<span class='error'>Thông số kỹ thuật đã được sửa nhưng sản phẩm không thể cập nhật</span>";
                } else {
                    $alert = "<span class='error'>Cập nhật sản phẩm và thông số kỹ thuật thất bại</span>";
                }
                return $alert;
            }
        }        
        
        // ================================================
        //            Delete sản phẩm trong admin
        // ================================================
        public function del_product($id) {
            // Bước 1: Lấy đường dẫn ảnh của sản phẩm từ cơ sở dữ liệu
            $query = "SELECT image FROM tbl_product WHERE productId = '$id'";
            $image_result = $this->db->select($query);
            
            // Kiểm tra nếu có kết quả và lấy đường dẫn ảnh
            if ($image_result) {
                $image_data = $image_result->fetch_assoc();
                $image_name = $image_data['image']; // Giả sử cột 'image' chứa tên file ảnh
                $image_path = './upload/' . $image_name; // Kết hợp với thư mục upload
                
                // Bước 2: Kiểm tra nếu ảnh tồn tại trên server và xóa
                if (file_exists($image_path)) {
                    unlink($image_path); // Xóa file ảnh
                }
            }
        
            // Bước 3: Xóa bản ghi trong bảng tbl_measure (nếu có)
            $delete_query = "DELETE FROM tbl_measure WHERE productId = '$id'";
            $delete_result = $this->db->delete($delete_query);
        
            // Bước 4: Xóa bản ghi sản phẩm trong bảng tbl_product
            $query = "DELETE FROM tbl_product WHERE productId = '$id'";
            $result = $this->db->delete($query);
        
            // Kiểm tra kết quả và trả về thông báo
            if ($result && $delete_result) {
                $alert = "<span class='success'>Xóa sản phẩm thành công</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Xóa sản phẩm không thành công</span>";
                return $alert;
            }
        }

        // ================================================
        //    Hiển thị sản phẩm nổi bật trên front end
        // ================================================
        public function getproduct_featured($limit = 5) {
            $query = "SELECT * FROM tbl_product WHERE type = '1' LIMIT $limit";
            $result = $this->db->select($query);
            return $result;
        }

        // ================================================
        //    Hiển thị sản phẩm mới trên front end
        // ================================================
        public function getproduct_new($limit = 5) {
            $query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT $limit";
            $result = $this->db->select($query);
            return $result;
        }
    
        // ================================================
        //           Hiển thị chi tiết sản phẩm 
        // ================================================
        public function get_details($id) {
            $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
                      FROM tbl_product
                      INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
                      INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId 
                      WHERE tbl_product.productId = '$id'";        
            $result = $this->db->select($query);
            return $result;
        }

        // ================================================
        //           Hiển thị sản phẩm theo cat
        // ================================================
        public function get_product_by_cat($id) {
            $query = "SELECT * FROM tbl_product WHERE catId = '$id' order by catId desc";
            $result = $this->db->select($query);
            return $result;
        }

        // ================================================
        //           Hiển thị sản phẩm theo brand
        // ================================================
        public function get_product_by_brand($id) {
            $query = "SELECT * FROM tbl_product WHERE brandId = '$id' order by brandId desc";
            $result = $this->db->select($query);
            return $result;
        }


        // ================================================
        //           Hiển thị sản phẩm theo search
        // ================================================
        public function get_product_by_search($search_name, $danhmuc){
            $query = "SELECT distinct * 
                        FROM tbl_product 
                        JOIN tbl_category ON tbl_product.catID = tbl_category.catID
                        JOIN tbl_brand ON tbl_product.brandID = tbl_brand.brandID
                        JOIN tbl_measure ON tbl_product.productID = tbl_measure.productID
                        WHERE tbl_category.catName LIKE '$danhmuc' AND (tbl_product.productName LIKE '$search_name'
                        OR tbl_category.catName LIKE '$search_name'
                        OR tbl_brand.brandName LIKE '$search_name' 
                        OR tbl_measure.measureName LIKE '$search_name'
                        OR tbl_measure.measureValue LIKE '$search_name') LIMIT 5";
            $result = $this->db->select($query);
            return $result;
        }
    }
 ?>