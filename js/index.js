// =============================================================================
//                      Chỉnh chiều cao footer cho đẹp
// =============================================================================
function adjustWrapperMinHeight() {
  const navHeight = document.querySelector("nav").offsetHeight; // Chiều cao của <nav>
  const footerHeight = document.querySelector("footer").offsetHeight; // Chiều cao của <footer>
  const categoryHeight = document.querySelector(".category").offsetHeight; // Chiều cao của <category>
  const viewportHeight = window.innerHeight; // Chiều cao của viewport (100vh)

  // Tính chiều cao min-height của .wrapper
  const wrapperMinHeight =
    viewportHeight - navHeight - footerHeight - categoryHeight;

  // Áp dụng min-height cho .wrapper
  document.querySelector(".wrapper").style.minHeight = wrapperMinHeight + "px";
}

// Gọi hàm khi tải trang và khi thay đổi kích thước cửa sổ
adjustWrapperMinHeight();
window.addEventListener("resize", adjustWrapperMinHeight);

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
        url: "ajax/ajax_get_district.php",
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
        url: "ajax/ajax_get_wards.php",
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

// =============================================================================
//                        Ajax thanh tiềm kiếm
// =============================================================================
function suggestProducts(query) {
  if (query.length == 0) {
    document.getElementById("suggestions").innerHTML = "";
    return;
  }
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var suggestions = JSON.parse(this.responseText);
      var suggestionsHTML = "";
      for (var i = 0; i < suggestions.length; i++) {
        suggestionsHTML +=
          "<p style='padding: 1rem;'><a href='details.php?proid=" +
          suggestions[i].productId +
          "'>" +
          suggestions[i].productName +
          "</a></p>";
      }
      document.getElementById("suggestions").innerHTML = suggestionsHTML;
    }
  };
  xhr.open("GET", "suggest.php?q=" + query, true);
  xhr.send();
}


