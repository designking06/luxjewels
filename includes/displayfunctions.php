<?php
function getNav(){
    ?>
    <!-- Navbar (sit on top) -->
  <div class="w3-bar" id="myNavbar">
    <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);" onclick="toggleFunction()" title="Toggle Navigation Menu">
      <i class="fa fa-bars"></i>
    </a>
    <a href="index.php" class="w3-bar-item w3-button">HOME</a>
    <a href="index.php#about" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-user"></i> ABOUT</a>
    <a href="viewproducts.php" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-th"></i>SHOP</a>
    <a href="index.php#contact" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-envelope"></i> CONTACT</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-hover-red">
      <i class="fa fa-search"></i>
    </a>
  </div>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
    <a href="index.php#about" class="w3-bar-item w3-button" onclick="toggleFunction()">ABOUT</a>
    <a href="index.php#shop" class="w3-bar-item w3-button" onclick="toggleFunction()">SHOP</a>
    <a href="index.php#contact" class="w3-bar-item w3-button" onclick="toggleFunction()">CONTACT</a>
    <a href="#" class="w3-bar-item w3-button">SEARCH</a>
  </div>
  <?php
}
function getHead(){
  ?>
  <html>
  <title>Lux Jewels</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <style>
  body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif;}
  </style>
  <?php
}
function getCompInfo($CompID,$color){
  global $pdo;
  //grab company description from db and display
  $stmt = "SELECT * FROM companies WHERE CompID = ? LIMIT 1";
  $select = $pdo->prepare($stmt);
  if($select->execute([$CompID])){
      $count = $select->rowCount();
      if($count > 0){
        foreach($select as $row){
          $name = $row['CompName'];
          $description = $row['CompDesc'];
          $logo = $row['CompLogo'];
          $industry = $row['CompInd'];
          ?>
          <div class="row"><div class="col-sm-12 text-center">
          <h1 style="color:#<?php echo $color;?>"><?php echo $name;?></h1>
          <p class="w3-text-grey"><?php echo $industry;?></p>
          <p><?php echo $description;?></p>
          </div></div>
          <?php
        }
      }else{
        //company has no info listed
      }
    }else{
        echo "Error connecting to our servers";
      }
}
function getCompanyContact($CompID){
  global $pdo;
  //grab company description from db and display
  $stmt = "SELECT * FROM companies WHERE CompID = ?";
  $select = $pdo->prepare($stmt);
  if($select->execute([$CompID])){
  foreach($select as $row){
    $address = $row['CompAddress'];
    $tel = $row['CompNum'];
    $email = $row['CompEmail'];
     ?>
  <i class="fa fa-map-marker fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Address: <?php echo $row['CompAddress'];?><br>
  <i class="fa fa-phone fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Phone: <?php echo $row['CompNum'];?><br>
  <i class="fa fa-envelope fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Email: <?php echo $row['CompEmail'];?><br>
  <?php
  }}else{
  }
}
function displayProductLineAndProduct($CompID){
    global $pdo;
      //grab company description from db and display
    $stmt = "SELECT * FROM productlines WHERE CompID = ?";
    $select = $pdo->prepare($stmt);
  if($select->execute([$CompID])){
    $count = $select->rowCount();
    if($count > 0){
      //use productlineid to fetch related products
      foreach($select as $pl){
          $ProductLineID = $pl['ProductLineID'];
          $ProductLineName = $pl['ProductLineName'];
          $ProductLineDescription = $pl['ProductLineDescription'];
          //display Product Line Name
          ?>
          <div id="<?php echo $ProductLineName;?>" class="">
            <div class="">
              <p class="display-4" style="color:#c2a23a;"><?php echo $ProductLineName;?></p>
              <p class=''><?php echo $ProductLineDescription;?></p>
            </div>
            <?php
              //use productlineid to fetch related products
              $stmt = "SELECT * FROM products WHERE ProductLineID = ? LIMIT 12";
              $select = $pdo->prepare($stmt);
              if($select->execute([$ProductLineID])){
                ?><div class="row"><?php
                  foreach($select as $product){
                      $productid = $product['ProductID'];
                      $productname = $product['ProductName'];
                      $productprice = $product['ProductPrice'];
                      $productdescription = $product['ProductDescription'];
                      $productimage = $product['ProductImage'];
                      //display products
                      ?>
                      <div class="col-sm-3 w3-margin-bottom">
                        <div class="w3-row w3-display-container" style="height:120px;width:100%;background-image:url('https://cagency.net/media/images/<?php echo $productimage;?>');background-size:cover;background-color:grey;" style="" onclick="document.getElementById('Product<?php echo $productid;?>').style.display='block'">
                          <div>
                            <p class="w3-display-topleft w3-black w3-small w3-padding">$<?php echo $productprice;?></p>
                          </div>
                        </div>
                          <div class="w3-row w3-light-grey w3-padding">
                            <h4 class="w3-text-red"><b><?php echo $productname;?></b></h4>
                            <p class="lead w3-small"><?php echo $productdescription;?></p>
                          </div>
                      </div>
                      <?php
                      }
              }//end if product line container
              ?>
              </div>
              <div class="row" style="width:100%;">
                <div class="col-sm-12 text-center">
                <a href="viewmoreproducts.php?id=<?php echo $ProductLineID;?>">
                  <button class="btn" style="margin:auto;background-color:#c2a23a;color:white;">
                  <h5 class="w3-padding text-center">Shop For More Like This</h5>
                </button>
              </a>
            </div>
              </div>
            </div>
            <?php
            }//end foreach
          }else{
            echo "No Product Lines or Products Available";
          }
  }else{
    echo "Issue connecting to our servers [79]";
      }
}
function displayProducts($CompID){
  global $pdo;
  //grab company description from db and display
  $stmt = "SELECT * FROM products WHERE CompID = ?";
  $select = $pdo->prepare($stmt);
  if($select->execute([$CompID])){
    $count = $select->rowCount();
    if($count > 0){
      ?>
                    <div class="row"><?php
                    foreach($select as $product){
                        $productid = $product['ProductID'];
                        $productname = $product['ProductName'];
                        $productprice = $product['ProductPrice'];
                        $productdescription = $product['ProductDescription'];
                        $productimage = $product['ProductImage'];
                        //display products
                        ?>
                        <div class="col-sm-3">
                        <div class="w3-display-container" style="width:100%;background-image:url('https://cagency.net/media/images/<?php echo $productimage;?>');background-size:cover;background-color:#c2a23a;;background-position:center;" onclick="document.getElementById('Product<?php echo $productid;?>').style.display='block'">
                        <div class="" style="height:140px;">
                        <p class="w3-display-topleft w3-black w3-small w3-padding">$<?php echo $productprice;?></p>
                        </div>
                        </div>
                        <p class="w3-black w3-small w3-padding"><?php echo $productname;?></p>
                      </div>
                        <div id="Product<?php echo $productid;?>" class="container-fluid w3-modal" style="display:none;">
                            <div class="w3-modal-content">
                                <div class="row w3-padding-64 w3-margin">
                                      <div class="col-sm-12 text-center"><h1 class="w3-margin"><?php echo $productname;?></h1></div>
                                      <div class="col-sm-6 text-center">
                                          <img src="http://cagency.net/media/images/<?php echo $productimage;?>" class="w3-image" style="max-width:350px;">
                                      </div>
                                      <div class="col-sm-6 text-left">
                                          <p><?php echo $productdescription;?></p>
                                          <p class="lead">$<?php echo $productprice;?></p>
                                      </div>
                                      <div class="col-sm-12 text-center w3-padding">
                                        <form method="post" action="cart.php?action=add&id=<?php echo $productid; ?>">
                                          <input type="hidden" name="productname" value="<?php echo $productname;?>">
                                          <input type="hidden" name="productprice" value="<?php echo $productprice;?>">
                                          <input type="text" name="quantity" value="1" size="2" min="1"/>
                                          <input type="submit" name="add_to_cart" value="Add to cart" class="btn" />
                                        </form>
                                      </div>
                                      <div class="col-sm-12 text-center w3-padding"><button onclick="document.getElementById('Product<?php echo $productid;?>').style.display='none'" class="btn w3-padding w3-small">CLOSE</button></div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }//end foreach
        }else{
          //no products
        }
                    ?>
                  </div>
    <?php
  }else{
    echo "";
}
}
function displayProductsWithDescription($CompID){
  global $pdo;
  //grab company description from db and display
  $stmt = "SELECT * FROM products WHERE CompID = ?";
  $select = $pdo->prepare($stmt);
  if($select->execute([$CompID])){
      //start a row
      ?>
        <div class="row">
      <?php
                foreach($select as $product){
                    $productid = $product['ProductID'];
                    $productname = $product['ProductName'];
                    $productprice = $product['ProductPrice'];
                    $productdescription = $product['ProductDescription'];
                    $productimage = $product['ProductImage'];
                    //display products
                    ?><div class='w3-section w3-padding w3-margin-bottom' style='max-width:250px;' onclick="document.getElementById('Product<?php echo $productid;?>').style.display='block'">

                    <div class='col-sm-2 w3-display-container' style='height:120px;' onclick="document.getElementById('Product<?php echo $productid;?>').style.display='block'">
                    <p class='w3-display-topleft w3-black w3-small w3-padding'>$<?php echo $productprice;?></p>
                    <img class="w3-image" src="http://cagency.net/media/images/<?php echo $productimage ;?>">
                    </div>
                    <?php
                    echo "<div class='row w3-light-grey w3-padding'>";
                    echo "<h4 class='w3-text-red'><b>".$productname."</b></h4>";
                    echo "<p class='lead w3-small w3-hide-small'>".$productdescription."</p>";
                    echo "</div>";
                    echo "</div>";
                    ?>
                    <div id="Product<?php echo $productid;?>" class="container-fluid w3-modal" style="display:none;">
                        <div class="w3-modal-content">
                            <div class="row w3-padding-64">
                                <div class="col-sm-1"><p onclick="document.getElementById('Product<?php echo $productid;?>').style.display='none'" class="w3-text-red w3-margin">CLOSE</p></div>
                                <div class="col-sm-6 text-center w3-padding">
                                    <h1 class="w3-margin"><?php echo $productname;?></h1>
                                    <img src="http://cagency.net/media/images/<?php echo $productimage;?>" class="w3-image w3-margin" style="max-width:350px;">
                                    <p><?php echo $productdescription;?></p>
                                    <p class="lead">$<?php echo $productprice;?></p>
                                </div>
                                <div class="col-sm-5"></div>
                            </div>
                        </div>
                    </div>
            <?php
                    }

      //end the row
      ?>
        </div>
    <?php
  }else{
    echo "";
}
}
function displayProductLineBanner($CompID){
  global $pdo;
  //grab company description from db and display
  $stmt = "SELECT * FROM productlines WHERE CompID = ? LIMIT 3";
  $select = $pdo->prepare($stmt);
  if($select->execute([$CompID])){
  foreach($select as $row){
     $row['ProductLineID'];
     $row['ProductLineName'];
      ?>
  <div class="w3-third w3-section">
      <a href="viewLine.php?plID=<?php echo $row['ProductLineID'];?>" style="text-decoration:none;"><span class="w3-xlarge"><?php echo $row['ProductLineName'];?></span></a>
  </div>
  <?php
  }
  }else{
    echo "sorry";
  }
}
function grabProductInfo($productid){

}
?>
