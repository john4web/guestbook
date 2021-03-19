<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14.02.2019
 * Time: 16:11
 */


session_start();

require_once("config.inc.php"); // der Code von config.inc.php wir hier hereinkopiert
require_once("dataBase_credentials.php"); // der Code von dataBase_credentials.php wir hier hereinkopiert



if(isset($_POST['button_deleteAccount'])){

    Authorization::deleteUserAccount($_SESSION['name']); //Benutzerdaten und Profilbild löschen

    Authorization::destroySession();//ausloggen

    header("Location: ../index.php?successfullyDeleted=1");

}else{
    header("Location: ../account.php");
}


