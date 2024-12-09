// =============================================================================
//                      NÚT TĂNG GIẢM SỐ LƯỢNG CART
// =============================================================================
document.addEventListener("DOMContentLoaded", function () {
  // Xử lý click sự kiện tăng giảm
  document.body.addEventListener("click", function (event) {
    const button = event.target.closest("button");
    if (!button) return;

    const quantityInput = button.parentElement.querySelector(".quantity-input");

    if (!quantityInput) return; // Nếu không tìm thấy ô input

    let currentValue = parseInt(quantityInput.value) || 1;

    if (button.classList.contains("add-item")) {
      // Tăng số lượng
      quantityInput.value = currentValue + 1;
    } else if (button.classList.contains("minus-item")) {
      // Giảm số lượng, nhưng không nhỏ hơn giá trị min
      const minValue = parseInt(quantityInput.getAttribute("min")) || 1;
      quantityInput.value = Math.max(currentValue - 1, minValue);
    }
  });
});

// =============================================================================
//                   Hiển thị form nhập thông tin giao hàng
// =============================================================================
