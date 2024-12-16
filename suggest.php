<?php 
    include 'lib/database.php';
    include 'helpers/format.php';

    $db = new Database();
    $q = $_GET['q'];
    $suggestion = [];
    //câu lệnh này sẽ lấy ra 10 sản phẩm có tên giống với từ khóa mà người dùng nhập vào ô tìm kiếm
    $query = "SELECT productName FROM tbl_cart WHERE productName LIKE '%$q%' LIMIT 5";
    //thực thi câu lệnh
    $result = $db->select($query);
    //nếu có kết quả thì sẽ thực hiện vòng lặp while để lấy ra tên sản phẩm
    if ($result) {
        while($row = $result->fetch_assoc()) {
        $suggestion[] = $row['productName'];
  }
} 
   echo json_encode($suggestion);

?>