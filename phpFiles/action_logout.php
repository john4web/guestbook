<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 07.02.2019
 * Time: 11:57
 */

session_start();

require_once("config.inc.php"); // der Code von config.inc.php wir hier hereinkopiert

if(isset($_POST['button_logout'])){

    Authorization::destroySession();
    header("Location: ../index.php?successfullyLoggedOut=1");

}elseif(isset($_POST['button_stayLoggedIn'])){

    header("Location: ../account.php");

}else{
    header("Location: ../index.php");
}