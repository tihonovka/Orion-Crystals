// lezarja a sessiot, ez a szar a welcome.php-van lowkey ja 
<?php
session_start();
session_destroy();
header("Location: index.html");
exit;
?>
