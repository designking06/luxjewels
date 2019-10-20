<?php
session_start();
include_once('../connect/pdo.php');
?>
<script src="https://js.stripe.com/v3/"></script>
<?php
    require_once('autoload.php');
$alert = "";
//test sk
//\Stripe\Stripe::setApiKey('sk_test_0Zzs458ZRFwqeOqqBO23pzQe');
//\Stripe\Stripe::setApiKey('sk_live_PWwLa3LcqmV0EM2xt2npbgcM');

//live sk
\Stripe\Stripe::setApiKey('sk_live_rMsMigKUtc199po1haIx5CUl');
     // Sanitize POST Array
     //$receipt = "";
     //$orderInfo = "";

try{
    if(isset($_POST['newOrder'])){
        echo "Charging...<br>";
        $token = $_POST['stripeToken'];
        if(empty($token)){
            $alert .= "Please ensure card details are entered.";
            header('location: ../cart.php?alert='.$alert);
            exit;
        }
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $nameoncard = $_POST['nameoncard'];
        $amount = $_POST['amount'];
        $productDetails = $_POST['productDetails'];
        echo "load..";
        //ready db insert
        $shipto = $address." ".$city.", ".$state." ".$zip;
        $receipt = "Customer Name:".$nameoncard. "|Address: ".$shipto."|".$productDetails;
        //create charge
        $charge = \Stripe\Charge::create([
           'amount' =>$amount,
            'currency' => 'usd',
            'description' => $receipt,
            'source' => $token,
            'receipt_email' => $email,
            'metadata' => ["email" => $email]
        ]);
        echo "charged.";
        //insert details into db
        //insert CompID, ordertotal, customerid, productdetails and date into table sales
        $date = date('Y-m-d');
        $compID = '6';
        $stmt = "INSERT INTO sales (CompID,ordertotal,customeremail,ordernotes,orderdate) VALUES(:CompID,:ordertotal,:customeremail,:ordernotes,:orderdate)";
        $insert = $pdo->prepare($stmt);
        $insert->bindParam(':CompID',$compID);
        $insAmount = $amount/100;
        $insert->bindParam(':ordertotal',$insAmount);
        $insert->bindParam(':customeremail',$email);
        $insert->bindParam(':ordernotes',$productDetails);
        $insert->bindParam('orderdate',$date);
        if($insert->execute()){
            $lastInsertId = $pdo->lastInsertId();
            //insert products into productspurchased
            foreach ($_SESSION["shoppingcart"] as $product){
                $id = $product['id'];
                $qty = $product['quantity'];
                if($qty > 0){
                    $stmt = "INSERT INTO productspurchased (orderid,productid,quantity) VALUES (:orderid,:productid,:quantity)";
                    $insert = $pdo->prepare($stmt);
                    $insert->bindParam(':orderid',$lastInsertId);
                    $insert->bindParam(':productid',$id);
                    $insert->bindParam(':quantity',$qty);
                    $insert->execute();
                }
            }
        }else{
            //error inserting sale into db

        }
        //display receipt
?>

<div class="container">
    <div id="thanks" class="row" style="border:1px solid #c2a23a;">
        <div class="col-sm-12"><h1>Lux Jwels Crystal Creations</h1></div>
        <div class="col-sm-12"><p>Thank you for shopping with us!</p></div>
        <div class="col-sm-12">
            <h1>Your Order Receipt:</h1>
            <p><?php echo $nameoncard;?></p>
            <p>Shipping to: <?php echo $shipto;?></p>
            <p>Estimated Arrival: 7-10 business days.</p>
            <h2>Items Purchased:</h2>
<?php
        $i = 1;
        foreach ($_SESSION["shoppingcart"] as $product){
                $id = $product['id'];
                $qty = $product['quantity'];
                if($qty > 0){
                 //list through products
                ?>
                <p>Item #<?php echo $i;?>: <?php echo $product['name']. " Qty: ".$product['quantity']. " Item Total: $".$product['price']*$product['quantity'];?></p>
            <?php
                }
        $i++;
        }
?>
            <h2>Total: $<?php echo $amount/100;?></h2>
        </div>
        <div class="col-sm-12">
            <p>Please screenshot or print this page to maintain this record</p>
        </div>
    </div>
</div>
<?php

    }
}
catch(\Stripe\Error\Card $e){
  // Since it's a decline, \Stripe\Error\Card will be caught
  $alert = "Your transaction didnt go through, please try again.";
  //header('location:index.php?alert='.$alert);
  /*
  $body = $e->getJsonBody();
  $err  = $body['error'];

  print('Status is:' . $e->getHttpStatus() . "\n");
  print('Type is:' . $err['type'] . "\n");
  print('Code is:' . $err['code'] . "\n");
  // param is '' in this case
  print('Param is:' . $err['param'] . "\n");
  print('Message is:' . $err['message'] . "\n");
  */
}
catch (\Stripe\Error\RateLimit $e) {
  // Too many requests made to the API too quickly
  $alert = "The site crashed because of too much activity, please try again";
  //header('location:index.php?#productRow?alert='.$alert);
}
catch (\Stripe\Error\InvalidRequest $e) {
  // Invalid parameters were supplied to Stripe's API
    $alert = "An error occured, please try again [37]";
    //header('location:index.php?#productRow?alert='.$alert);
    echo $alert;
    echo $e->getMessage();
}
catch (\Stripe\Error\Authentication $e) {
  // Authentication with Stripe's API failed
  // (maybe you changed API keys recently)
    $alert = "An error occured, please try again [41]";
  //  header('location:index.php?#productRow?alert='.$alert);
  echo $alert;
}
catch (\Stripe\Error\ApiConnection $e) {
  // Network communication with Stripe failed
  $alert = "A connection error occured, please try again [44]";
  //header('location:index.php?#productRow?alert='.$alert);
  echo $alert;
}
catch (\Stripe\Error\Base $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
  $alert = "An error occured, please try again [48]";
  //header('location:index.php?#productRow?alert='.$alert);
  echo $alert;
}
catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
  $alert = "A server error occured. [51]";
  //header('location:index.php?#productRow?alert='.$alert);
}
//header('location: cm3clientInvoice.php?alert='.$alert);
//exit;
