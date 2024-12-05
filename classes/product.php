<?php
    include_once '../lib/database.php';
    include_once '../helpers/format.php';
 ?>
 
 <?php 
    class product {
        private $db;
        private $fm;

        public function __construct() {
            $this->db =new Database();
            $this->fm =new Format();
        }

        public function insert_product($data,$files) {
            $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
            $category = mysqli_real_escape_string($this->db->link, $data['category']);
            $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
            $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
            $price = mysqli_real_escape_string($this->db->link, $data['price']);
            $type = mysqli_real_escape_string($this->db->link, $data['type']);
            
            $permitted = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
            $uploaded_image = "./upload/" . $unique_image;

            if($productName =="" || $category =="" || $brand =="" || $product_desc =="" || 
               $price =="" || $type =="" || $file_name = "" ) {
                $alert = "<span class='error'>Không được để trống thông tin</span>";
                return $alert;
            } else {
                move_uploaded_file($file_temp,$uploaded_image);
                $query = "INSERT INTO tbl_product(productName,catID,brandId,product_desc,price,type, image) 
                VALUES('$productName','$category','$brand','$product_desc','$price','$type','$unique_image')";
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

        public function show_product() {
            $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
                      FROM tbl_product
                      INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
                      INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
                      ORDER BY tbl_product.productId DESC";        
            $result = $this->db->select($query);
            return $result;
        }

        public function getproductbyId($id) {
            $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
            $result =$this->db->select($query);
            return $result;
        }

        // public function update_product($data,$files,$id) {
            
        //     $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        //     $category = mysqli_real_escape_string($this->db->link, $data['category']);
        //     $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
        //     $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
        //     $price = mysqli_real_escape_string($this->db->link, $data['price']);
        //     $type = mysqli_real_escape_string($this->db->link, $data['type']);
            
        //     $permitted = array('jpg', 'jpeg', 'png', 'gif');
            
        //     $file_name = $_FILES['image']['name'];
        //     $file_size = $_FILES['image']['size'];
        //     $file_temp = $_FILES['image']['tmp_name'];
            
        //     $div = explode('.', $file_name);
        //     $file_ext = strtolower(end($div));
        //     $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        //     $uploaded_image = "./upload/" . $unique_image;

        //     if($productName =="" || $category =="" || $brand =="" || $product_desc =="" || 
        //        $price =="" || $type =="") {
        //         $alert = "<span class='error'>Không được để trống thông tin</span>";
        //         return $alert;
        //     } else {
        //         if (!empty($file_name)) {
        //             // Nếu người dùng sửa xong chọn ảnh mới
        //             if ($file_size > 1048567) {
        //                 $alert = "<span class='error'>Độ phân giải ảnh quá 10MB</span>";
        //                 return $alert;
        //             } elseif (!in_array($file_ext, $permitted)) {
        //                 $alert = "<span class='error'>Bạn chỉ có thể upload file: ".implode(',', $permitted) . "</span>";
        //                 return $alert;
        //             }

        //             move_uploaded_file($file_temp, $uploaded_image);

        //             $query = "UPDATE tbl_product 
        //                       SET 
        //                         productName = '$productName',
        //                         catId = '$category',
        //                         brandId = '$brand',
        //                         product_desc = '$product_desc',
        //                         price = '$price',
        //                         image = '$unique_image',
        //                         type = '$type'
        //                       WHERE productId = '$id'";
        //         } else {
        //             // Nếu người dùng sửa xong không chọn ảnh mới
        //             $query = "UPDATE tbl_product 
        //                       SET 
        //                         productName = '$productName',
        //                         catId = '$category',
        //                         brandId = '$brand',
        //                         product_desc = '$product_desc',
        //                         price = '$price',
        //                         type = '$type'
        //                       WHERE productId = '$id'";
                    
        //         }
        //         // Xử lý cập nhật thông số kỹ thuật
        //         $measureNames = $data['measureName'];
        //         $measureValues = $data['measureValue'];

        //         $measureUpdateSuccess = true; // Cờ theo dõi trạng thái

        //         if (!empty($measureNames) && !empty($measureValues)) {
        //             // Xóa tất cả thông số kỹ thuật cũ liên quan đến sản phẩm
        //             $delete_query = "DELETE FROM tbl_measure WHERE productId = '$id'";
        //             $delete_result = $this->db->delete($delete_query);

        //             if ($delete_result) {
        //                 // Thêm lại các thông số mới
        //                 foreach ($measureNames as $index => $measureName) {
        //                     $measureValue = $measureValues[$index];
        //                     if (!empty($measureName) && !empty($measureValue)) {
        //                         $insert_query = "INSERT INTO tbl_measure (productId, measureName, measureValue)
        //                                         VALUES ('$id', '$measureName', '$measureValue')";
        //                         $insert_result = $this->db->insert($insert_query);

        //                         // Nếu một insert thất bại, gán cờ thất bại
        //                         if (!$insert_result) {
        //                             $measureUpdateSuccess = false;
        //                             break;
        //                         }
        //                     }
        //                 }
        //             } else {
        //                 $measureUpdateSuccess = false;
        //             }
        //         }

        //         $result =$this->db->update($query);
        //         if ($result && $measureUpdateSuccess) {
        //             $alert = "<span class='success'>Sửa sản phẩm và thông số kỹ thuật thành công</span>";
        //         } elseif ($result) {
        //             $alert = "<span class='error'>Sản phẩm đã được cập nhật nhưng thông số kỹ thuật không thể sửa</span>";
        //         } elseif ($measureUpdateSuccess) {
        //             $alert = "<span class='error'>Thông số kỹ thuật đã được sửa nhưng sản phẩm không thể cập nhật</span>";
        //         } else {
        //             $alert = "<span class='error'>Cập nhật sản phẩm và thông số kỹ thuật thất bại</span>";
        //         }
        //         return $alert;
                
        //     }
        // }

        public function update_product($data, $files, $id) {
            $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
            $category = mysqli_real_escape_string($this->db->link, $data['category']);
            $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
            $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
            $price = mysqli_real_escape_string($this->db->link, $data['price']);
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
        
            // Kiểm tra các trường bắt buộc (trừ product_desc)
            if ($productName == "" || $category == "" || $brand == "" || $price == "" || $type == "") {
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
                                product_desc = '$product_desc',
                                price = '$price',
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
                                product_desc = '$product_desc',
                                price = '$price',
                                type = '$type'
                              WHERE productId = '$id'";
                }
        
                // Kiểm tra nếu có thông số kỹ thuật (measureName và measureValue)
                $measureUpdateSuccess = true; // Cờ theo dõi trạng thái

                // Kiểm tra nếu mảng thông số kỹ thuật có dữ liệu
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
                    // Nếu không có độ đo nào được gửi, xóa tất cả thông số kỹ thuật cũ
                    $delete_query = "DELETE FROM tbl_measure WHERE productId = '$id'";
                    $delete_result = $this->db->delete($delete_query);
                }
        
                // Cập nhật sản phẩm
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

        public function del_product($id){
            $query = "DELETE FROM tbl_product WHERE productId = '$id'";
            $result =$this->db->delete($query);
            if($result) {
                $alert = "<span class='success'>Xóa sản phẩm thành công</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Xóa sản phẩm không thành công</span>";
                return $alert;
            } 
        }

    }
 ?>