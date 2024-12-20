<?php
    // Include kết nối database
    include 'lib/connection_no_class.php';

    if (isset($_GET['q'])) {
        $q = $_GET['q'];

        // Sử dụng prepared statement để tránh SQL Injection
        $stmt = $conn->prepare("SELECT distinct tbl_product.productId, tbl_product.productName 
        FROM tbl_product 
        JOIN tbl_category ON tbl_product.catID = tbl_category.catID
        JOIN tbl_brand ON tbl_product.brandID = tbl_brand.brandID
        JOIN tbl_measure ON tbl_product.productID = tbl_measure.productID
        WHERE tbl_product.productName LIKE ? 
        OR tbl_category.catName LIKE ? 
        OR tbl_brand.brandName LIKE ? 
        OR tbl_measure.measureName LIKE ? LIMIT 5
        ");
        $searchTerm = "%$q%";
        $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        $suggestions = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $suggestions[] = $row;
            }
        }

        // Trả về kết quả dưới dạng JSON
        echo json_encode($suggestions);
    }
?>