<?php
class Merchant{
  public function grabProducts(PDO $pdo,$CompID){
    $stmt = "select * from products where CompID = :CompID";
    $select = $pdo->prepare($stmt);
    $select->bindParam(":CompID",$CompID);
    $select->execute();
    $r = array();
    while($row = $select->fetch()){
    $r[] = $row;
    }
    return $r;
  }
  public function grabProductLines(PDO $pdo,$CompID){
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
  public function grabCollections(PDO $pdo,$CompID){
    $stmt = "select * from productCollection where CompID = :CompID";
    $select = $pdo->prepare($stmt);
    $select->bindParam(":CompID",$CompID);
    $select->execute();
    $r = array();
    while($row = $select->fetch()){
    $r[] = $row;
    }
    return $r;
  }
}
class luxJewels extends Merchant{
 public function __construct(PDO $pdo, $CompID){
  $CompID = $CompID;
  $collections = $this->grabCollections($pdo,$CompID);
  $productLines = $this->grabProductLines($pdo,$CompID);
 }
}
?>
