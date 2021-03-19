<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14.02.2019
 * Time: 16:43
 */

session_start(); //Session wird angelegt: Session ID wird am Server gespeichert und in einem Cookie gespeichert.

require_once("config.inc.php"); // der Code von config.inc.php wir hier hereinkopiert
require_once("dataBase_credentials.php"); // der Code von dataBase_credentials.php wir hier hereinkopiert


if(isset($_POST['button_changePassword'])){

    $oldPassword = htmlspecialchars($_POST['oldPassword_changePassword'], ENT_QUOTES|ENT_HTML5); //X-Side-Scripting verhindern
    $newPassword = htmlspecialchars($_POST['newPassword_changePassword'], ENT_QUOTES|ENT_HTML5);

    if($oldPassword !== "" && $newPassword !== ""){



        if($oldPassword === $_SESSION['password']){

            if(strlen($newPassword) <= 50){ //überprüfen ob Passwort zu lange ist


                Authorization::changePassword($_SESSION['name'], $newPassword);  //Passwort ändern
                $_SESSION['password'] = $newPassword;
                header("Location: ../account.php");

            }else{
                header("Location: ../account.php?longPassword=1");  //neues Passwort ist zu lange
            }

        }else{
            header("Location: ../account.php?oldPassword=0");   //Altes Passwort wurde falsch eingegeben
        }

    }else{
        header("Location: ../account.php?noPasswordInput=1");   //Ein oder zwei Felder wurde nicht ausgefüllt
    }

}else{
    header("Location: ../account.php");
}
