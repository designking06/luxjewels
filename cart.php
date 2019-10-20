<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include_once($path.'/includes/require.php');
$product_ids = array();
if(isset($_POST['add_to_cart'])){
  //check if shopping cart has been started
  if(isset($_SESSION['shoppingcart'])){
    //track how many items are in shopping cart
    $count = count($_SESSION['shoppingcart']);
    //match up product_ids array keys with values from shopping cart ['id']
    $product_ids = array_column($_SESSION['shoppingcart'],'id');
    echo "<br>";
    //check if the form submitted product id exists in the product_ids array
    if(!in_array($_GET['id'],$product_ids)){
      //product isnt inside array, add product to array
      $_SESSION['shoppingcart'][$count] = array
      (
        'id' => $_GET['id'],
        'name' => $_POST['productname'],
        'price' => $_POST['productprice'],
        'quantity' => $_POST['quantity'],
        'size' => $_POST['BraceletSize']
      );
    }
    else{
      //product is already in cart, increase quantity
      //loop thru product_ids array to find key value with form submitted product id
        for($i = 0; $i < count($product_ids);$i++){
        if($product_ids[$i] == $_GET['id']){
          //once found, use $i to access product in cart and incrase quantity by submitted quantity
          $_SESSION['shoppingcart'][$i]['quantity'] += $_POST['quantity'];
        }
      }
    }
    //print_r($_SESSION['shoppingcart']);
  }
  else{
    //if shopping cart doesnt exist, create it with frist product having an array key of 0
    //create array using submitted form data.
    $_SESSION['shoppingcart'][0] = array
    (
      'id' => $_GET['id'],
      'name' => $_POST['productname'],
      'price' => $_POST['productprice'],
      'quantity' => $_POST['quantity'],
      'size' => $_POST['BraceletSize']
    );
  }
}
if(isset($_GET['action']) && $_GET['action'] == "update"){
  //track how many items are in shopping cart
  $count = count($_SESSION['shoppingcart']);
  //match up product_ids array keys with values from shopping cart ['id']
  $product_ids = array_column($_SESSION['shoppingcart'],'id');
  for($i = 0; $i < count($product_ids);$i++){
  if($product_ids[$i] == $_GET['id']){
    //once found, use $i to access product in cart and incrase quantity by submitted quantity
    $_SESSION['shoppingcart'][$i]['quantity'] = $_POST['updateQuantity'];
  }
}
  header('location:cart.php');
}
if(isset($_GET['action']) && $_GET['action'] == "remove"){
  foreach($_SESSION['shoppingcart'] as $key=>$product){
    if($product['id'] == $_GET['id']){
      //remove product from shopping cart
      unset($_SESSION['shoppingcart'][$key]);
    }
  }
  $product_ids = array_column($_SESSION['shoppingcart'],'id');
  //reset product_ids array keys
  $_SESSSION['shoppingcart'] = array_values($product_ids);
    header('location:cart.php');
}
if(isset($_GET['action']) && $_GET['action'] == "empty"){
  unset($_SESSION['shoppingcart']);
  header('location:cart.php');
}
?>
<body class="container-fluid w3-black">
<div class="container w3-padding-64 w3-white">
  <div id="shopping-cart">
    <?php getCompInfo($pdo,6,'c2a23a');?>
    <div class="w3-white">
      <h2 style="color:#c2a23a;">Your Cart</h2>
        <a id="" href="viewproducts.php"><p>Shop For More</p></a>
    </div>
    <div class="text-center" style="width:100%;">
      <?php
      if(isset($_SESSION['shoppingcart'])){
      ?>
		<div class="w3-content">
		</div>
      <table class="w3-white table table-responsive w3-hoverable w3-text-black" cellpadding="10" cellspacing="1" style="width:100%;margin:auto;">
        <tbody>
          <tr class="w3-text-blue">
            <th scope="col">Name</th>
            <th scope="col">Size<br><span class="w3-small">6,8,10,12</span></th>
            <th scope="col" class="text-right">Price</th>
            <th scope="col" class="text-center">Desired Amount</th>
            <th scope="col" class="text-right">Item Total</th>
          </tr>
        <?php
          $orderDetails = "";
          $i = 1;
          $total = 0;
            foreach ($_SESSION["shoppingcart"] as $product){
            if($product["quantity"] == 0){

            }else{
              $item_total = $product["price"]*$product["quantity"];
        		?>
        		<tr scope="row">
                <td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $product["name"]; ?></strong></td>
                <td style="text-align:left;border-bottom:#F0F0F0 1px solid;">
                    <?php
                    //each bracelet and necklace needs associated sizes
                    ?>
                    <?php echo $product["size"];?>
                </td>
                <td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo "$".number_format($product["price"],2); ?></td>
        <td style="text-align:center;border-bottom:#F0F0F0 1px solid;">
                  <form method="post" action="cart.php?action=update&id=<?php echo $product["id"];?>">
                    <input class="form-control" type="number" name="updateQuantity" size="2" min="00" value="<?php echo $product["quantity"]; ?>" max="99" required>
                    <input type="submit" value="Update">
                  </form>
                </td>
                <td style="text-align:right;">$<?php echo number_format($item_total,2);?></td>
            </tr>
              <?php
              $total = $total + $item_total;
              $orderDetails .= "Item #".$i.": NAME: ".$product["name"]. ":: QTY: ".$product["quantity"].":: Size: ".$product['size']."|";
              $i++;
              }
            }?>
        <tr class="text-right">
        <td></td><td></td><td></td><td colspan="5" align="right"><strong>Subotal:</strong> <?php echo "$".number_format($total,2); ?></td>
        </tr>
        <tr class="text-right">
        <td></td><td></td><td></td><td colspan="5" align="right"><strong>Taxes:</strong>
          <?php
           $tax = $total * 0.075;
           echo "$".number_format($tax,2);
            ?>
        </td>
        </tr>
        <tr class="text-right">
        <td></td><td></td><td></td><td colspan="5" align="right"><strong>Total:</strong>
          <?php
          $grandtotal = $total + $tax;
           echo "$".number_format($grandtotal,2); ?></td>
        </tr>
        </tbody>
      </table>
      <?php //print_r($_SESSION);?>
    <!-- display stripe checkout -->
    <?php if($grandtotal< 50.00){
      echo "
      <div class='alert alert-info'>
      You must have a total of at least $50.00 to checkout: ". number_format(50-$grandtotal,2)." left!<br>
      <a id='' href='viewproducts.php'><p class=''>Shop For More</p></a>
      </div>";
    }else{?>
        <div class="w3-white w3-padding">
                <div class="row text-left">
                    <div class="col-sm-12">
                    <b><p>Almost Done!</p></b>
                    <p>Please Enter Payment Information</p>
                    </div>
                </div>
            <form action="vendor/charge.php" method="POST" id="payment-form" onsubmit="return checkForm(this);">
                <div class="form-row">
                    <div class="col-sm-12 text-left">
                        <h4 class="w3-text-blue">Contact Information</h4>
                    </div>
                      <div class="col-sm-6">
                            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                        </div>
                        <div class="col-sm-6">
                            <input type="tel" name="tel" class="form-control" placeholder="Phone Number (optional)">
                        </div>
                    <div class="col-sm-12 text-left">
                        <h4 class="w3-text-blue">Shipping Address</h4>
                    </div>
                    <input type="text" name="address" class="form-control" placeholder="1234 Stree Rd." required>
                    <div class="row">
                      <div class="col-sm-4">
                        <input type="text" name="city" class="form-control" placeholder="City" required>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" name="state" class="form-control" placeholder="State (XX)" required>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" name="zip" class="form-control" placeholder="Zip Code" required>
                      </div>
                        <div class="col-sm-12 text-left">
                        <h4 class="w3-text-blue">Card Information</h4>
                        </div>
                    </div>
                         <input type="text" name="nameoncard" class="form-control" placeholder="Name on Card">
                          <div id="card-element" class="form-control w3-margin">
                            <!-- a Stripe Element will be inserted here. -->
                          </div>
                        <input type="hidden" name="amount" value="<?php echo number_format($grandtotal,2)*100;?>" required>
                        <input type="hidden" name="productDetails" value="<?php echo $orderDetails;?>" required>
                        <input type="hidden" name="newOrder" value="newOrder" required>
                      <!-- Used to display form errors -->
                      <div id="card-errors" role="alert"></div>
                </div>
                <div class="row w3-padding">
                    <div class="col-sm-12 text-left">
                        <button id="submitBtn" name="newOrder" class="btn w3-green form-control">Done</button>
                    </div>
                </div>
            </form>
            <p class="small">Your payment will be handled with Stripe's payment gateway</p>
        </div>
      <?php }?>
      </div>
        <?php
      }
      ?>
    </div>
      <a id="btnEmpty" href="cart.php?action=empty"><p>Empty Cart</p></a>
    <p>Custom bracelets are nonrefundable if they do not fit.</p>
    </div>
</body>
<script>
  function checkForm(form) // Submit button clicked
  {
    //
    // check form input values
    //

    form.submitBtn.disabled = true;
    form.submitBtn.value = "Please wait...";
    return true;
  }

// Create a Stripe client.
//test pk CCA
//var stripe = Stripe('pk_test_qUgFXuTWbRNMy9wX7V8qIitR');
//var stripe = Stripe('pk_live_5vDcLyoj73ToOJPkDQChUeS4');

//live pk
var stripe = Stripe('pk_live_BgFh11h5GImo2t0qfpT6PGom');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    lineHeight: '18px',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});
// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();
  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}
</script>
