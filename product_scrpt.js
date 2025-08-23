function increaseQty() {
  var qty = document.getElementById('qty-value');
  qty.textContent = parseInt(qty.textContent) + 1;
}
function decreaseQty() {
  var qty = document.getElementById('qty-value');
  if (parseInt(qty.textContent) > 1) qty.textContent = parseInt(qty.textContent) - 1;
}
function addToCheckoutUniversal() {
  var name = document.querySelector('[class^="product-detail-title"]')?.textContent || 'Product';
  var priceText = document.querySelector('.product-detail-price')?.textContent || '0 HUF';
  var price = parseInt(priceText.replace(/[^\d]/g, ''));
  var img = document.querySelector('.product-detail-img')?.getAttribute('src') || '';
  var qty = parseInt(document.getElementById('qty-value')?.textContent) || 1;
  var cart = JSON.parse(localStorage.getItem('checkoutCart') || '[]');
  var idx = cart.findIndex(item => item.name === name);
  if (idx >= 0) {
    cart[idx].qty += qty;
  } else {
    cart.push({ name, price, img, qty });
  }
  localStorage.setItem('checkoutCart', JSON.stringify(cart));
  window.location.href = 'checkout.html';
}