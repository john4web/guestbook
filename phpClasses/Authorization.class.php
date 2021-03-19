<?php
declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: Johannes Gerstbauer
 * Date: 14.10.2018
 * Time: 20:04
 */

require_once("../phpFiles/default_avatar.php");

 class Authorization
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


     public static function detectAuthorization(string $username, string $password) : bool
     {   //Überprüft, ob sich der Benutzer anmelden darf.

         self::connectToDatabase();

         $sql = 'SELECT * FROM userdata WHERE (username = :username)';
         $stmt = self::$pdo->prepare($sql);
         $stmt->bindValue(":username",$username);
         $stmt->execute();

         $array = $stmt->fetchAll(PDO::FETCH_ASSOC);



         if (count($array) === 1){

             $password_hash = $array[0]["password"];
             
             if(password_verify($password, $password_hash)){ //Hash entschlüsseln und vergleichen

                 $_SESSION['isLoggedIn'] = true; //Hier wird die Variable $_SESSION[eingeloggt] neu angelegt.
                 $_SESSION['name'] = $username;  // jene Werte, die in das superglobale Array $_SESSION[] gespeichert werden,
                 $_SESSION['password'] = $password; // werden von Seitenaufruf zu Seitenaufruf "weitergegeben".

                 return true;

             }

         }

         return false;
     }


     public static function usernameIsAlreadyRegistered(string $username): bool{
         //Überprüft, ob es den User schon gibt

         self::connectToDatabase();

         $sql = 'SELECT username FROM userdata WHERE (username = :username)';
         $stmt = self::$pdo->prepare($sql);
         $stmt->bindValue(":username",$username);
         $stmt->execute();

         $array = $stmt->fetchAll(PDO::FETCH_ASSOC);

         if (count($array) === 1){
             return true;
         }

         return false;
     }


     public static function registerNewUser(string $username, string $password){
        //Fügt einen neuen User zur Datenbank hinzu

         $password_hash = password_hash($password, PASSWORD_DEFAULT);  //Passwort als Hash abspeichern


         //Benutzerdaten in Datenbank speichern
         self::connectToDatabase();

         $sql1 = 'INSERT INTO userdata (username, password) VALUES (:username,:password)';

         $stmt1 = self::$pdo->prepare($sql1);

         $stmt1->bindValue(":username",$username);
         $stmt1->bindValue(":password",$password_hash);
         $stmt1->execute();


         //Default Avatar in Datenbank speichern
         self::connectToDatabase();
         $avatar = DEFAULT_AVATAR;

         $sql2 = 'INSERT INTO pictures (username, picture) VALUES (:username,:avatar)';

         $stmt2 = self::$pdo->prepare($sql2);

         $stmt2->bindValue(":username",$username);
         $stmt2->bindValue(":avatar",$avatar);
         $stmt2->execute();

     }

     public static function changeUserName(string $oldUsername, string $newUsername ){

         self::connectToDatabase();

         $sql1 = 'UPDATE userdata SET username = REPLACE(username, :oldusername, :newusername);';

         $stmt1 = self::$pdo->prepare($sql1);

         $stmt1->bindValue(":oldusername",$oldUsername);
         $stmt1->bindValue(":newusername",$newUsername);
         $stmt1->execute();


         self::connectToDatabase();

         $sql2 = 'UPDATE pictures SET username = REPLACE(username, :oldusername, :newusername);';

         $stmt2 = self::$pdo->prepare($sql2);

         $stmt2->bindValue(":oldusername",$oldUsername);
         $stmt2->bindValue(":newusername",$newUsername);
         $stmt2->execute();


         self::connectToDatabase();

         $sql3 = 'UPDATE messages SET username = REPLACE(username, :oldusername, :newusername);';

         $stmt3 = self::$pdo->prepare($sql3);

         $stmt3->bindValue(":oldusername",$oldUsername);
         $stmt3->bindValue(":newusername",$newUsername);
         $stmt3->execute();

     }

     public static function changePassword(string $userName, string $newPassword){

         $newPassword_hash = password_hash($newPassword, PASSWORD_DEFAULT);  //Passwort als Hash abspeichern

         self::connectToDatabase();

         $sql = 'REPLACE INTO userdata (username, password) VALUES (:username,:newpassword)';

         $stmt = self::$pdo->prepare($sql);

         $stmt->bindValue(":username",$userName);
         $stmt->bindValue(":newpassword",$newPassword_hash);
         $stmt->execute();


     }


     public static function deleteUserAccount($username){

         self::connectToDatabase();

         $sql1 = 'DELETE FROM userdata WHERE (username = :username)';

         $stmt1 = self::$pdo->prepare($sql1);

         $stmt1->bindValue(":username",$username);
         $stmt1->execute();


         self::connectToDatabase();

         $sql2 = 'DELETE FROM pictures WHERE (username = :username)';

         $stmt2 = self::$pdo->prepare($sql2);

         $stmt2->bindValue(":username",$username);
         $stmt2->execute();

         self::connectToDatabase();

         $sql3 = 'DELETE FROM messages WHERE (username = :username)';

         $stmt3 = self::$pdo->prepare($sql3);

         $stmt3->bindValue(":username",$username);
         $stmt3->execute();

     }


     public static function destroySession() : void{
         $_SESSION = [];

         if(isset($_COOKIE[session_name()])){
             $params = session_get_cookie_params();
             setcookie(session_name(), "", time() - 43200, $params["path"],
                 $params["domain"], $params["secure"], $params["httponly"]);
         }

         session_destroy();
     }

 }