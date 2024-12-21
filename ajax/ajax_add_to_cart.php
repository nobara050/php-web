<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../classes/product.php');
    include_once ($filepath.'/../classes/cart.php');
    include_once ($filepath.'/../lib/session.php');

    session_start();
    $product_id = $_POST['proid'] ?? null;
    $quantity = $_POST['quantity'] ?? 1;
    $action = $_POST['action'];

    // Kiểm tra nếu product_id hợp lệ
    if (!$product_id) {
        echo json_encode(['success' => false, 'message' => 'Sản phẩm không hợp lệ']);
        exit;
    }

    $login_check = Session::get('customer_login');
    if ($login_check == false) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để tiếp tục.' , 'redirect' => 'login.php']);
        exit; 
    }

    //  add hoặc buy
    if ($action == 'add') {
        $ct = new cart();
        $AddToCart = $ct->add_to_cart($quantity, $product_id, false);
        if ($_SESSION['cart_message']!=""){
            $message = $_SESSION['cart_message'];
            $numberItems = $ct->number_item(Session::get('customer_id'));
        }
    }
    if ($action == 'buy') {
        $ct = new cart();
        $AddToCart = $ct->add_to_cart($quantity, $product_id, false);
        $message = "Đang chuyển hướng giỏ hàng...";
        $numberItems = $ct->number_item(Session::get('customer_id'));
        echo json_encode(['success' => true, 'message' => $message, 'redirect' => 'cart.php', 'numberItems' => $numberItems]);
        exit;
    }
    

    // Trả về phản hồi cho client
    echo json_encode(['success' => true, 'message' => $message, 'numberItems' => $numberItems]);
?>
