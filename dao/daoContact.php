<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/novodesafio/util/loadClasses.php");

class DaoContact{

  public function addContact($data){

    $connection = new connection();
    $con = $connection->getConnection();

    try {
      $query = "INSERT INTO `desafio`.`contacts`
        (
        name,
        email,
        address,
        address_complement,
        birthday,
        phone1,
        phone2
        )
        VALUES
        (
        :name,
        :email,
        :address,
        :address_complement,
        :birthday,
        :phone1,
        :phone2
        );";
      $sql = $con->prepare($query);
      $sql->execute($data);
      echo $sql->rowCount();
    } catch(PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
    $connection->getConnection($con);
  }

  //This function returns 1 if the email already exist
  function checkEmail($email){

    $connection = new connection();
    $con = $connection->getConnection();

    $query = "SELECT COUNT(*) AS CONT FROM `desafio`.`contacts` WHERE email = :email;";
    $sql = $con->prepare($query);
    $sql->bindValue(':email',$email);
    $sql->execute();
    return $sql->fetch(PDO::FETCH_ASSOC)['CONT'] > 0;

    $connection->getConnection($con);
  }

  function getDT(){

    $connection = new connection();
    $con = $connection->getConnection();

    $query = "SELECT
        id,
        name,
        email,
        address,
        address_complement,
        DATE_FORMAT(birthday,'%d/%m/%Y') AS birthday,
        phone1,
        phone2
          FROM `desafio`.`contacts`;";
    $sql = $con->prepare($query);
    $sql->execute();
    $result = $sql->fetchAll();
    return $result;

    $connection->getConnection($con);
  }

  public function listContact($id){

    $connection = new connection();
    $con = $connection->getConnection();

    $query = "SELECT
        name,
        email,
        address,
        address_complement,
        DATE_FORMAT(birthday,'%d/%m/%Y') AS birthday,
        phone1,
        phone2
          FROM `desafio`.`contacts`
      WHERE id = :id;";
    $sql = $con->prepare($query);
    $sql->bindValue(':id',$id);
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    return $result;

    $connection->getConnection($con);
  }

  public function updContact($data){

    $connection = new connection();
    $con = $connection->getConnection();

    try {
      $query = "UPDATE
          `desafio`.`contacts`
            SET
            name = :name,
            email = :email,
            address = :address,
            address_complement = :address_complement,
            birthday = :birthday,
            phone1 = :phone1,
            phone2 = :phone2
        WHERE id = :id;";
      $sql = $con->prepare($query);
      $sql->execute($data);
    } catch(PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
    $connection->getConnection($con);
  }

  function delContact($id){

    $connection = new connection();
    $con = $connection->getConnection();

    try {
      $query = "DELETE  FROM `desafio`.`contacts` WHERE id = :id;";
      $sql = $con->prepare($query);
      $sql->bindValue(':id',$id);
      $sql->execute();
    } catch(PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
    $connection->getConnection($con);
  }

  function getMonthyAnniversary(){

    $connection = new connection();
    $con = $connection->getConnection();

    $query = "SELECT
        name,
        DATE_FORMAT(birthday,'%d/%m/%Y') AS birthday,
        IF(DATE_FORMAT(birthday, '%d') = DATE_FORMAT(sysdate(), '%d'), 1, 0) AS today,
        DATE_FORMAT(birthday, '%Y') AS year,
        DATE_FORMAT(sysdate(), '%Y') AS current_year

          FROM `desafio`.`contacts`
      WHERE DATE_FORMAT(birthday, '%m') = DATE_FORMAT(sysdate(), '%m')
    ORDER BY birthday;";
    $sql = $con->prepare($query);
    $sql->execute();
    $result = $sql->fetchAll();
    return $result;

    $connection->getConnection($con);
  }
}
?>