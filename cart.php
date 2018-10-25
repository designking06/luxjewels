<?php
session_start();
include_once('../includes/displayfunctions.php');
try{
  $pdo = new PDO('mysql:host=127.0.0.1;dbname=ccacms','root','');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo $e->getMessage();
  die();
}
if(!empty($_GET["action"])) {
  switch($_GET["action"]) {
  	case "add":
  		if(!empty($_POST["quantity"])) {
        $stmt = "SELECT * FROM products WHERE ProductID = ? LIMIT 1";
        $select = $pdo->prepare($stmt);
        $select->execute([$_GET['code']]);
        $count = $select->rowCount();
        if($count > 0){
          foreach($select as $row){
          $productid = $row['ProductID'];
          $productname = $row['ProductName'];
          $productprice = $row['ProductPrice'];
        			$itemArray = array($productid=>array('name'=>$productname, 'code'=>$productid, 'quantity'=>$_POST["quantity"], 'price'=>$productprice));

        			if(!empty($_SESSION["cart_item"])) {
        				if(in_array($productid,array_keys($_SESSION["cart_item"]))) {
        					foreach($_SESSION["cart_item"] as $k => $v) {
        							if($productid == $k) {
        								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
        									$_SESSION["cart_item"][$k]["quantity"] = 0;
        								}
        								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
        							}
        					}
        				} else {
        					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
        				}
        			} else {
        				$_SESSION["cart_item"] = $itemArray;
        			}
            }
          }else{
            //an error occurred grabbing id from server
          }
  		}
  	break;
  	case "remove":
  		if(!empty($_SESSION["cart_item"])) {
        if(in_array($_GET["code"],array_values($_SESSION["cart_item"] ) ) ){
          $_SESSION["cart_item"][$_GET["code"]]["quantity"] = $_SESSION["cart_item"][$_GET["code"]]["quantity"] - $_POST["removeQuantity"];
          if($_SESSION["cart_item"][$_GET["code"]]["quantity"] < 0){
            $_SESSION["cart_item"][$_GET["code"]]["quantity"] == 0;
          }
            if($_SESSION["cart_item"][$_GET["code"]]["quantity"] == 0){
              unset($_SESSION["cart_item"][$_GET["code"]]);
              header('location:cart.php');
            }
        }else{
          $alert = "not found in array";
        }
  		}
  	break;
  	case "empty":
  		unset($_SESSION["cart_item"]);
  	break;
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
    <div class=""><h2>Your Cart</h2>
        <a id="" href="viewproducts.php"><p>Shop For More</p></a>
    </div>
    <div class="text-center">
      <?php
      var_dump($_SESSION["cart_item"]);
      print_r(array($_SESSION["cart_item"]));
      if(isset($_SESSION["cart_item"])){
          $item_total = 0;
      ?>
      <table class="table-responsive w3-table-all w3-hoverable w3-text-black" cellpadding="10" cellspacing="1">
        <tbody>
        <tr>
        <th style="text-align:left;"><strong>Name</strong></th>
        <th style="text-align:left;"><strong>Code</strong></th>
        <th style="text-align:right;"><strong>Quantity</strong></th>
        <th style="text-align:right;"><strong>Price</strong></th>
        <th style="text-align:center;"><strong>Action</strong></th>
        </tr>
        <?php
            foreach ($_SESSION["cart_item"] as $item){
        		?>
        				<tr>
        				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><strong><?php echo $item["name"]; ?></strong></td>
        				<td style="text-align:left;border-bottom:#F0F0F0 1px solid;"><?php echo $item["code"]; ?></td>
        				<td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo $item["quantity"]; ?></td>
        				<td style="text-align:right;border-bottom:#F0F0F0 1px solid;"><?php echo "$".$item["price"]; ?></td>
        				<td style="text-align:center;border-bottom:#F0F0F0 1px solid;">
                  <form method="post" action="cart.php?action=remove&code=<?php echo $item["code"];?>">
                    <input type="text" name="removeQuantity" size="2" min="01" value="1" max="<?php echo $item["quantity"];?>" required>
                    <input type="submit" value="Remove">Remove Item</a></td>
                  </form>
        				</tr>
        				<?php
                $item_total += ($item["price"]*$item["quantity"]);
        		}
        		?>

        <tr>
        <td colspan="5" align=right><strong>Total:</strong> <?php echo "$".$item_total; ?></td>
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
