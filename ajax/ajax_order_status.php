<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/connection_no_class.php');

    // Lấy dữ liệu từ AJAX
    $status = $_POST['status'];
    $orderId = $_POST['orderId'];

    // Cập nhật trạng thái thanh toán
    $sql = "UPDATE tbl_order SET status = ? WHERE orderId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $orderId);

    if ($stmt->execute()) {
        echo "Trạng thái đã được cập nhật.";
    } else {
        echo "Lỗi: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
?>