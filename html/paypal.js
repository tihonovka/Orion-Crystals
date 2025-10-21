// Egyedul ezt a szart le nem irnam, ty Copilot Love you, ennek a 60% copilot, mivel halvany gözöm se volt a javascriptrol



document.addEventListener('DOMContentLoaded', function() {  
  // ekindul a script miurótan a weboldal teljesen betoltodott ahh
  var paymentBtns = document.querySelectorAll('.payment-btn');
  var paymentModeInput = document.getElementById('payment_mode');
  var creditCardFields = document.getElementById('credit-card-fields');
  var paypalContainer = document.getElementById('paypal-button-container');
  var saveBtn = document.querySelector('button[type="submit"]');
  // lekerjuk a pypaltol az osszes szart ami kell neki fizetesi gombok, inputok, mezok.

  function getCartTotal() {
    // ez a fos kiszamolja a kosar vegosszeget, like mennyire vasarolt...
    var cart = JSON.parse(localStorage.getItem('checkoutCart') || '[]');
    return cart.reduce(function(sum, item) {
      return sum + (item.price * item.qty);
    }, 0);
  }

  paymentBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      // itt ha rakatttintunk vmire akkor azt valasztjuk ki es azt tesszuk akitivva 
      paymentBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      paymentModeInput.value = btn.getAttribute('data-mode');
      // attol fug h paypal vagy bank kartya az jelenik meg
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

              // Collect cart details
              const cart = JSON.parse(localStorage.getItem('checkoutCart') || '[]');

              // Prepare email data
              const emailData = {
                recipient: "tihike@orioncrystals.nhely.hu",
                subject: "Purchase Confirmation",
                body: cart.map(item => `
                  Product: ${item.name}
                  Image: ${item.img}
                  Size: ${item.size || 'N/A'}
                  Quantity: ${item.qty}
                  Price: ${item.price} HUF
                `).join('\n\n')
              };

              // Send email via backend
              fetch('send_email.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(emailData)
              }).then(response => {
                if (response.ok) {
                  console.log('Email sent successfully.');
                } else {
                  console.error('Failed to send email.');
                }
              }).catch(error => console.error('Error:', error));
            });
          }
        }).render('#paypal-button-container');
        window.paypalButtonRendered = true;
      }
    });
  });

  if (saveBtn) {
    saveBtn.addEventListener('click', function() {
      // ha megynomjuk a mentes gombot akkor törlodik az aktiv állapot.
      paymentBtns.forEach(b => b.classList.remove('active'));
    });
  }
});
