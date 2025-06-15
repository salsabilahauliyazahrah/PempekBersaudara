/*=============== CART NOTIFICATION ===============*/
function showNotification(title, message, type = 'success') {
  // Create notification element
  const notification = document.createElement('div');
  notification.classList.add('notification');
  
  // Add notification content
  notification.innerHTML = `
    <i class="ri-shopping-bag-line notification__icon"></i>
    <div class="notification__content">
      <h3 class="notification__title">${title}</h3>
      <p class="notification__message">${message}</p>
    </div>
  `;
  
  // Add notification to document
  document.body.appendChild(notification);
  
  // Show notification
  setTimeout(() => notification.classList.add('show'), 100);
  
  // Remove notification after 3 seconds
  setTimeout(() => {
    notification.classList.remove('show');
    setTimeout(() => notification.remove(), 300);
  }, 3000);
}

/*=============== CART FUNCTIONS ===============*/
function addToCart(itemName, price) {
  // Here you would typically add the item to cart storage (session/localStorage)
  showNotification(
    'Ditambahkan ke Keranjang',
    `${itemName} telah ditambahkan ke keranjang belanja.`
  );

  // Konversi price ke angka kalau masih string (contoh: "Rp12.000")
  let numericPrice = price;
  if (typeof price === 'string') {
    numericPrice = parseInt(price.replace(/[^0-9]/g, '')); // Hapus Rp dan titik
  }

  
  // You can implement cart storage here
  const cartItem = {
    name: itemName,
    price: price,
    quantity: 1
  };
  
  // For now, store in localStorage
  let cart = JSON.parse(localStorage.getItem('cart') || '[]');
  
  // Check if item already exists
  const existingItemIndex = cart.findIndex(item => item.name === itemName);
  if (existingItemIndex > -1) {
    cart[existingItemIndex].quantity += 1;
  } else {
    cart.push(cartItem);
  }
  
  localStorage.setItem('cart', JSON.stringify(cart));
}

/*=============== CART LOADING ===============*/
function formatPrice(price) {
  // Remove 'Rp' and any dots, then parse as number
  return parseInt(price.replace('Rp', '').replace('.', ''));
}

function formatToRupiah(number) {
  return 'Rp' + number.toLocaleString('id-ID');
}

function loadCartItems() {
  const cartItems = JSON.parse(localStorage.getItem('cart') || '[]');
  const cartContainer = document.querySelector('.cart__items');
  
  if (!cartContainer) return;
  
  // Clear existing items
  cartContainer.innerHTML = '';
  
  if (cartItems.length === 0) {
    cartContainer.innerHTML = `
      <div class="text-center p-4">
        <p>Keranjang belanja Anda masih kosong.</p>
        <a href="../views-pelanggan/menu.php" class="button mt-3">
          <i class="ri-shopping-bag-line"></i> Belanja Sekarang
        </a>
      </div>
    `;
    return;
  }
  
  // Add each item to cart
  cartItems.forEach(item => {
    const itemElement = document.createElement('div');
    itemElement.classList.add('cart__item');
    itemElement.innerHTML = `
      <img src="../foto-foto/img/${item.name.toLowerCase().replace(/\s+/g, '')}.png" alt="${item.name}" class="cart__item-img">
      <div class="cart__item-content">
        <h3 class="cart__item-title">${item.name}</h3>
        <p class="cart__item-price">${formatToRupiah(item.price)}</p>
        <div class="cart__item-quantity">
          <button class="quantity-btn minus" onclick="updateQuantity('${item.name}', -1)">
            <i class="ri-subtract-line"></i>
          </button>
          <input type="number" value="${item.quantity}" min="1" class="quantity-input" onchange="updateQuantity('${item.name}', this.value, true)">
          <button class="quantity-btn plus" onclick="updateQuantity('${item.name}', 1)">
            <i class="ri-add-line"></i>
          </button>
        </div>
      </div>
      <button class="cart__item-remove" onclick="removeFromCart('${item.name}')">
        <i class="ri-delete-bin-line"></i>
      </button>
    `;
    cartContainer.appendChild(itemElement);
  });
  
  updateCartTotal();
}

