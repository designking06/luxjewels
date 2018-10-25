<?php include_once('../includes/displayfunctions.php');?>
<!DOCTYPE html>
<?php getHead();?>
<style>
body, html {
    height: 100%;
    color: #777;
    line-height: 1.8;
}

/* Create a Parallax Effect */
.bgimg-1, .bgimg-2, .bgimg-3 {
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

/* First image (Logo. Full height) */
.bgimg-1 {
    background-image: url('images/luxejewel.jpg');
    min-height: 90%;
    background-position: bottom;
}

/* Second image (Portfolio) */
.bgimg-2 {
    background-image: url("images/luxejewel.jpg");
    min-height: 400px;
        background-position:bottom;
}

/* Third image (Contact) */
.bgimg-3 {
    background-image: url("images/luxejewel.jpg");
    min-height: 400px;
    background-position:bottom;
}

.w3-wide {letter-spacing: 10px;}
.w3-hover-opacity {cursor: pointer;}

/* Turn off parallax scrolling for tablets and phones */
@media only screen and (max-device-width: 1024px) {
    .bgimg-1, .bgimg-2, .bgimg-3 {
        background-attachment: scroll;
    }
}
#color{
  color:#cca722;
}
</style>
<body>
<?php getNav();?>

<!-- First Parallax Image with Logo Text -->
<div class="bgimg-1 w3-display-container" id="home">
  <div class="w3-display-middle" style="white-space:nowrap;">
    <div class="w3-black w3-padding">
      <span class="w3-center w3-padding-large w3-xlarge w3-wide w3-animate-opacity w3-xxlarge w3-hide-small" style="color:#bf0600;">LUX JEWELS</span>
      <span id="color" class="w3-center w3-padding-large w3-xlarge w3-wide w3-xxlarge w3-hide-large" style="color:#cca722;">LUX JEWELS</span>
    </div>
  </div>
</div>

<!-- Container (About Section) -->
<div class="w3-content w3-container w3-padding-64" id="about">
  <p class=""><?php getCompInfo(7,'');?></p>
  <div class="w3-row">
    <!--div class="w3-col m w3-center w3-padding-large">
      <img src="images/luxejewel.jpg" class="w3-round w3-image w3-opacity w3-hover-opacity-off" alt="Photo of Me" width="500" height="333">
    </div-->
  </div>
</div>

<div class="w3-row w3-center w3-padding-16" style="background-color:black;color:#c2a23a">
  <div class="w3-third w3-section">
    <span class="w3-xlarge">Bracelets</span>
  </div>
  <div class="w3-third w3-section">
    <span class="w3-xlarge">Charms</span>
  </div>
  <div class="w3-third w3-section">
    <span class="w3-xlarge">Necklaces</span>
  </div>
</div>

<!-- Second Parallax Image with Portfolio Text -->
<div class="bgimg-2 w3-display-container">
  <div class="w3-display-middle">
    <a href="viewproducts.php"><div class="w3-black w3-padding"><span class="w3-xxxlarge w3-wide" style="color:#c2a23a;">SHOP</span></div></a>
  </div>
</div>

<!-- Container (Portfolio Section) -->
<div class="w3-content w3-container w3-padding-64" id="portfolio">
  <h1 class="w3-center display-4" style="color:#bf0600;">Newest Products</h1>
  <p class="w3-center lead w3-text-black w3-small">Click on the images to make them bigger</em></p><br>

  <!-- Responsive Grid. Four columns on tablets, laptops and desktops. Will stack on mobile devices/small screens (100% width) -->
  <div id="products">
    <div class="row w3-padding"><div class="col-sm-12"><h2>Shop</h2><a href="viewproducts.php"><p>shop all</p></a></div></div>
    <!-- list products-->
    <?php displayProducts(7);?>
  </div>
</div>

<!-- Modal for full size images on click-->
<div id="modal01" class="w3-modal w3--light-grey" onclick="this.style.display='none'">
  <div class="w3-modal-content w3-animate-zoom w3-center w3-padding-64">
    <span class="w3-button w3-large w3-black w3-display-topright" title="Close Modal Image"><i class="fa fa-remove"></i></span>
    <img id="img01" class="w3-image">
    <p id="caption" class="w3-opacity w3-large"></p>
    <form action="stripe.process.php" method="POST">
      <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="pk_test_qUgFXuTWbRNMy9wX7V8qIitR"
        data-amount="999"
        data-name="Crawley Creative "
        data-description="Example charge"
        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
        data-locale="auto">
      </script>
    </form>
  </div>
</div>

<!-- Third Parallax Image with Portfolio Text -->
<div class="bgimg-3 w3-display-container w3-opacity-min">
  <div class="w3-display-middle">
     <span class="w3-xxlarge w3-text-white w3-wide">CONTACT</span>
  </div>
</div>

<!-- Container (Contact Section) -->
<div class="w3-content w3-container w3-padding-64" id="contact">
  <h3 class="w3-center">OUR LOCATION</h3>
  <div class="w3-row w3-padding-32 w3-section">
    <div class="w3-col m4 w3-container">
      <!-- Add Google Maps -->
      <div id="googleMap" class="w3-round-large w3-greyscale" style="width:100%;height:400px;"></div>
    </div>
    <div class="w3-col m8 w3-panel">
      <div class="w3-large w3-margin-bottom">
        <i class="fa fa-map-marker fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i>Greensboro, NC<br>
        <i class="fa fa-phone fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Phone: +00 151515<br>
        <i class="fa fa-envelope fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Email: mail@mail.com<br>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="w3-center w3-black w3-padding-64 w3-opacity w3-hover-opacity-off">
  <a href="#home" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>Back to top</a>
  <div class="w3-xlarge w3-section">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
  </div>
  <p>A <a href="" title="" target="_blank" class="w3-hover-text-green">Crawley Creative Agency</a> Project</p>
</footer>

<!-- Add Google Maps -->
<script>
function myMap()
{
  myCenter=new google.maps.LatLng(41.878114, -87.629798);
  var mapOptions= {
    center:myCenter,
    zoom:12, scrollwheel: false, draggable: false,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("googleMap"),mapOptions);

  var marker = new google.maps.Marker({
    position: myCenter,
  });
  marker.setMap(map);
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
  var price = document.getElementById("price");
  price.innerHTML = element.alt2;
}

// Change style of navbar on scroll
window.onscroll = function() {myFunction()};
function myFunction() {
    var navbar = document.getElementById("myNavbar");
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        navbar.className = "w3-bar" + " w3-card" + " w3-animate-top" + " w3-black";
    } else {
        navbar.className = navbar.className.replace(" w3-card w3-animate-top w3-white");

    }
}

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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script>
<!--
To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->

</body>
</html>
<?php
?>
