<!-- display menu and header -->
<?php include_once('includes/require.php'); ?>
<?php include_once('class/company.php');?>
<?php
 $lux = new luxJewels($pdo,"6");
?>
<!-- load -->
<?php
if(isset($_GET['view'])){
  $pl = $lux->grabProductLines($pdo,"6");
  $like = $_GET['id'];
  $result = array_filter($pl, function ($pl) use ($like) {
        if (stripos($pl['ProductLineID'], $like) !== false) {
          ?>
          <div class="container">
              <div class="w3-padding-64 row align-items-center" style="height:300px;">
                <div class="col-12 text-center">
                  <h1 class="display-4"><?php echo $pl['ProductLineName'];?></h1>
                  <p class="lead"><?php echo $pl['ProductLineDescription'];?></p>
                </div>
              </div>
            </div>
          <?php
        }
        return false;
      });
      unset($result);
  ?>
  <div class="container">
    <div class="row align-items-start">
    <?php
    $pr = $lux->grabProducts($pdo,"6");
    switch($_GET['view']){
      case "pl":{
        $result = array_filter($pr, function ($pr) use ($like) {
              if (stripos($pr['ProductLineID'], $like) !== false) {
                ?>
                <!-- display products -->
                <div id="pr<?php echo $pr['ProductID'];?>" class="col-6 col-sm-6 col-md-4 col-lg-3 text-left" onclick="document.getElementById('prModal<?php echo $pr['ProductID'];?>').style.display='block'">
                  <div style="background-image:url('https://cagency.net/media/images/<?php echo $pr['ProductImage'];?>');background-size:contain;background-position:center;height:225px;" alt="<?php echo $pr['ProductName'];?>" class="w3-image"/></div>
                    <p class="text-left">
                      <span class="w3-small"><?php echo $pr['ProductName'];?></span><br>
                      <b>$<?php echo $pr['ProductPrice'];?></b><br>
                      <span class="w3-small"><?php echo $pr['ProductDescription'];?></span
                    </p>
                </div>
                <!--end productdisplay -->
                <!-- product modal -->
                <div id="prModal<?php echo $pr['ProductID'];?>" class="w3-modal w3-modal-container" style="display:none;">
                  <div class="container">
                    <div class="row">
                      <div class="col-1 text-left">
                        <span class="w3-large w3-red w3-padding" onclick="document.getElementById('prModal<?php echo $pr['ProductID'];?>').style.display='none'">X</span>
                      </div>
                    </div>
                  </div>
                  <div class="container w3-white w3-padding-32">
                    <div class="row w3-padding">
                      <div class="col-12 text-center"><h2><?php echo $pr['ProductName'];?></h2></div>
                    </div>
                    <div class="row align-items-center" style="max-height:400px;">
                      <div class="col-6">
                        <!-- img -->
                        <div class="w3-image" style="background-image:url('https://cagency.net/media/images/<?php echo $pr['ProductImage'];?>');background-position: center;background-clip: content-box;background-origin: content-box;background-size: contain;background-repeat: no-repeat;height:400px;max-width:100%;">
                      </div>
                    </div>
                      <div class="col-6">
                        <b>
                          $<?php echo $pr['ProductPrice'];?></b><br>
                          <?php echo $pr['ProductDescription'];?>
                        <br>
                        <form id="Product<?php echo $pr['ProductID'];?>Form" method="post" action="cart.php?action=add&id=<?php echo $pr['ProductID']; ?>">
                          <input type="hidden" name="productname" value="<?php echo $pr['ProductName'];?>">
                          <input type="hidden" name="productprice" value="<?php echo $pr['ProductPrice'];?>">
                          <select name="BraceletSize" placeholder="Choose Size" class="form-control" form="Product<?php echo $pr['ProductID'];?>Form">
                            <?php if($pr['ProductLineID'] === "37" || $pr['ProductLineID'] === "40" ){ ?>
                              <option value="6">6"</option>
                              <option value="8">8"</option>
                              <option value="10">10"</option>
                              <option value="10">12"</option>
                            <?php }if($pr['ProductLineID'] === "38" || $pr['ProductLineID'] === "41" ){ ?>
                              <option value="16">16"</option>
                              <option value="18">18"</option>
                              <option value="20">20"</option>
                              <?php }?>
                            </select>
                            <input type="text" name="quantity" value="1" size="2" min="1"/>
                            <input type="submit" name="add_to_cart" value="Add to cart" class="btn w3-blue" />
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
              }
              return false;
          });
        break;
      }
      case "c":{
        $result = array_filter($pr, function ($pr) use ($like) {
              if (stripos($pr['CollectionID'], $like) !== false) {
                ?>
                <!-- display products -->
                <div id="pr<?php echo $pr['ProductID'];?>" class="col-4">
                  <img src="https://cagency.net/media/images/<?php echo $pr['ProductImage'];?>" alt="<?php echo $pr['ProductName'];?>" class="w3-image"/>
                  <p><?php echo $pr['ProductName'];?></p>
                  <p><?php echo $pr['ProductDescription'];?></p>
                  <button>Add to Cart</button>
                </div>
                <!--end productdisplay -->
                <?php
              }
              return false;
          });
        break;
      }
      default:{
        echo "Your request returned 0 results.";
      }
    }
    ?>
  </div>
  </div>
  <?php
}else{
  echo "You have not chosen any product lines or collections to view.";
}
?>
