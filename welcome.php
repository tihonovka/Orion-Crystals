<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <script src="script.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AbaHRAQD86hw2hl2vl115JUdpsS3j41Kb5_JILGYmTCu_dBj21fOJuggMNFBTwsvmd0JtWujXs3X4pJ_&currency=HUF"></script>
    <script src="paypal.js"></script>
    <link rel="icon" type="image/png" sizes="14x22" href="Screenshot 2025-08-12 142558.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+AU+QLD:wght@100..400&display=swap" rel="stylesheet">
    <title>Orion Crystals</title>
</head>
<body>
    <div class="header" style="display: flex; align-items: center; justify-content: center; gap: 24px; position: relative;">
      <div class="dropdown" style="position: absolute; left: 0;"></div>
      <h1 class="header-text" style="margin: 0;">Orion Crystals</h1>
      <div class="login-mini-banner" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%);"></div>
    </div>

    <div class="user-page" style="max-width: 700px; margin: 48px auto 0 auto; background: #fff; border-radius: 24px; box-shadow: 0 4px 24px rgba(0,0,0,0.12); padding: 40px; font-family: 'Playwrite AU QLD', cursive; position: relative; z-index: 1;">
        <form method="post" action="save_profile.php">
            <div style="margin-bottom: 32px;">
                <h3 style="font-size: 1.3em; color: #333; margin-bottom: 12px;">Payment Mode</h3>
                <div id="payment-mode-row" style="display: flex; gap: 10px; margin-bottom: 10px;">
                  <button type="button" class="payment-btn credit-btn" data-mode="Credit Card">
                    💳 Credit Card
                  </button>
                  <button type="button" class="payment-btn paypal-btn" data-mode="PayPal">
                    <img src="https://www.paypalobjects.com/webstatic/icon/pp258.png" alt="PayPal" style="height: 18px; vertical-align: middle; margin-right: 6px;">
                    Paypal
                  </button>
                </div>
                <input type="hidden" name="payment_mode" id="payment_mode" value="Credit Card">
                <div id="credit-card-fields" style="margin-top: 10px;">
                    <input type="text" name="card_number" placeholder="Card Number" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; font-size: 1em; margin-bottom: 10px;" maxlength="19" />
                    <input type="text" name="card_name" placeholder="Name on Card" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; font-size: 1em; margin-bottom: 10px;" />
                    <div style="display: flex; gap: 10px;">
                        <input type="text" name="card_expiry" placeholder="MM/YY" style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid #ccc; font-size: 1em; margin-bottom: 10px;" maxlength="5" />
                        <input type="text" name="card_cvc2" placeholder="CVC2" style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid #ccc; font-size: 1em; margin-bottom: 10px;" maxlength="4" />
                    </div>
                </div>
                <div id="paypal-button-container" style="display:none; margin-top:10px;"></div>
            </div>
            <div style="margin-bottom: 32px;">
                <h3 style="font-size: 1.3em; color: #333; margin-bottom: 12px;">Delivery Details</h3>
                <input type="text" name="full_name" placeholder="Full Name" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; font-size: 1em; margin-bottom: 10px;" />
                <input type="text" name="address" placeholder="Address" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; font-size: 1em; margin-bottom: 10px;" />
                <input type="text" name="phone" placeholder="Phone Number" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; font-size: 1em; margin-bottom: 10px;" />
                <input type="email" name="email" placeholder="Email" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; font-size: 1em; margin-bottom: 10px;" />
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 32px;">
                <a href="logout.php" style="background: #B68D40; color: #fff; font-weight: bold; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-size: 1em;">Logout</a>
                <button type="submit" style="background: #045bdd; color: #fff; font-weight: bold; padding: 12px 32px; border-radius: 8px; font-size: 1em; border: none; cursor: pointer;">Save Changes</button>
            </div>
        </form>
    <!-- JS logic handled in paypal.js -->
    </div>
    <script>
document.querySelectorAll('.payment-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('.payment-btn').forEach(function(b) {
            b.classList.remove('active');
        });
        btn.classList.add('active');
        document.getElementById('payment_mode').value = btn.getAttribute('data-mode');
        document.getElementById('credit-card-fields').style.display = btn.getAttribute('data-mode') === 'Credit Card' ? 'block' : 'none';
        if (document.getElementById('paypal-button-container')) {
            document.getElementById('paypal-button-container').style.display = btn.getAttribute('data-mode') === 'PayPal' ? 'block' : 'none';
        }
    });
});
</script>
</body>
</html>