// function addMeasure() {
//   const container = document.getElementById("measure-container");
//   const newRow = document.createElement("div");
//   newRow.classList.add("measure-row");
//   newRow.innerHTML = `
//         <input type="text" name="measureName[]" placeholder="Tên thông số" class="input-field measure-name">
//         <input type="text" name="measureValue[]" placeholder="Giá trị thông số" class="input-field measure-value">
//         <button type="button" onclick="removeMeasure(this)">Xóa</button>
//     `;
//   container.appendChild(newRow);
// }

// function removeMeasure(button) {
//   button.parentElement.remove();
// }

function addMeasure() {
  const container = document.getElementById("measure-container");

  // Kiểm tra nếu container trống và không có hàng nào
  const rows = container.querySelectorAll(".measure-row");
  if (rows.length === 0) {
    const newRow = document.createElement("div");
    newRow.classList.add("measure-row");
    newRow.innerHTML = `
            <input type="text" name="measureName[]" placeholder="Tên thông số" class="input-field measure-name">
            <input type="text" name="measureValue[]" placeholder="Giá trị thông số" class="input-field measure-value">
            <button type="button" onclick="removeMeasure(this)">Xóa</button>
        `;
    container.appendChild(newRow);
  } else {
    // Nếu đã có hàng thì thêm hàng mới bình thường
    const newRow = document.createElement("div");
    newRow.classList.add("measure-row");
    newRow.innerHTML = `
            <input type="text" name="measureName[]" placeholder="Tên thông số" class="input-field measure-name">
            <input type="text" name="measureValue[]" placeholder="Giá trị thông số" class="input-field measure-value">
            <button type="button" onclick="removeMeasure(this)">Xóa</button>
        `;
    container.appendChild(newRow);
  }
}

function removeMeasure(button) {
  const container = document.getElementById("measure-container");
  button.parentElement.remove();

  // Kiểm tra nếu container trống hoàn toàn
  const rows = container.querySelectorAll(".measure-row");
  if (rows.length === 0) {
    // Không tạo thêm nếu người dùng đã xóa hết
    return;
  }
}

// Xem trước ảnh
function previewImage(event) {
  const file = event.target.files[0]; // Lấy file đầu tiên từ danh sách files
  const reader = new FileReader();

  reader.onload = function (e) {
    const img = document.getElementById("image-preview");
    img.src = e.target.result; // Gán đường dẫn ảnh cho img
  };

  if (file) {
    reader.readAsDataURL(file); // Đọc ảnh thành URL
  }
}
