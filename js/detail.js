// =============================================================================
//                      NÚT TĂNG GIẢM SỐ LƯỢNG DETAILS
// =============================================================================
document
  .getElementById("increment-button")
  .addEventListener("click", function () {
    let input = document.getElementById("quantity-input");
    input.value = parseInt(input.value) + 1;
  });

document
  .getElementById("decrement-button")
  .addEventListener("click", function () {
    let input = document.getElementById("quantity-input");
    if (input.value > 1) {
      input.value = parseInt(input.value) - 1;
    }
  });
