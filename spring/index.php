<?php 
   $path = $_SERVER['DOCUMENT_ROOT'];
   $path .= "/includes/require.php";
   include_once($path);
?>
<?php 
function grabPl(PDO $pdo,$PlName){
	$stmt = "SELECT ProductLineID, ProductLineName, ProductLineImage FROM productlines WHERE ProductLineName = :ProductLineName";
	$select = $pdo->prepare($stmt);
	$select->bindParam(":ProductLineName",$PlName);
	if($select->execute()){
		$pl = array();
		while($row = $select->fetch()){
			$pl[] = $row;
		}
		return $pl;
	}
}
function displayP(PDO $pdo,$CompID,$PlID){
	$stmt = "SELECT * FROM products WHERE CompID = :CompID AND ProductLineID = :ProductLineID";
	$select = $pdo->prepare($stmt);
	$select->bindParam(":CompID",$CompID);
	$select->bindParam(":ProductLineID",$PlID);
	if($select->execute()){
		$pr = array();
		while($row = $select->fetch()){
			$pr[] = $row;
		}
		return $pr;
	}
}
?>
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
<div class="w3-container w3-animate-opacity w3-pink container-fluid" style="min-height:100%;">
  <!-- Container (Portfolio Section) -->
  <div class="w3-content w3-white">
  <div class="container w3-padding-64" id="portfolio">
    <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-6">
          <?php $c = getCompInfo($pdo,6,'c2a23a');
		  foreach($c as $c){?>          
		  <div class="row"><div class="col-sm-12 text-center">
          <p class="w3-large" style="color:#c2a23a;"><?php echo $c['CompName'];?></p>
			<h2 class="w3-text-grey">Valentine's Day Collection</h2>
          	<p class="w3-text-pink w3-large">
				They say a diamond is a girls best friend;<br>
				Give her your heart, that will last a life time.
			</p>
          </div></div>
		  <?php }
		  ?>
      </div>
      <div class="col-sm-3"></div>
    </div><hr>
    <div class="row text-center w3-padding-16" style="">
      <div class="col-sm-12">
        <h3 class="lead w3-text-grey">Do you already know what you're looking for?</h3>
        <p class="w3-small">Search Here</p>
        </div>
	  </div>
		<?php
	  	$plN = array("Bracelets");
	  	foreach($plN as $plN){
		$pl = grabPl($pdo,$plN);
		foreach($pl as $pl){
		?>
	  	<div class="row w3-padding-16">
			<div class="col-sm-12 w3-display-container" style="background-image:url('https://cagency.net/media/images/<?php echo $pl['ProductLineImage'];?>');background-size:cover;background-position:center;height:250px;">
			<h1 class="w3-white w3-text-pink w3-padding w3-display-middle text-center"><?php echo $pl['ProductLineName'];?></h1>
			</div>
	  	</div>
		<div class="row">
		<?php
		$pr = displayP($pdo,6,$pl['ProductLineID']);
		foreach($pr as $pr){
		?>
		<div id="<?php echo $pr['ProductName'];?>" class="col-sm-3 w3-padding" onclick="showModal('<?php echo $pr['ProductID'];?>');">
			<div style="background-image:url('https://cagency.net/media/images/<?php echo $pr['ProductImage'];?>');background-position:center;background-size:cover;height:200px;width:100%;">
			</div>
		</div>
		 <div id="<?php echo $pr['ProductID'];?>" class="container-fluid w3-modal" style="display:none;">
          <?php
              if($pr['IsOnSale'] == 0){
                  $productprice = $pr['ProductPrice'];}
			  else{
                  $productprice = $pr['SalePrice'];
              }?>
          <div class="w3-modal-content w3-animate-opacity">
              <div class="row w3-padding-64">
                    <div class="col-sm-12 text-center"><h1 class="w3-margin"><?php echo $pr['ProductName'];?></h1></div>
                    <div class="col-sm-12 text-center">
                        <div class="w3-padding" style="background-image:url('http://cagency.net/media/images/<?php echo $pr['ProductImage'];?>');background-position:center;background-size:contain;max-width:100%;height:475px;background-repeat:no-repeat;"></div>
                    </div>
                    <div class="col-sm-12 text-center w3-padding">
                        <b><p class="w3-padding"><?php echo $pr['ProductDescription'];?></p></b>
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
                      <form id="Product<?php echo $pr['ProductID'];?>Form" method="post" action="../cart.php?action=add&id=<?php echo $pr['ProductID']; ?>">
                        <input type="hidden" name="productname" value="<?php echo $pr['ProductName'];?>">
                        <input type="hidden" name="productprice" value="<?php echo $productprice;?>">
                          <select name="BraceletSize" placeholder="Choose Size" class="form-control" form="Product<?php echo $pr['ProductID'];?>Form">
                            <?php
                            if($pl['ProductLineName'] === "Bracelets"){
                             ?>
                              <option value="6">6"</option>
                              <option value="8">8"</option>
                              <option value="10">10"</option>
                              <option value="10">12"</option>
                            <?php }
							if($pl['ProductLineName'] === "Valentines Bracelets"){
                             ?>
                              <option value="6">6"</option>
                              <option value="8">8"</option>
                              <option value="10">10"</option>
                              <option value="10">12"</option>
                            <?php }
                            if($pl['ProductLineName'] === "Necklaces"){
                              ?>
                              <option value="16">16"</option>
                              <option value="18">18"</option>
                              <option value="20">20"</option>
                              <?php
                            }
							if($pl['ProductLineName'] === "Valentines Necklaces"){
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
                    <div class="col-sm-12 text-center w3-padding"><button onclick="hideModal('<?php echo $pr['ProductID'];?>');" class="btn w3-padding w3-small">CLOSE</button></div>
              </div>
          </div>
      </div>
		<?php
		}
		?>
		</div>
		<?php
		}
	  unset($pl);
	  unset($pr);
		}
		?>
    <hr>
      <p class="w3-center lead w3-text-black w3-small">Click on the images to make them bigger</p><br>
    <!-- Responsive Grid. Four columns on tablets, laptops and desktops. Will stack on mobile devices/small screens (100% width) -->
    <div id="productsAll">
      <div class="row w3-margin-top"><div class="col-sm-12"><h2 style="color:#bf0600"></h2></div></div>
      <!-- list products-->
    </div>
  </div>
    <div class="">
		<!-- display products -->
    </div>
</div>
</div>
<script>
function showModal(id){
	document.getElementById(id).style.display = 'block';
}
function hideModal(id){
	document.getElementById(id).style.display = 'none';
}
</script>