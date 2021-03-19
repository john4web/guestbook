<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 13.02.2019
 * Time: 17:49
 */

class Picture
{

    private static $pdo;
    const PICTUREBUFFER_DIR = "../profilePictureBuffer/";

    function __construct()
    {    //Konstruktor

    }


    public static function connectToDatabase()
    {
        //Zur Datenbank verbinden
        $dataSourceName ='mysql:host=' . DB_HOST . ';dbname=' . DB_NAME; //Das ist die DSN

        try {
            self::$pdo = new PDO($dataSourceName, DB_USER, DB_PASSWORD); //PDO-Instanz erstellen
        }catch(PDOException $e){
            echo $e;
            echo "Verbindung fehlgeschlagen";
            die(); //Skriptabbruch
        }
    }


    public static function checkSuccess() : bool{

        if($_FILES['uploadedPicture']['error'] === UPLOAD_ERR_OK) {

            return true;
        }

        return false;
    }


    public static function saveUploadedPictureOnServer(string $uploadedPicture, string $username){

        move_uploaded_file($uploadedPicture, self::PICTUREBUFFER_DIR . strtolower($username) . "_" . $_FILES['uploadedPicture']['name']);
    }


    public static function checkFileExtension(String $filename, string $username) : bool{

        $path = pathinfo($filename);
        $extension = strtolower($path['extension']);

        if($extension == "jpg" || $extension == "jpeg"||
            $extension == "png" || $extension == "gif" ||
            $extension == "webp" || $extension == "bmp"){

            return true;
        }

        self::deletePictureFromServer(self::PICTUREBUFFER_DIR . strtolower($username) . "_" . $filename);
        return false;
    }



    public static function resizePicture(String $filename, String $username): void{

        $datastream = file_get_contents(self::PICTUREBUFFER_DIR . strtolower($username) . "_" . $filename);    //Datenstrom vom hochgeladenen Bild erzeugen
        $originalImage = imagecreatefromstring($datastream);   //Je nachdem was es für ein Dateityp ist, wird das Bild geöffnet.


        $targetWidth = 0;
        $targetHeight = 0;


        $originalWidth = imagesx($originalImage);
        $originalHeight = imagesy($originalImage);

        $thumbnailImage = imagecreatetruecolor(80, 80);
        $grey = imagecolorallocate($thumbnailImage, 73, 72, 73);
        imagefilledrectangle($thumbnailImage, 0, 0, 80, 80, $grey);

        $destinationX = 0;
        $destinationY = 0;

        if($originalHeight > $originalWidth){
            $targetHeight = 80;
            $targetWidth = $originalWidth * ($targetHeight / $originalHeight);

            $destinationX = (80 - $targetWidth)/2;

        }elseif ($originalWidth > $originalHeight){
            $targetWidth = 80;
            $targetHeight = $originalHeight * ($targetWidth / $originalWidth);

            $destinationY = (80 - $targetHeight)/2;

        }elseif ($originalWidth == $originalHeight){
            $targetHeight = 80;
            $targetWidth = 80;
        }

        $targetWidth = intval($targetWidth);
        $targetHeight = intval($targetHeight);

        $destinationX = intval($destinationX);
        $destinationY = intval($destinationY);

        imagecopyresampled($thumbnailImage, $originalImage, $destinationX, $destinationY,0,0, $targetWidth, $targetHeight, $originalWidth, $originalHeight);

        self::deletePictureFromServer(self::PICTUREBUFFER_DIR . strtolower($username) . "_" . $filename);

        imagepng($thumbnailImage, self::PICTUREBUFFER_DIR . strtolower($username) . "_profilepicture.png");


    }


    public static function deletePictureFromServer(String $path): void{
        unlink($path);
    }

    public static function savePictureIntoDatabase(String $username): void{

        $fileString = file_get_contents(self::PICTUREBUFFER_DIR . strtolower($username) . "_profilepicture.png");
        $baseImage = base64_encode($fileString);

        self::connectToDatabase();

        $sql = 'REPLACE INTO pictures (username, picture) VALUES (:username,:baseImage)';

        $stmt = self::$pdo->prepare($sql);

        $stmt->bindValue(":username",$username);
        $stmt->bindValue(":baseImage",$baseImage);
        $stmt->execute();

    }

    public static function getPictureFromDatabase($username): string {

        self::connectToDatabase();

        $sql = 'SELECT picture FROM pictures WHERE (username = :username)';
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(":username",$username);
        $stmt->execute();

        $array = $stmt->fetch(PDO::FETCH_ASSOC);

        $pictureBaseData = $array["picture"];

        return "data:image/png;base64, " . $pictureBaseData;

    }



}