<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 05.02.2019
 * Time: 23:03
 */

session_start(); //Session wird angelegt: Session ID wird am Server gespeichert und in einem Cookie gespeichert.

require_once("config.inc.php"); // der Code von config.inc.php wir hier hereinkopiert
require_once("dataBase_credentials.php"); // der Code von dataBase_credentials.php wir hier hereinkopiert

if(isset($_POST['button_register'])){

    $username = htmlspecialchars($_POST['username_register'], ENT_QUOTES|ENT_HTML5); //X-Side-Scripting verhindern
    $password = htmlspecialchars($_POST['password_register'], ENT_QUOTES|ENT_HTML5);
    $passwordRepeated = htmlspecialchars($_POST['password_repeat_register'], ENT_QUOTES|ENT_HTML5);

    if($password != $passwordRepeated){ //überprüfen ob das Passwort richtig wiederholt wurde

        header("Location: ../register.php?passwordrepeat=0");

    }elseif ($username === "" || $password === "" || $passwordRepeated === ""){ //überprüfen ob etwas eingegeben wurde

        header("Location: ../register.php?noInput=1");

         }elseif (strlen($username) > 15){ //Benutzernamen, die länger als 15 Zeichen sind, werden nicht geduldet.

             header("Location: ../register.php?longUserName=1");

    }elseif (strlen($password) > 50){ //Passwörter, die länger als 50 Zeichen sind, werden nicht geduldet.

        header("Location: ../register.php?longPassword=1");

    } else{

        if(Authorization::usernameIsAlreadyRegistered($username) === false){ //Prüfen, ob es den User schon gibt

            Authorization::registerNewUser($username, $password); //User anlegen

            if (Authorization::detectAuthorization($username, $password)) { //User anmelden
                header("Location: ../account.php");
            } else {
                header("Location: ../register.php?error=2"); //Account wurde zwar angelegt, aber User konnte nicht angemeldet werden
            }

        }else{

            header("Location: ../register.php?usernameAlreadyRegistered=1"); //Username schon vergeben
        }

    }

}else{
    header("Location: ../register.php");
}