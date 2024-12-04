// Tạo biến local
let cart = JSON.parse(localStorage.getItem("cart")) || {};

// Function để add từ card vào cart
function addToCart(button) {
  // Lấy element card
  const card = button.closest(".card");

  // Lấy card-name
  const productName = card.querySelector(".card-name").textContent.trim();

  // Lấy card-price và loại bỏ ký tự không phải số
  const price = parseFloat(
    card.querySelector(".card-price").textContent.replace(/\D/g, "")
  );

  // Lấy card-img
  const imgSrc = card.querySelector("img").src;

  // Thêm item vào cart
  if (cart[productName]) {
    // Tăng số lượng nếu item đã tồn tại
    cart[productName].quantity += 1;
  } else {
    // Ngược lại thêm item vào
    cart[productName] = { price: price, quantity: 1, imgSrc: imgSrc };
  }

  // Lưu vào local
  saveCart();
}

// Lưu cart vào local
function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
}

function updateQuantity(itemName, change) {
  if (cart[itemName]) {
    cart[itemName].quantity += change;
    if (cart[itemName].quantity <= 0) {
      cart[itemName].quantity = 0;
    }
    saveCart();
    displayCart();
  }
}

function removeItem(button) {
  const itemName = button.getAttribute("data-item");
  if (cart[itemName]) {
    delete cart[itemName];
    saveCart();
    displayCart();
  }
}

function clearCart() {
  cart = {};
  localStorage.removeItem("cart");
  displayCart();
}

// ==================================================================
// Load giỏ hàng
function setupCartEventListeners() {
  const cartContainer = document.querySelector(".wrapper-cart-items");

  // Clear existing event listeners by removing and re-adding the container
  const newCartContainer = cartContainer.cloneNode(true);
  cartContainer.parentNode.replaceChild(newCartContainer, cartContainer);

  // Now attach a single event listener for all buttons within the cart container
  newCartContainer.addEventListener("click", (event) => {
    const button = event.target.closest("button");
    if (!button) return;

    const itemName = button.getAttribute("data-item");
    if (!itemName) return;

    if (button.classList.contains("add-item")) {
      updateQuantity(itemName, 1);
    } else if (button.classList.contains("minus-item")) {
      updateQuantity(itemName, -1);
    } else if (button.classList.contains("reset-this-item")) {
      removeItem(button);
    }
  });
}

// Display cart and initialize event listeners
function displayCart() {
  const cartContainer = document.querySelector(".wrapper-cart-items");
  cartContainer.innerHTML = ""; // Clear previous items

  let total = 0;
  const cartEntries = Object.entries(cart);
  const totalItems = cartEntries.length;

  let counter = 0;
  for (const [item, details] of cartEntries) {
    const itemTotal = details.price * details.quantity;
    total += itemTotal;

    // Create cart item element
    let cartItem = document.createElement("div");
    cartItem.classList.add("cart-item-info-button");

    cartItem.innerHTML = `
      <div class="cart-item-info">
        <div class="cart-item-name-image">
          <div class="cart-item-image">
            <img src="${details.imgSrc}" alt="Hình ảnh sản phẩm" />
          </div>
          <span class="cart-item-name">${item}</span>
        </div>
        <div class="cart-item-price">${details.price.toLocaleString()}đ</div>
      </div>
      
      <div class="cart-button">
        <button class="reset-this-item" data-item="${item}">Xóa</button>
        <button class="minus-item" data-item="${item}">
          <img src="../img/minus.png" alt="-" />
        </button>
        <input
          type="text"
          class="quantity-input"
          value="${details.quantity}"
          readonly
        />
        <button class="add-item" data-item="${item}">
          <img src="../img/plus.png" alt="+" />
        </button>
      </div>
      `;

    cartContainer.appendChild(cartItem);

    // Only add <hr> if this is not the last item
    if (counter < totalItems - 1) {
      let hr = document.createElement("hr");
      cartContainer.appendChild(hr); // Append <hr> directly to the container
    }

    counter++;
  }

  // Attach event listeners to cart buttons only once
  setupCartEventListeners();
}
