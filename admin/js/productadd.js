function addMeasure() {
  const container = document.getElementById("measure-container");
  const newRow = document.createElement("div");
  newRow.classList.add("measure-row");
  newRow.innerHTML = `
        <input type="text" name="measureName[]" placeholder="Tên thông số" class="input-field measure-name">
        <input type="text" name="measureValue[]" placeholder="Giá trị thông số" class="input-field measure-value">
        <button type="button" onclick="removeMeasure(this)">Xóa</button>
    `;
  container.appendChild(newRow);
}

function removeMeasure(button) {
  button.parentElement.remove();
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
