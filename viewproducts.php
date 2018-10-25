<?php include_once('includes/require.php'); ?>
<style>
  body, html {
      height: 100%;
      color: #777;
      line-height: 1.8;
  }
  .w3-wide {letter-spacing: 10px;}
  .w3-hover-opacity {cursor: pointer;}
  #color{
    color:#cca722;
  }
</style>
<div class="w3-container w3-animate-opacity w3-black container-fluid">
  <!-- Container (Portfolio Section) -->
  <div class="container w3-white">
  <div class="w3-content w3-container w3-padding-64" id="portfolio">
    <a href="index.php" style="text-decoration:none;"><?php getCompInfo(7,'c2a23a');?></a>
    <p class="w3-center lead w3-text-black w3-small">Click on the images to make them bigger</p><br>
    <div class="w3-row w3-center w3-padding-16" style="background-color:#bf0600;color:white">
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
    <hr>
          <?php displayProductLineAndProduct(6);?>
          <hr class="w3-clear">
    <!-- Responsive Grid. Four columns on tablets, laptops and desktops. Will stack on mobile devices/small screens (100% width) -->
    <div id="productsAll">
      <div class="row w3-margin-top"><div class="col-sm-12"><h2 style="color:#bf0600"></h2></div></div>
      <!-- list products-->
        <?php displayProducts(6);?>
    </div>

  <!-- Modal for full size images on click-->
  <div id="modal01" class="w3-modal w3--light-grey" onclick="this.style.display='none'">
    <div class="w3-modal-content w3-animate-zoom w3-center w3-padding-64">
      <span class="w3-button w3-large w3-black w3-display-topright" title="Close Modal Image"><i class="fa fa-remove"></i></span>
      <img id="img01" class="w3-image">
      <p id="caption" class="w3-opacity w3-large"></p>
      yo
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
</div>
</div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script>
<!--
To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->

</body>
</html>
