// Login form validation for checkboxes
// Register form validation for checkboxes
document.addEventListener('DOMContentLoaded', function() {
  var registerForm = document.querySelector('form[action="register.php"]');
  if (registerForm) {
    var checkboxes = registerForm.querySelectorAll('input[type="checkbox"]');
    var registerBtn = registerForm.querySelector('button[type="submit"]');
    var errorMsg = document.createElement('div');
    errorMsg.style.color = '#B68D40';
    errorMsg.style.fontWeight = 'bold';
    errorMsg.style.margin = '12px 0';
    errorMsg.style.textAlign = 'center';
    errorMsg.style.display = 'none';
    errorMsg.textContent = 'Accept the ÁSZF and Adatkezelési Tájékoztató to register.';
    registerBtn.parentNode.insertBefore(errorMsg, registerBtn);

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
    var checkboxes = loginForm.querySelectorAll('input[type="checkbox"]');
    var loginBtn = loginForm.querySelector('button[type="submit"]');
    var errorMsg = document.createElement('div');
    errorMsg.style.color = '#B68D40';
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
  var dropdown = icon.closest('.dropdown');
  var menuIcon = icon;
  dropdown.classList.toggle('show');
  menuIcon.classList.toggle('active');
}
// Close the dropdown if clicked outside
window.onclick = function(event) {
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