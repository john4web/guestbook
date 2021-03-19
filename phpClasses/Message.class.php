<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14.02.2019
 * Time: 18:45
 */

require_once("Picture.class.php");

class Message
{

    private static $pdo;

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

    public static function saveMessageInDatabase($message, $username, $dateofmessage)
    {

        self::connectToDatabase();

        $sql = 'INSERT INTO messages (username, dateofmessage, message) VALUES (:username, :dateofmessage, :message)';

        $stmt = self::$pdo->prepare($sql);

        $stmt->bindValue(":username",$username);
        $stmt->bindValue(":dateofmessage",$dateofmessage);
        $stmt->bindValue(":message",$message);
        $stmt->execute();

    }


    public static function formatMessage($message, $username, $dateofmessage):string
    {
        $picture = Picture::getPictureFromDatabase($username);
        $date = mb_substr($dateofmessage, 0, 16);
        $time = mb_substr($dateofmessage, 17, 8);

$htmlOutput =
    "<div class=\"c-entryBox\"><div class=\"c-entryDetails\"><div><img src=\"$picture\" alt=\"Ein Profilbild\" class=\"c-profilePicture\"></div>
    <div class=\"c-userName\">".$username."</div><div class=\"c-date\">".$date."</div><div class=\"c-time\">".$time."</div></div>
    <div class=\"c-entryText\">".$message."</div></div>";

        return $htmlOutput;

    }


    public static function getAllMessagesFromDatabase():string
    {

        self::connectToDatabase();

        $sql = 'SELECT * FROM messages';
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();

        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $outputString = "";

        foreach($array as $entry){

            $outputString .= self::formatMessage($entry["message"], $entry["username"], $entry["dateofmessage"]);

        }

        return $outputString;

    }



    public static function getPrivateMessagesFromDatabase($username):string
    {
        self::connectToDatabase();

        $sql = 'SELECT * FROM messages WHERE (username = :username)';
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(":username",$username);
        $stmt->execute();

        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $outputString = "";

        foreach($array as $entry){

           $outputString .= self::formatMessage($entry["message"], $entry["username"], $entry["dateofmessage"]);

        }

        return $outputString;

    }






























}