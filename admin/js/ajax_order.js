// =============================================================================
//                Ajax đổi combobox của Tình trạng thanh toán
// =============================================================================

function updatePaymentStatus(status, orderId) {
  // Tạo đối tượng XMLHttpRequest
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../ajax/ajax_order_paymentStatus.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // Gửi dữ liệu tới ajax_order.php
  xhr.send(
    "status=" +
      encodeURIComponent(status) +
      "&orderId=" +
      encodeURIComponent(orderId)
  );

  // Xử lý phản hồi từ server
  xhr.onload = function () {
    if (xhr.status === 200) {
      console.log("Cập nhật thành công: " + xhr.responseText);
    } else {
      console.error("Lỗi khi cập nhật trạng thái");
    }
  };
}

// =============================================================================
//                Ajax đổi combobox của Tình trạng thanh toán
// =============================================================================
function updateStatus(status, orderId) {
  // Tạo đối tượng XMLHttpRequest
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../ajax/ajax_order_status.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // Gửi dữ liệu tới ajax_order.php
  xhr.send(
    "status=" +
      encodeURIComponent(status) +
      "&orderId=" +
      encodeURIComponent(orderId)
  );

  // Xử lý phản hồi từ server
  xhr.onload = function () {
    if (xhr.status === 200) {
      console.log("Cập nhật thành công: " + xhr.responseText);
    } else {
      console.error("Lỗi khi cập nhật trạng thái");
    }
  };
}
