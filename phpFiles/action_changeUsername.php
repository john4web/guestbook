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


if(isset($_POST['button_changeUsername'])){

    $oldUserName = htmlspecialchars($_POST['oldUsername_changeUsername'], ENT_QUOTES|ENT_HTML5); //X-Side-Scripting verhindern
    $newUserName = htmlspecialchars($_POST['newUsername_changeUsername'], ENT_QUOTES|ENT_HTML5);

    if($oldUserName !== "" && $newUserName !== ""){

        if($oldUserName === $_SESSION['name']){

            if(strlen($newUserName) <= 15){ //überprüfen ob Username zu lange ist


                if(Authorization::usernameIsAlreadyRegistered($newUserName) === false){

                    Authorization::changeUserName($oldUserName, $newUserName);  //Usernamen ändern
                    $_SESSION['name'] = $newUserName;
                    header("Location: ../account.php");

                }else{
                    header("Location: ../account.php?userNameExists=1"); //neuen Usernamen gibt es schon
                }

            }else{
                header("Location: ../account.php?longUserName=1");  //neuer Username ist zu lange
            }

        }else{
            header("Location: ../account.php?oldUserName=0");   //Alter Username wurde falsch eingegeben
        }

    }else{
        header("Location: ../account.php?noInput=1");   //Ein oder zwei Felder wurde nicht ausgefüllt
    }






}else{
    header("Location: ../account.php");
}
