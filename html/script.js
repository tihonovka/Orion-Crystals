// Regisztrációs űrlap checkbox validáció
// Login form validation for checkboxes(aszf, adatkezelési tájékoztató)
// Register form validacio, checkbox(OLVASS FEJJEB, lusta vagyok)
document.addEventListener('DOMContentLoaded', function() {
  var registerForm = document.querySelector('form[action="register.php"]');
  if (registerForm) {
    // osszeszedi a checkboxokat, es a gombot és ha baj van akkor hibauzentet add ki
    var checkboxes = registerForm.querySelectorAll('input[type="checkbox"]');
    var registerBtn = registerForm.querySelector('button[type="submit"]');
    var errorMsg = document.createElement('div');
    errorMsg.style.color = '#ff0000ff';
    errorMsg.style.fontWeight = 'bold';
    errorMsg.style.margin = '12px 0';
    errorMsg.style.textAlign = 'center';
    errorMsg.style.display = 'none';
    errorMsg.textContent = 'Accept the ÁSZF and Adatkezelési Tájékoztató to register.';
    registerBtn.parentNode.insertBefore(errorMsg, registerBtn);

    // ez a szar mint a busz ellenor, ha nincsenek bejelolve a checkboxok akkor durvan megbasz
    registerForm.addEventListener('submit', function(e) {
      if (![...checkboxes].every(cb => cb.checked)) {
        e.preventDefault();
        errorMsg.style.display = 'block';
      } else {
        errorMsg.style.display = 'none';
      }
    });
  }
});

document.addEventListener('DOMContentLoaded', function() {
  var loginForm = document.querySelector('form[action="login.php"]');
  if (loginForm) {
    // ugyanaz a logika a checkboxok a bejelentkezéshez
    var checkboxes = loginForm.querySelectorAll('input[type="checkbox"]');
    var loginBtn = loginForm.querySelector('button[type="submit"]');
    var errorMsg = document.createElement('div');
    errorMsg.style.color = '#ff0000ff';
    errorMsg.style.fontWeight = 'bold';
    errorMsg.style.margin = '12px 0';
    errorMsg.style.textAlign = 'center';
    errorMsg.style.display = 'none';
    errorMsg.textContent = 'Accept the ÁSZF and Adatkezelési Tájékoztató to login.';
    loginBtn.parentNode.insertBefore(errorMsg, loginBtn);

    loginForm.addEventListener('submit', function(e) {
      if (![...checkboxes].every(cb => cb.checked)) {
        e.preventDefault();
        errorMsg.style.display = 'block';
      } else {
        errorMsg.style.display = 'none';
      }
    });
  }
});

function toggleDropdown(icon) {
  // a csodalot dropdown menunek a logikaja amit vagy 20 szor atirtam.
  var dropdown = icon.closest('.dropdown');
  var menuIcon = icon;
  dropdown.classList.toggle('show');
  menuIcon.classList.toggle('active');
}

// lezarja a dropdown menut ha mas hova kattintasz, nemtudom hogy mukodik e XD
window.onclick = function(event) {
  // ugyanaz automaikusan lezarja amenut ha valahova kattintasz
  if (!event.target.closest('.menu-icon')) {
    var dropdowns = document.getElementsByClassName('dropdown');
    for (var i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      var menuIcon = openDropdown.querySelector('.menu-icon');
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
        if(menuIcon) menuIcon.classList.remove('active');
      }
    }
  }
}
