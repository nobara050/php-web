// Dropdown level menu sibar
document.addEventListener("DOMContentLoaded", () => {
  // Chọn tất cả các phần tử menu-item
  const menuItems = document.querySelectorAll(".menuitem");

  menuItems.forEach((menuItem) => {
    // Tìm phần tử <ul> con (sub-menu)
    const subMenu = menuItem.nextElementSibling;

    menuItem.addEventListener("click", (event) => {
      event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

      // Đảm bảo ẩn các sub-menu khác khi click vào một menu-item
      document.querySelectorAll(".submenu").forEach((item) => {
        if (item !== subMenu) {
          item.style.display = "none"; // Ẩn tất cả các sub-menu không phải là mục đã click
        }
      });

      // Chuyển trạng thái hiển thị của sub-menu
      subMenu.style.display =
        subMenu.style.display === "block" ? "none" : "block";
    });
  });
});

// Dialog confirm
document.addEventListener("DOMContentLoaded", () => {
  const dialog = document.getElementById("confirm-dialog");
  const dialogMessage = document.getElementById("confirm-message");
  const confirmYes = document.getElementById("confirm-yes");
  const confirmNo = document.getElementById("confirm-no");

  let targetHref = ""; // Lưu URL của liên kết được nhấn

  // Xử lý sự kiện click cho các liên kết có lớp "confirmable"
  document.querySelectorAll(".confirmable").forEach((link) => {
    link.addEventListener("click", (event) => {
      event.preventDefault(); // Ngăn chặn điều hướng mặc định

      // Lấy URL và thông báo từ liên kết
      targetHref = link.href;
      const message =
        link.dataset.message ||
        "Bạn có chắc chắn muốn thực hiện hành động này?";

      // Hiển thị hộp thoại và cập nhật nội dung
      dialogMessage.textContent = message;
      dialog.classList.remove("hidden");
    });
  });

  // Xử lý khi người dùng xác nhận
  confirmYes.addEventListener("click", () => {
    dialog.classList.add("hidden"); // Ẩn hộp thoại
    window.location.href = targetHref; // Chuyển hướng
  });

  // Xử lý khi người dùng hủy
  confirmNo.addEventListener("click", () => {
    dialog.classList.add("hidden"); // Ẩn hộp thoại
  });
});
