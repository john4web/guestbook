<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14.02.2019
 * Time: 19:26
 */

session_start();

require_once("config.inc.php"); // der Code von config.inc.php wir hier hereinkopiert
require_once("dataBase_credentials.php"); // der Code von dataBase_credentials.php wir hier hereinkopiert
require_once '../htmlpurifier-4.10.0/library/HTMLPurifier.auto.php'; //Damit ich den HTML-Purifier verwenden kann

if(isset($_SESSION['name'])){

    if( isset($_POST['message']) ){

        if($_POST['message'] !== ""){ //Wenn der User etwas eingegeben hat...

            $date = new DateTime();

            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            $message = $purifier->purify($_POST['message']);    //Schützt gegen XSS-Attacken!

            //$message = htmlspecialchars($_POST['message'], ENT_QUOTES|ENT_HTML5); //X-Side-Scripting verhindern
            $username = $_SESSION['name'];
            $dateofmessage = $date->format(DATE_RSS);


            Message::saveMessageInDatabase($message, $username, $dateofmessage);

            $htmlOutput = Message::formatMessage($message, $username, $dateofmessage);

            echo $htmlOutput;
        }

    }else{
        header("Location: ../account.php");
    }

}else{
    header("Location: ../index.php");
}


