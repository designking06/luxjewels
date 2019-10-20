<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include_once($path.'/connect/pdo.php');
function getNav(){
    ?>
    <!-- Navbar (sit on top) -->
    <div class="container-fluid">
    <div class="row w3-black" id="myNavbar2">
      <div class="col-sm-4 text-center w3-small w3-hide-small" style="color:#c2a23a;">929-215-0493</div>
      <div class="col-sm-4 text-center" style="color:#c2a23a;">
		  <span onclick="window.location.href='https://luxjewelscrystalcreations.com/'">Lux Jewels Crystal Creations</span><br>
		  <span class="w3-text-green" onclick="window.location.href='https://luxjewelscrystalcreations.com/valentine/'">Its Springtime!</span>
		</div>
      <div class="col-sm-4 text-center w3-small w3-hide-small" style="color:#c2a23a;">Contact</div>
    </div>
  </div>
  <div class="w3-bar w3-black" id="myNavbar">
      <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);" onclick="toggleFunction()" title="Toggle Navigation Menu">
        <i class="fa fa-bars" style="color:#c2a23a;"></i>
      </a>
      <a href="https://luxjewelscrystalcreations.com/index.php" class="w3-bar-item w3-button" style="color:#c2a23a;">HOME</a>
      <a href="https://luxjewelscrystalcreations.com/index.php#about" class="w3-bar-item w3-button w3-hide-small" style="color:#c2a23a;"><i class="fa fa-user"></i> ABOUT</a>
      <span class="w3-bar-item w3-button w3-hide-small" style="color:#c2a23a;" onclick="document.getElementById('popUpMenu').style.display='block'"><i class="fa fa-th"></i>SHOP</span>
      <div id="popUpMenu" class="w3-modal w3-modal-container" style="display:none;">
        <div class="container w3-black w3-padding">
        <div class="row">
          <div class="col-12">
            <span class="w3-xlarge w3-red w3-padding w3-hover-deep-orange" onclick="document.getElementById('popUpMenu').style.display='none'">X</span>
          </div>
          <div class="col-12">
            <h1>Shop</h1>
            <hr>
          </div>
          <div class="col-12">
            <h4>Shop by Product Line</h4>
            <p onclick='window.location.href="view.php?view=pl&id=37"'>Bracelets</p>
            <p onclick='window.location.href="view.php?view=pl&id=38"'>Necklaces</p>
            <p onclick='window.location.href="view.php?view=pl&id=39"'>Earrings</p>
          </div>
          <div class="col-12">
            <h4>Shop by Collection</h4>
            <p>Coming soon</p>
          </div>
        </div>
      </div>
      </div>
      <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-hover-red">
        <i class="fa fa-search"></i>
      </a>
  </div>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium">
    <a href="https://luxjewelscrystalcreations.com/index.php#about" class="w3-bar-item w3-button" onclick="toggleFunction()">ABOUT</a>
    <span class="w3-bar-item w3-button" onclick="document.getElementById('popUpMenu').style.display='block'">SHOP</span>
    <a href="https://luxjewelscrystalcreations.com/index.php#contact" class="w3-bar-item w3-button" onclick="toggleFunction()">CONTACT</a>
  </div>
  <?php
}
function getHead(){
  ?>
  <html>
  <title>Lux Jewels Crystal Creations</title>
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
//
function getCompInfo(PDO $pdo,$CompID,$color){
  try{
    if(!is_numeric($CompID)){
      throw new Exception("Server error grabing company info.");
    }
    //grab company description from db and display
    $stmt = "SELECT * FROM companies WHERE CompID = ? LIMIT 1";
    $select = $pdo->prepare($stmt);
    if($select->execute([$CompID])){
        $count = $select->rowCount();
        if($count > 0){
  		  $c = array();
  		  while($row = $select->fetch()){
  			  $c[] = $row;
  		  }
  		  return $c;
  	  }else{
        throw new Exception("Server error grabing company info.");
      }
    }
  }catch(Exception $e){
    echo "Error:  ".$e->getMessage();
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

function retrieveProducts($CompID,$ProductLineID){
	global $pdo;
	$stmt = "select * from products where CompID = :CompID AND ProductLineID = :ProductLineID ORDER BY ProductPrice ASC, RAND()";
	$select = $pdo->prepare($stmt);
	$select->bindParam(":CompID",$CompID);
	$select->bindParam(":ProductLineID",$ProductLineID);
	$select->execute();
	$r = array();
	while($row = $select->fetch()){
		$r[] = $row;
	}
	return $r;
}
function retrieveProductLines($CompID){
	global $pdo;
	$stmt = "select * from productlines where CompID = :CompID";
	$select = $pdo->prepare($stmt);
	$select->bindParam(":CompID",$CompID);
	$select->execute();
	$r = array();
	while($row = $select->fetch()){
		$r[] = $row;
	}
	return $r;
}
function display($CompID){
  global $pdo;
  $stmt = "select ProductLineID, ProductLineName, ProductLineImage from productlines where CompID = :CompID";
  $select = $pdo->prepare($stmt);
  $select->bindParam(":CompID",$CompID);
  $select->execute();
  foreach($select as $pl){
    $lineNum = 1;
    $plID = $pl['ProductLineID'];
    $plName = $pl['ProductLineName'];
    ?>
    <div id="<?php echo $plName;?>" class="w3-container">
      <div class="w3-display-container w3-grayscale" style="background-image:url('https://cagency.net/media/images/<?php echo $pl['ProductLineImage'];?>');background-size:cover;background-position:center;height:300px;">
        <h1 class="w3-display-middle w3-text-white w3-padding" style="background-color:#c2a23a;"><?php echo $plName;?></h1>
      </div>
    <?php
    $stmt = "select * from products where ProductLineID = :plID ORDER BY ProductPrice ASC";
    $select = $pdo->prepare($stmt);
    $select->bindParam(":plID",$plID);
    $select->execute();
    $i = 1;
    foreach($select as $product){
      $productid = $product['ProductID'];
      $productname = $product['ProductName'];
      $productprice = $product['ProductPrice'];
      $productdescription = $product['ProductDescription'];
      $productimage = $product['ProductImage'];
      if($i <= 4){
        ?>
          <div class="row w3-padding w3-light-grey">
              <div class="col-sm-3 text-center" onclick="document.getElementById('Product<?php echo $productid;?>').style.display='block'">
                <img src="https://cagency.net/media/images/<?php echo $productimage;?>" class="w3-card w3-image" style="max-height:200px;">
              </div>
              <div class="col-sm-9 w3-padding w3-white">
                <h3><?php echo $productname;?></h3>
                <p class=""><?php echo $productdescription;?></p>
                <h4 class="w3-text-green">
       <?php //is item on sale?
		  if($productprice === "0.00"){}
		  else{
			  if($product['IsOnSale'] == 0){/*item not on sale, display regular product price*/
                    ?>$<?php echo $productprice;
                    }else{/*item on sale, display product with strikethrough and sale price in red*/
                    ?><span class="w3-text-yellow">$<?php echo $product['SalePrice']." ";?></span><span style="text-decoration:line-through;" class="w3-text-grey"><?php echo $productprice;?></span>
                <?php } ?>
              </h4>
              <button class="w3-blue w3-button" onclick="document.getElementById('Product<?php echo $productid;?>').style.display='block'">Add to Cart</button>
         <?php }?>
			  </div>
		</div>
		<?php
	  }else{
          ?>
          <div class="w3-col m3 w3-padding">
            <div class="w3-display-container" style="height:240px;width:100%;background-image:url('https://cagency.net/media/images/<?php echo $productimage;?>');background-size:contain;background-repeat:no-repeat;background-color:white;background-position:center;" onclick="document.getElementById('Product<?php echo $productid;?>').style.display='block'">
              <div class="" style="">
              <p class='w3-display-topleft w3-black w3-small w3-padding'>
                  <?php //is item on sale?
                  if($product['IsOnSale'] == 0){/*item not on sale, display regular product price*/
                  ?>$<?php echo $productprice;
                  }else{/*item on sale, display product with strikethrough and sale price in red*/
                  ?><span class="w3-text-yellow">$<?php echo $product['SalePrice']." ";?></span><span style="text-decoration:line-through;"><?php echo $productprice;?></span>
                <?php } ?>
              </p>
              </div>
            </div>
          </div>
          <?php
      }//end else
		?>
      <div id="Product<?php echo $productid;?>" class="container-fluid w3-modal" style="display:none;">
          <?php
              if($product['IsOnSale'] == 0){
                  $productprice = $product['ProductPrice'];}
			  else{
                  $productprice = $product['SalePrice'];
              }?>
          <div class="w3-modal-content w3-animate-opacity">
              <div class="row w3-padding-64">
                    <div class="col-sm-12 text-center"><h1 class="w3-margin"><?php echo $productname;?></h1></div>
                    <div class="col-sm-12 text-center">
                        <div class="w3-padding" style="background-image:url('http://cagency.net/media/images/<?php echo $productimage;?>');background-position:center;background-size:contain;max-width:100%;height:475px;background-repeat:no-repeat;"></div>
                    </div>
                    <div class="col-sm-12 text-center w3-padding">
                        <b><p class="w3-padding"><?php echo $productdescription;?></p></b>
                        <p class="lead w3-text-green w3-padding">
							<?php
								if($productprice === "0.00"){}
								else{echo "$".$productprice;}
							?>
						</p>
                    </div>
                    <div class="col-sm-12 text-center w3-padding">
			<?php
				if($productprice === "0.00"){}
				  else{ ?>
                      <form id="Product<?php echo $productid;?>Form" method="post" action="cart.php?action=add&id=<?php echo $productid; ?>">
                        <input type="hidden" name="productname" value="<?php echo $productname;?>">
                        <input type="hidden" name="productprice" value="<?php echo $productprice;?>">
                          <select name="BraceletSize" placeholder="Choose Size" class="form-control" form="Product<?php echo $productid;?>Form">
                            <?php
                            if($plName === "Bracelets"){
                             ?>
                              <option value="6">6"</option>
                              <option value="8">8"</option>
                              <option value="10">10"</option>
                              <option value="10">12"</option>
                            <?php }
							if($plName === "Valentines Bracelets"){
                             ?>
                              <option value="6">6"</option>
                              <option value="8">8"</option>
                              <option value="10">10"</option>
                              <option value="10">12"</option>
                            <?php }
                            if($plName === "Necklaces"){
                              ?>
                              <option value="16">16"</option>
                              <option value="18">18"</option>
                              <option value="20">20"</option>
                              <?php
                            }
							if($plName === "Valentines Necklaces"){
                              ?>
                              <option value="16">16"</option>
                              <option value="18">18"</option>
                              <option value="20">20"</option>
                              <?php
                            }
                            ?>
                          </select>
                        <input type="text" name="quantity" value="1" size="2" min="1"/>
                        <input type="submit" name="add_to_cart" value="Add to cart" class="btn w3-blue" />
                      </form>
				<?php } ?>
                    </div>
                    <div class="col-sm-12 text-center w3-padding"><button onclick="document.getElementById('Product<?php echo $productid;?>').style.display='none'" class="btn w3-padding w3-small">CLOSE</button></div>
              </div>
          </div>
      </div>
      <?php
      $i++;
    }
    $lineNum++;
    ?>
  </div>
    <?php
  }
  }//end function
function displayHome($CompID){
      global $pdo;
      $stmt = "select ProductLineID, ProductLineName, ProductLineImage from productlines where CompID = :CompID";
      $select = $pdo->prepare($stmt);
      $select->bindParam(":CompID",$CompID);
      $select->execute();
      foreach($select as $pl){
        $lineNum = 1;
        $plID = $pl['ProductLineID'];
        $plName = $pl['ProductLineName'];
        ?>
        <div id="<?php echo $plName;?>" class="w3-container">
          <div class="w3-display-container w3-grayscale" style="background-image:url('https://cagency.net/media/images/<?php echo $pl['ProductLineImage'];?>');background-size:cover;background-position:center;height:300px;">
            <h1 class="w3-display-middle w3-text-white w3-padding" style="background-color:#c2a23a;"><?php echo $plName;?></h1>
          </div>
        <?php
        $stmt = "select * from products where ProductLineID = :plID ORDER BY RAND() LIMIT 5";
        $select = $pdo->prepare($stmt);
        $select->bindParam(":plID",$plID);
        $select->execute();
        $i = 1;
        foreach($select as $product){
          $productid = $product['ProductID'];
          $productname = $product['ProductName'];
          $productprice = $product['ProductPrice'];
		  if($productprice === "0.00"){
				$productprice = "";
			}else{
				$productprice = "$".$productprice;
		  }
          $productdescription = $product['ProductDescription'];
          $productimage = $product['ProductImage'];
          if($i <= 2){
            ?>
              <div class="row w3-padding w3-light-grey">
                  <div class="col-sm-3 text-center" onclick="document.getElementById('Product<?php echo $productid;?>').style.display='block'">
                    <img src="https://cagency.net/media/images/<?php echo $productimage;?>" class="w3-card w3-image" style="max-height:200px;">
                  </div>
                  <div class="col-sm-9 w3-padding w3-white">
                    <h3><?php echo $productname;?></h3>
                    <p class=""><?php echo $productdescription;?></p>
                    <h4 class="w3-text-green">
				   <?php //is item on sale?
					  if($productprice === "0.00"){}
					  else{
						  if($product['IsOnSale'] == 0){/*item not on sale, display regular product price*/
								?><?php echo $productprice;
								}else{/*item on sale, display product with strikethrough and sale price in red*/
								?><span class="w3-text-yellow">$<?php echo $product['SalePrice']." ";?></span><span style="text-decoration:line-through;" class="w3-text-grey"><?php echo $productprice;?></span>
							<?php } ?>
						  </h4>
						  <button class="w3-blue w3-button" onclick="document.getElementById('Product<?php echo $productid;?>').style.display='block'">Add to Cart</button>
					 <?php }?>
                  </div>
              </div>
              <?php
          }else{
              ?>
              <div class="w3-col m4 w3-padding">
                <div class="w3-display-container" style="height:240px;width:100%;background-image:url('https://cagency.net/media/images/<?php echo $productimage;?>');background-size:cover;background-color:black;;background-position:center;" onclick="document.getElementById('Product<?php echo $productid;?>').style.display='block'">
                  <div class="" style="">
                  <p class='w3-display-topleft w3-black w3-small w3-padding'>
                      <?php //is item on sale?
                      if($product['IsOnSale'] == 0){/*item not on sale, display regular product price*/
                      ?><?php echo $productprice;
                      }else{/*item on sale, display product with strikethrough and sale price in red*/
                      ?><span class="w3-text-yellow">$<?php echo $product['SalePrice']." ";?></span><span style="text-decoration:line-through;"><?php echo $productprice;?></span>
                    <?php } ?>
                  </p>
                  </div>
                </div>
              </div>
              <?php
          }//end else
          ?>
          <div id="Product<?php echo $productid;?>" class="container-fluid w3-modal" style="display:none;">
              <?php
              //is item on sale?
                  if($product['IsOnSale'] == 0){
                      $productprice = $product['ProductPrice'];
                    }else{
                      $productprice = $product['SalePrice'];
                  }
			if($productprice === "0.00"){
				$productprice = "";
			}
			  ?>
              <div class="w3-modal-content w3-animate-opacity">
                  <div class="row w3-padding-64">
                        <div class="col-sm-12 text-center"><h1 class="w3-margin"><?php echo $productname;?></h1></div>
                        <div class="col-sm-12 text-center">
                            <div class="w3-padding" style="background-image:url('http://cagency.net/media/images/<?php echo $productimage;?>');background-position:center;background-size:contain;background-repeat:no-repeat;max-width:100%;height:475px;"></div>
                        </div>
                        <div class="col-sm-12 text-center w3-padding">
                            <b><p class="w3-padding"><?php echo $productdescription;?></p></b>
                            <p class="lead w3-text-green w3-padding">$<?php echo $productprice;?></p>
                        </div>
                        <div class="col-sm-12 text-center w3-padding">
			<?php if($productprice === "0.00"){}
				  else{ ?>
                          <form id="Product<?php echo $productid;?>Form" method="post" action="cart.php?action=add&id=<?php echo $productid;?>">
                            <input type="hidden" name="productname" value="<?php echo $productname;?>">
                            <input type="hidden" name="productprice" value="<?php echo $productprice;?>">
                              <select name="BraceletSize" placeholder="Choose Size" class="form-control" form="Product<?php echo $productid;?>Form">
                                <?php
                                if($plName === "Bracelets"){
                                 ?>
                                  <option value="6">6"</option>
                                  <option value="8">8"</option>
                                  <option value="10">10"</option>
                                  <option value="10">12"</option>
                                <?php }
                                if($plName === "Necklaces"){
                                  ?>
                                  <option value="16">16"</option>
                                  <option value="18">18"</option>
                                  <option value="20">20"</option>
                                  <?php
                                }
                                ?>
                              </select>
                            <input type="text" name="quantity" value="1" size="2" min="1"/>
                            <input type="submit" name="add_to_cart" value="Add to cart" class="btn w3-blue" />
                          </form>
				<?php } ?>
                        </div>
                        <div class="col-sm-12 text-center w3-padding"><button onclick="document.getElementById('Product<?php echo $productid;?>').style.display='none'" class="btn w3-padding w3-small">CLOSE</button></div>
                  </div>
              </div>
          </div>
          <?php
          $i++;
        }
        $lineNum++;
        ?>
		<button onclick="window.location.href='view.php?view=pl&id=<?php echo $plID;?>'" class="w3-button w3-blue">More <?php echo $plName;?></button>
      </div>
        <?php
      }
      }//end function
function displayProducts($CompID){
  global $pdo;
  //grab company description from db and display
  $stmt = "SELECT * FROM products WHERE CompID = ? ORDER BY ProductPrice DESC";
  $select = $pdo->prepare($stmt);
  if($select->execute([$CompID])){
    $count = $select->rowCount();
    if($count > 0){
            foreach($select as $product){
                        $productid = $product['ProductID'];
                        $productname = $product['ProductName'];
                        $productprice = $product['ProductPrice'];
                        $productdescription = $product['ProductDescription'];
                        $productimage = $product['ProductImage'];
                        //display products
                        ?>
                        <div class="w3-col m4 w3-padding">
                          <div class="w3-display-container" style="height:240px;width:100%;background-image:url('https://cagency.net/media/images/<?php echo $productimage;?>');background-size:cover;background-color:black;;background-position:center;" onclick="document.getElementById('Product<?php echo $productid;?>').style.display='block'">
                            <div class="" style="">
                            <p class='w3-display-topleft w3-black w3-small w3-padding'>
                                <?php //is item on sale?
                                if($product['IsOnSale'] == 0){/*item not on sale, display regular product price*/
                                ?>$<?php echo $productprice;
                                }else{/*item on sale, display product with strikethrough and sale price in red*/
                                ?><span class="w3-text-yellow">$<?php echo $product['SalePrice']." ";?></span><span style="text-decoration:line-through;"><?php echo $productprice;?></span>
                                <?php } ?>
                            </p>
                            </div>
                          </div>
                        </div>
                        <div id="Product<?php echo $productid;?>" class="container-fluid w3-modal" style="display:none;">
                            <?php //is item on sale?
                                if($product['IsOnSale'] == 0){
                                    $productprice = $product['ProductPrice'];}else{
                                    $productprice = $product['SalePrice'];
                                }?>
                            <div class="w3-modal-content w3-animate-opacity">
                                <div class="row w3-padding-64">
                                      <div class="col-sm-12 text-center"><h1 class="w3-margin"><?php echo $productname;?></h1></div>
                                      <div class="col-sm-12 text-center">
                                          <div class="w3-padding" style="background-image:url('http://cagency.net/media/images/<?php echo $productimage;?>');background-position:center;background-size:cover;max-width:100%;height:475px;"></div>
                                      </div>
                                      <div class="col-sm-12 text-center w3-padding">
                                          <b><p class="w3-padding"><?php echo $productdescription;?></p></b>
                                          <p class="lead w3-text-green w3-padding">$<?php echo $productprice;?></p>
                                      </div>
                                      <div class="col-sm-12 text-center w3-padding">
                                        <form id="Product<?php echo $productid;?>Form" method="post" action="cart.php?action=add&id=<?php echo $productid; ?>">
                                          <input type="hidden" name="productname" value="<?php echo $productname;?>">
                                          <input type="hidden" name="productprice" value="<?php echo $productprice;?>">
                                            <select name="BraceletSize" placeholder="Choose Size" class="form-control" form="Product<?php echo $productid;?>Form">
                                                <option value="6">6</option>
                                                <option value="8">8</option>
                                                <option value="10">10</option>
                                                <option value="10">12</option>
                                            </select>
                                          <input type="text" name="quantity" value="1" size="2" min="1"/>
                                          <input type="submit" name="add_to_cart" value="Add to cart" class="btn w3-blue" />
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
  }else{
    echo "";
}
}
function grabProducts(PDO $pdo,$CompID){
	//grab all products from table
	$stmt = "SELECT * FROM products WHERE CompID = :CompID";
	$select = $pdo->prepare($stmt);
	$select->bindParam(":CompID",$CompID);
	$p = array();
	if($select->execute()){
		foreach($select as $p){
			$p = $p;
		}
		return $p;
	}else{
		return FALSE;
	}
}
?>
