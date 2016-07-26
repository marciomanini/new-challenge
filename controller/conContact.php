<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . "/novodesafio/util/loadClasses.php");


$function = $_REQUEST["action"];
if (function_exists($function)) {
    call_user_func($function);
}

function formatData($date) {
    $dataPost = explode("/", $date);
    $organizedData = array($dataPost[2], $dataPost[1], $dataPost[0]);
    $dataInsert = date('Y-m-d', strtotime(implode("/", $organizedData)));

    return $dataInsert;
}

function checkBirthday($birthday){
    date_default_timezone_set('America/New_York');

    //Checking if the birthday is valid
    $dataPost = explode("/", $birthday);
    if(!empty($birthday) && !checkdate($dataPost[1], $dataPost[0], $dataPost[2]))
        return "Invalid birthday date";

    //If the birthday is higher than current date is wrong
    if(!empty($birthday) && str_replace("/", "-", formatData($birthday)) > date('Y-m-d'))
        return "The birthday can't be higher than current date";

    return true;
}

function addContact(){
    $register = new daoContact();

    //If the e-mail doesn't exist on database
    if($register->checkEmail(trim(strtolower($_POST['email'])))){
        echo("There is already a contact with this e-mail");
        return;
    }

    $answer = checkBirthday($_POST['birthday']);
    if($answer !== true){
        echo $answer;
        return;
    }

    $data = array(
        ':name'                 => $_POST['name'],
        ':email'                => trim(strtolower($_POST['email'])),
        ':address'              => $_POST['address'],
        ':address_complement'   => !empty($_POST['address_complement']) ? $_POST['address_complement'] : null,
        ':birthday'             => !empty($_POST['birthday']) ? formatData($_POST['birthday']) : null,
        ':phone1'               => !empty($_POST['phone1']) ? $_POST['phone1'] : null,
        ':phone2'               => !empty($_POST['phone2']) ? $_POST['phone2'] : null
    );
    $register->addContact($data);
}

function getDT() {

    $register = new daoContact();

    echo json_encode($register->getDT());
}

function listContact(){
    $register = new daoContact();

    echo json_encode($register->listContact($_POST['id']));
}

function updContact(){
    $register = new daoContact();

    //If the e-mail doesn't exist on database and is different from old e-mail
    if($register->checkEmail(trim(strtolower($_POST['email']))) && $_POST['email'] !== $_POST['old-email']){
        echo("There is already a contact with this e-mail");
        return;
    }

    $answer = checkBirthday($_POST['birthday']);
    if($answer !== true){
        echo $answer;
        return;
    }

    $data = array(
        ':id'                   => $_POST['id-contact'],
        ':name'                 => $_POST['name'],
        ':email'                => trim(strtolower($_POST['email'])),
        ':address'              => $_POST['address'],
        ':address_complement'   => !empty($_POST['address_complement']) ? $_POST['address_complement'] : null,
        ':birthday'             => !empty($_POST['birthday']) ? formatData($_POST['birthday']) : null,
        ':phone1'               => !empty($_POST['phone1']) ? $_POST['phone1'] : null,
        ':phone2'               => !empty($_POST['phone2']) ? $_POST['phone2'] : null
    );
    $register->updContact($data);
}

function delContact(){
    $register = new daoContact();

    $register->delContact($_POST['id']);
}

function getMonthyAnniversary(){
    $register = new daoContact();

    echo json_encode($register->getMonthyAnniversary()); 
}

?>