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

// =============================================================================
//                      Ajax quận huyện xã tỉnh thành phố
// =============================================================================
$(document).ready(function () {
  // Listen for changes in the "province" select box
  $("#province").on("change", function () {
    var province_id = $(this).val();
    // console.log(province_id);
    if (province_id) {
      // If a province is selected, fetch the districts for that province using AJAX
      $.ajax({
        url: "../ajax/ajax_get_district.php",
        method: "GET",
        dataType: "json",
        data: {
          province_id: province_id,
        },
        success: function (data) {
          // Clear the current options in the "district" select box
          $("#district").empty();

          // Add the new options for the districts for the selected province
          $.each(data, function (i, district) {
            // console.log(district);
            $("#district").append(
              $("<option>", {
                value: district.id,
                text: district.name,
              })
            );
          });
          // Clear the options in the "wards" select box
          $("#wards").empty();
        },
        error: function (xhr, textStatus, errorThrown) {
          console.log("Error: " + errorThrown);
        },
      });
      $("#wards").empty();
    } else {
      // If no province is selected, clear the options in the "district" and "wards" select boxes
      $("#district").empty();
    }
  });

  // Listen for changes in the "district" select box
  $("#district").on("change", function () {
    var district_id = $(this).val();
    // console.log(district_id);
    if (district_id) {
      // If a district is selected, fetch the awards for that district using AJAX
      $.ajax({
        url: "../ajax/ajax_get_wards.php",
        method: "GET",
        dataType: "json",
        data: {
          district_id: district_id,
        },
        success: function (data) {
          // console.log(data);
          // Clear the current options in the "wards" select box
          $("#wards").empty();
          // Add the new options for the awards for the selected district
          $.each(data, function (i, wards) {
            $("#wards").append(
              $("<option>", {
                value: wards.id,
                text: wards.name,
              })
            );
          });
        },
        error: function (xhr, textStatus, errorThrown) {
          console.log("Error: " + errorThrown);
        },
      });
    } else {
      // If no district is selected, clear the options in the "award" select box
      $("#wards").empty();
    }
  });
});
