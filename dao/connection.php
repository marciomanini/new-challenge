<?php 

class Connection{
  private $con;
  public function getConnection(){
    if(!isset($con)){
      try { 
        $con = new PDO('mysql:host=localhost', 'root', '');
        $con->exec("set names utf8");

        return $con;
      } catch (Exception $e) {
        echo "Failed: " . $e->getMessage();
      }
    }
    else{
      return $con;
    }
  }

  public function closeConnection($con){
    $con = null;
  }
}

?>