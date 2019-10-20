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
  }
</style>
<div class="w3-container w3-animate-opacity w3-green container-fluid" style="min-height:100%;">
  <!-- Container (Portfolio Section) -->
  <div class="w3-content w3-white">
  <div class="container w3-padding-64" id="portfolio">
    <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-6">
          <?php getCompInfo($pdo,6,'c2a23a');?>
      </div>
      <div class="col-sm-3"></div>
    </div><hr>
		<?php
		function goToPl(PDO $pdo,$CompID){
		$stmt = "select ProductLineID, ProductLineName, ProductLineImage from productlines where CompID = :CompID";
		  $select = $pdo->prepare($stmt);
		  $select->bindParam(":CompID",$CompID);
		  $select->execute();
		  foreach($select as $pl){
			$plID = $pl['ProductLineID'];
			$plName = $pl['ProductLineName'];
			?>
		<div class="col-sm-4">
            <a href="#<?php echo $plName;?>"><button class="w3-button w3-padding"><?php echo $plName;?></button></a>
        </div>
		<?php }}
		?>
	  <p class="w3-center lead w3-text-black w3-small">Click on the images to make them bigger</p><br>
  </div>
	  <div class="container">
		  <div class="row align-items-center">
		<?php
			  $pl = retrieveProductLines(6);
			  foreach($pl as $pl){
				  $r = retrieveProducts(6,$pl['ProductLineID']);
				  ?>
			  <div class="container-fluid w3-container">
				  <div class="w3-display-container w3-grayscale" style="background-image:url('https://cagency.net/media/images/<?php echo $pl['ProductLineImage'];?>');background-size:cover;background-position:center;height:300px;">
					<h1 class="w3-display-middle w3-text-white w3-padding" style="background-color:#c2a23a;"><?php echo $pl['ProductLineName'];?>
					  </h1>
				  </div>
			  </div>
			  <div class="w-100"></div>
			  <?php
				  $i=1;
				  for($i=1, $size = count($r); $i<$size ;++$i){
					  if($i<=4){
						  //do this
			  ?>
			  <!-- block of product with picture on left side and price, description and button on right -->
			  <div id="<?php echo $r[$i]['ProductID'];?>" onclick="document.getElementById('Product<?php echo $r[$i]['ProductID'];?>').style.display='block'" class="col-3 ">
				<img src="https://cagency.net/media/images/<?php echo $r[$i]['ProductImage'];?>" class="w3-card w3-image" style="max-height:200px;">
			</div>
			  <!-- end image -->
			  <div class="col-9 w3-padding w3-white">
                <h3><?php echo $r[$i]['ProductName'];?></h3>
                <p class=""><?php echo $r[$i]['ProductDescription'];?></p>
                <h4 class="w3-text-green">
					<?php //is item on sale?
						  if($r[$i]['ProductPrice'] === "0.00"){}
						  else{
							  if($r[$i]['IsOnSale'] == 0){/*item not on sale, display regular product price*/
					?>$<?php echo $r[$i]['ProductPrice'];
							  }else{/*item on sale, display product with strikethrough and sale price in red*/
					?>
					<span class="w3-text-yellow">$<?php echo $r[$i]['SalePrice']." ";?></span>
					<span style="text-decoration:line-through;" class="w3-text-grey"><?php echo $r[$i]['ProductPrice'];?></span>
					<?php } ?>
              	</h4>
				  <button class="w3-blue w3-button" onclick="document.getElementById('Product<?php echo $r[$i]['ProductID'];?>').style.display='block'">Add to Cart</button>
				  <?php }?>
			  </div>
			  <!-- end name, description, button-->
			  <!-- force new line with bootstrap -->
			  <div class="w-100"></div>
		<?php
			}
			else{
				//do this
				?>
				  <div class="col-6 col-sm-3 w3-padding">
					<div class="w3-display-container" style="height:240px;width:100%;background-image:url('https://cagency.net/media/images/<?php echo $r[$i]['ProductImage'];?>');background-size:contain;background-repeat:no-repeat;background-color:white;background-position:center;" onclick="document.getElementById('Product<?php echo $r[$i]['ProductID'];?>').style.display='block'">
					  <div class="" style="">
					  <p class='w3-display-topleft w3-black w3-small w3-padding'>
						  <?php //is item on sale?
						  if($r[$i]['IsOnSale'] == 0){/*item not on sale, display regular product price*/
						  ?>$<?php echo $r[$i]['ProductPrice'];
						  }else{/*item on sale, display product with strikethrough and sale price in red*/
						  ?><span class="w3-text-yellow">$<?php echo $r[$i]['SalePrice']." ";?></span><span style="text-decoration:line-through;"><?php echo $r[$i]['ProductPrice'];?></span>
						<?php } ?>
					  </p>
					  </div>
					</div>
				  </div>
		  <?php
			}
			  ?>
			  <div id="Product<?php echo $r[$i]['ProductID'];?>" class="container-fluid w3-modal" style="display:none;">
          <?php
              if($r[$i]['IsOnSale'] == 0){
                  $r[$i]['ProductPrice'] = $r[$i]['ProductPrice'];}
			  else{
                  $r[$i]['ProductPrice'] = $r[$i]['SalePrice'];
              }?>
          		<div class="w3-modal-content w3-animate-opacity">
              <div class="row w3-padding-64">
                    <div class="col-sm-12 text-center"><h1 class="w3-margin"><?php echo $r[$i]['ProductName'];?></h1></div>
                    <div class="col-sm-12 text-center">
                        <div class="w3-padding" style="background-image:url('http://cagency.net/media/images/<?php echo $r[$i]['ProductImage'];?>');background-position:center;background-size:contain;max-width:100%;height:475px;background-repeat:no-repeat;"></div>
                    </div>
                    <div class="col-sm-12 text-center w3-padding">
                        <b><p class="w3-padding"><?php echo $r[$i]['ProductDescription'];?></p></b>
                    </div>
                    <div class="col-sm-12 text-center">
			<?php
				if($r[$i]['ProductPrice'] === "0.00"){}
				  else{ ?>
                      <form id="Product<?php echo $r[$i]['ProductID'];?>Form" method="post" action="cart.php?action=add&id=<?php echo $r[$i]['ProductID']; ?>">
                        <input type="hidden" name="productname" value="<?php echo $r[$i]['ProductName'];?>">
                        <input type="hidden" name="productprice" value="<?php echo $r[$i]['ProductPrice'];?>">
						  <div class="">
							  <span class="col-6">Size:</span>
							  <select name="BraceletSize" placeholder="Choose Size" class="col-6" form="Product<?php echo $r[$i]['ProductID'];?>Form">
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
						  </div>
						  <div class="">
							  <span class="col-6">Quantity:</span>
							  <input type="number" name="quantity" value="1" size="2" min="1" class="col-6"/>
						  </div>
						  <p class="lead w3-text-green">
							<?php
								if($r[$i]['ProductPrice'] === "0.00"){}
								else{echo "$".$r[$i]['ProductPrice'];}
							?>
						  </p>
							  <input type="submit" name="add_to_cart" value="Add to cart" class="btn w3-blue" />
                      </form>
				<?php } ?>
                    </div>
                    <div class="col-sm-12 text-center w3-padding"><button onclick="document.getElementById('Product<?php echo $r[$i]['ProductID'];?>').style.display='none'" class="btn w3-padding w3-small">CLOSE</button></div>
              </div>
          </div>
      		</div>

			  <?php
		}
				  unset($r);
			  }

		?>
		  </div>
	  </div>
</div>
</div>
