// UTÁLOM A JAVASCRIPTET, nem amugy szeretem :3


function increaseQty() {
  // increase fuggv, noveli a darabszamot a pruduct barmelyik 1-12 lapon.
  var qty = document.getElementById('qty-value');
  qty.textContent = parseInt(qty.textContent) + 1;
}

function decreaseQty() {
  // ellentéte, csokkeni
  var qty = document.getElementById('qty-value');
  if (parseInt(qty.textContent) > 1) qty.textContent = parseInt(qty.textContent) - 1;
}

function addToCheckoutUniversal() {
  // ez a cucc adja hozza a kosrhoz a dolgokat, aztan betolti a az árukat, képeet, méretet, meg a rakom se tudja mit
  var name = document.querySelector('[class^="product-detail-title"]')?.textContent || 'Product';
  var priceText = document.querySelector('.product-detail-price')?.textContent || '0  HUF';
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

function addToCheckout() {
  // nagyjabol ugyanaz ami fejjeb volt
  var name = document.querySelector('.product-detail-title1, .product-detail-title2, .product-detail-title3, .product-detail-title4, .product-detail-title5, .product-detail-title6, .product-detail-title7, .product-detail-title8, .product-detail-title9, .product-detail-title10, .product-detail-title11, .product-detail-title12')?.textContent || 'Bracelet';
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
  // na gyerekek, itt van a cucc amikor megjelenik a pop up kis ablak hogy fojtasd a vasarlast vagy megsem
  document.getElementById('cart-popup').style.display = 'flex';
}

// eza a kiugrok az ablakon logikaja
document.addEventListener('DOMContentLoaded', function() {
  // vagy eltunik a gomb, vagy checkout.html re vissz a hajo
  document.getElementById('stay-shopping-btn').onclick = function() {
    document.getElementById('cart-popup').style.display = 'none';
  };
  document.getElementById('go-checkout-btn').onclick = function() {
    window.location.href = 'checkout.html';
  };
});
