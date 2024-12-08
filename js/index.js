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
