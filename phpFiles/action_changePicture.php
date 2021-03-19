<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 13.02.2019
 * Time: 17:55
 */

session_start();

require_once("config.inc.php"); // der Code von config.inc.php wir hier hereinkopiert
require_once("dataBase_credentials.php"); // der Code von dataBase_credentials.php wir hier hereinkopiert

define("PICTUREBUFFER_DIR","../profilePictureBuffer/");

if(isset($_POST['button_uploadPicture'])){

    $uploadIsSuccessfull = Picture::checkSuccess();

    if($uploadIsSuccessfull !== true){
        header("Location: ../account.php?uploadFailed=1");
        //Upload fehlgeschlagen
    }else{

        //Bild am Server in den Pufferspeicher-Ordner speichern
        Picture::saveUploadedPictureOnServer($_FILES['uploadedPicture']['tmp_name'], $_SESSION['name']);


        //Checken, ob es eh ein unterstütztes Dateiformat ist
        $pictureFileName = $_FILES['uploadedPicture']['name'];
        $fileExtensionIsAccepted = Picture::checkFileExtension($pictureFileName, $_SESSION['name']);

        if($fileExtensionIsAccepted){

            //Bild verkleinern (einpassen)
            Picture::resizePicture($pictureFileName, $_SESSION['name']);

            // Bild in der Datenbank speichern (den default Avatar überschreiben bzw. das vorherige Bild überschreiben)
            Picture::savePictureIntoDatabase($_SESSION['name']);

            //Bild aus dem Pufferspeicher vom Server löschen
            Picture::deletePictureFromServer(PICTUREBUFFER_DIR . strtolower($_SESSION['name']) . "_profilepicture.png");

            Picture::getPictureFromDatabase($_SESSION['name']);

            header("Location: ../account.php");
            //Alles hat funktioniert

        }else{
            //Bild hat falsche Dateierweiterung
            header("Location: ../account.php?falseFileExtension=1");
        }




    }




}else{
    header("Location: ../account.php");
}


