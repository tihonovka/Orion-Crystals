document.addEventListener('DOMContentLoaded', function() {
  var paymentBtns = document.querySelectorAll('.payment-btn');
  var paymentModeInput = document.getElementById('payment_mode');
  var creditCardFields = document.getElementById('credit-card-fields');
  var paypalContainer = document.getElementById('paypal-button-container');
  var saveBtn = document.querySelector('button[type="submit"]');

  function getCartTotal() {
    var cart = JSON.parse(localStorage.getItem('checkoutCart') || '[]');
    return cart.reduce(function(sum, item) {
      return sum + (item.price * item.qty);
    }, 0);
  }

  paymentBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      paymentBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      paymentModeInput.value = btn.getAttribute('data-mode');
      creditCardFields.style.display = btn.getAttribute('data-mode') === 'Credit Card' ? 'block' : 'none';
      paypalContainer.style.display = btn.getAttribute('data-mode') === 'PayPal' ? 'block' : 'none';
      if (btn.getAttribute('data-mode') === 'PayPal' && !window.paypalButtonRendered) {
        paypal.Buttons({
          createOrder: function(data, actions) {
            return actions.order.create({
              purchase_units: [{
                amount: {
                  value: getCartTotal().toString(),
                  currency_code: 'HUF'
                }
              }]
            });
          },
          onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
              alert('Payment completed by ' + details.payer.name.given_name);
            });
          }
        }).render('#paypal-button-container');
        window.paypalButtonRendered = true;
      }
    });
  });

  if (saveBtn) {
    saveBtn.addEventListener('click', function() {
      paymentBtns.forEach(b => b.classList.remove('active'));
    });
  }
});
