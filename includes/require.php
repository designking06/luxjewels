<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
include_once($path.'/connect/pdo.php');
include_once($path.'/includes/displayfunctions.php');
getHead();
getNav();
$CompID = 6;
?>
<script src="https://js.stripe.com/v3/"></script>
<script>
// Used to toggle the menu on small screens when clicking on the menu button
function toggleFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>
