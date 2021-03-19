<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 06.02.2019
 * Time: 23:08
 */

session_start(); //Session wird angelegt: Session ID wird am Server gespeichert und in einem Cookie gespeichert.

require_once("config.inc.php"); // der Code von config.inc.php wir hier hereinkopiert
require_once("dataBase_credentials.php"); // der Code von dataBase_credentials.php wir hier hereinkopiert


if(isset($_POST['button_login'])){

    $username = htmlspecialchars($_POST['username_login'], ENT_QUOTES|ENT_HTML5); //X-Side-Scripting verhindern
    $password = htmlspecialchars($_POST['password_login'], ENT_QUOTES|ENT_HTML5);

    $isAllowed = Authorization::detectAuthorization($username, $password);

    if ($isAllowed) {
        header("Location: ../account.php");
    } else {
        header("Location: ../login.php?error=1");
    }

}else{
    header("Location: ../login.php");
}




