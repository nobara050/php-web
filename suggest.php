<?php
// Include kết nối database
include 'lib/connection_no_class.php';

$q = $_GET['q'];
$suggestions = [];

if (!empty($q)) {
    // Sử dụng prepared statement để tránh SQL Injection
    $stmt = $conn->prepare("SELECT productName FROM tbl_cart WHERE productName LIKE ? LIMIT 5");
    $searchTerm = "%$q%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $suggestions[] = $row;
        }
    }
}

// Trả về kết quả dưới dạng JSON
echo json_encode($suggestions);
?>