function updateQuantity(itemName, change, absolute = false) {
  const cart = JSON.parse(localStorage.getItem('cart') || '[]');
  const itemIndex = cart.findIndex(item => item.name === itemName);
  
  if (itemIndex > -1) {
    if (absolute) {
      cart[itemIndex].quantity = parseInt(change);
    } else {
      cart[itemIndex].quantity = Math.max(1, cart[itemIndex].quantity + parseInt(change));
    }
    
    if (cart[itemIndex].quantity < 1) {
      cart.splice(itemIndex, 1);
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCartItems();
  }
}

function removeFromCart(itemName) {
  const cart = JSON.parse(localStorage.getItem('cart') || '[]');
  const itemIndex = cart.findIndex(item => item.name === itemName);
  
  if (itemIndex > -1) {
    cart.splice(itemIndex, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCartItems();
    showNotification('Item Dihapus', `${itemName} telah dihapus dari keranjang.`);
  }
}

function updateCartTotal() {
  const cart = JSON.parse(localStorage.getItem('cart') || '[]');
  const subtotal = cart.reduce((total, item) => {
    return total + (formatPrice(item.price) * item.quantity);
  }, 0);
  
  const shipping = document.getElementById('distance') ? 
    parseInt(document.getElementById('distance').value) * 2000 : 0;
  
  const total = subtotal + shipping;
  
  // Update summary if it exists
  const summaryDetails = document.querySelector('.summary__details');
  if (summaryDetails) {
    summaryDetails.innerHTML = `
      <div class="summary__item">
        <span>Total Harga</span>
        <span>${formatToRupiah(subtotal)}</span>
      </div>
      <div class="summary__item">
        <span>Biaya Pengiriman</span>
        <span>${formatToRupiah(shipping)}</span>
      </div>
      <div class="summary__total">
        <span>Total Pembayaran</span>
        <span>${formatToRupiah(total)}</span>
      </div>
    `;
  }
}

function checkout() {
  if (isSubmitting) return; // Cegah pengiriman ganda
  isSubmitting = true;
    
  const cart = JSON.parse(localStorage.getItem('cart') || '[]');
  if (cart.length === 0) {
    showNotification('Error', 'Keranjang belanja Anda masih kosong.', 'error');
    return;
  }

  const namaPenerima = document.querySelector('input[placeholder="Masukkan nama penerima"]').value;
  const alamat = document.querySelector('textarea[placeholder="Masukkan alamat lengkap"]').value;
  const distance = document.getElementById('distance').value;
  const paymentMethod = document.querySelector('input[name="payment"]:checked').value;

  if (!namaPenerima || !alamat) {
    showNotification('Error', 'Mohon lengkapi informasi pengiriman.', 'error');
    return;
  }

  const subtotal = cart.reduce((total, item) => {
    return total + (formatPrice(item.price) * item.quantity);
  }, 0);
  const shipping = parseInt(distance) * 2000;
  const totalAmount = subtotal + shipping;

  // Send to server
  fetch('../proses-pelanggan/process_payment.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: new URLSearchParams({
      payment_method: paymentMethod,
      total_amount: totalAmount,
      nama_penerima: namaPenerima,
      alamat: alamat,
      distance: distance,
      items: JSON.stringify(cart)
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      // Show success popup
      const popup = document.createElement('div');
      popup.classList.add('notification', 'notification--success');
      popup.innerHTML = `
        <div class="notification__content">
          <h3 class="notification__title">Pembayaran Berhasil</h3>
          <p class="notification__message">Tunggu pesanan anda</p>
        </div>
      `;
      document.body.appendChild(popup);
      
      // Clear cart
      localStorage.removeItem('cart');
      
      // Redirect after 3 seconds
      setTimeout(() => {
        window.location.href = '../views-pelanggan/menu.php';
      }, 2000);
    } else {
      showNotification('Error', data.message, 'error');
    }
  })
  .catch(error => {
    showNotification('Error', 'Terjadi kesalahan saat memproses pembayaran.', 'error');
  });
}
