<?php
session_start();
$product_ids = array();
include_once('../includes/displayfunctions.php');
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
        'quantity' => $_POST['quantity']
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
    echo "in cart";
    $_SESSION['shoppingcart'][0] = array
    (
      'id' => $_GET['id'],
      'name' => $_POST['productname'],
      'price' => $_POST['productprice'],
      'quantity' => $_POST['quantity']
    );
  }
}
if(isset($_GET['action']) && $_GET['action'] == "empty"){
  unset($_SESSION['shoppingcart']);
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
}
?>
<HTML>
<?php
getHead();
getNav();
?>
<BODY class="container-fluid w3-black">
<div class="container w3-white">
  <div id="shopping-cart">
    <?php getCompInfo(7,'c2a23a');?>
    <div class=""><h2 style="color:#c2a23a;">Your Cart</h2>
        <a id="" href="viewproducts.php"><p>Shop For More</p></a>
    </div>
    <div class="text-center">
      <?php
      if(isset($_SESSION['shoppingcart'])){
      ?>
      <table class="tbl-responsive w3-table-all w3-hoverable w3-text-black" cellpadding="10" cellspacing="1">
        <tbody>
          <tr class="w3-text-blue">
            <th>Product ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Desired Amount</th>
            <th>Item Total</th>
          </tr>
        <?php
          $total = 0;
            foreach ($_SESSION["shoppingcart"] as $product){
              $item_total = $product["price"]*$product["quantity"];
        		?>
        				<tr>
        				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><?php echo $product["id"]; ?></td>
                        				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $product["name"]; ?></strong></td>
                <td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo "$".$product["price"]; ?></td>
        				<td style="text-align:right;border-bottom:#F0F0F0 1px solid;">
                  <form method="post" action="cart.php?action=update&id=<?php echo $product["id"];?>">
                    <input type="text" name="updateQuantity" size="2" min="01" value="<?php echo $product["quantity"]; ?>" max="99" required>
                    <input type="submit" value="Update">
                  </form>
                </td>
                <td>$<?php echo $item_total;?></td>
              </tr>
              <?php
              $total = $total + $item_total;
              }?>

        <tr>
        <td colspan="5" align=right><strong>Total:</strong> <?php echo "$".$total; ?></td>
        </tr>
        </tbody>
      </table>
        <?php
      }
      ?>
    </div>
      <a id="btnEmpty" href="cart.php?action=empty"><p>Empty Cart</p></a>
  </div>
</div>
</BODY>
</HTML>
