<?php
session_start();//Session wird aufrecht erhalten

require_once("phpFiles/config.inc.php"); // der Code von config.inc.php wir hier hereinkopiert

require_once("phpFiles/dataBase_credentials.php"); // der Code von dataBase_credentials.php wir hier hereinkopiert
require_once ("phpClasses/Picture.class.php"); //Damit ich auf die Klasse Picture zugreifen kann.

if(!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] != true){
    header("Location: index.php");
}
?>

<!DOCTYPE HTML>
<html lang="de" class="s-html">

<head>
    <title>Gästebuch - Mein Account</title>
    <meta charset="utf-8">
    <meta name="Content-Language" content="de-at">
    <meta name="Language" content="de-at">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css?v=1.0" media="all">

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#6ac8d9">
    <meta name="theme-color" content="#6ac8d9">
</head>

<body class="s-body">
<main class="s-main">

    <header class="s-header">
        <nav id="s-desktopMenu">
            <div class="s-logo"><a href="allEntries.php">Gästebuch</a></div>

            <div class="s-headerLinkBox">
                <div class="s-navItem"><a href="allEntries.php">Aktuelle Einträge</a></div>
                <div class="s-navItem"><a href="entry.php">Eintrag hinzufügen</a></div>
            </div>

            <div class="s-navItem s-accountButton">

                <div class="s-accountButtonHolder">
                    <div class="s-accountButtonImageContainer">
                        <div>
                            <img class="s-userImage" src="<?php  echo Picture::getPictureFromDatabase($_SESSION['name'])?>" alt="Ein User" width="50" height="43">
                        </div>
                    </div>

                    <div class="s-accountButtonTextContainer">
                        <div class="s-accountText"><a id="chosenMenuItem" href="#">Account</a></div>
                        <div class="s-loginText">
                            <form action="phpFiles/action_logout.php" method="post"><button type="submit" class="logoutButton" name="button_logout">Abmelden</button></form>
                        </div>
                    </div>
                </div>

            </div>

            <button type="button" id="s-burgerMenuButton" onclick="displayMobileMenu()">
                <img src="images/shared_images/burgermenu.svg" alt="Ein Burgermenü" id="s-burgerMenuImage" width="35" height="35">
            </button>
        </nav>
    </header>

    <nav id="s-mobileMenu">

        <div id="s-doubleMenuContainer">

            <ul>
                <li><a href="allEntries.php" onclick="hideMobileMenu()">Aktuelle Einträge</a></li>
                <li><a href="entry.php" onclick="hideMobileMenu()">Eintrag hinzufügen</a></li>
                <li><form action="phpFiles/action_logout.php" method="post"><button type="submit" class="logoutButton logoutButton-mobile" name="button_logout">Abmelden</button></form></li>
                <li class="s-mobileMenuAccountContainer">
                    <a href="#" onclick="hideMobileMenu()">
                        <img class="s-userImageMobile" src="<?php  echo Picture::getPictureFromDatabase($_SESSION['name'])?>" alt="Ein User" width="50" height="43">
                        <div class="account-is-chosen">Account</div>
                    </a>
                </li>
                <li onclick="hideMobileMenu()" class="s-closingButtonContainer">
                    <div  class="s-closingButton">
                        <img src="images/shared_images/arrow_up.svg" alt="Ein Pfeil" class="s-arrowImage" width="35" height="35">
                    </div>
                </li>
            </ul>

        </div>


    </nav>

    <div class="s-content">

        <div class="s-pageHeading">
            <h1 class="s-pageTitle">Mein Account</h1>
        </div>

    <div class="account-helloContainer"><?php echo 'Hallo ' . $_SESSION['name'] . '!'?></div>

        <div class="account-box">

            <div class="account-box-child-containers">

                <div class="account-picture-box">
                    <div class="account-imageWrapper">
                      <img src="<?php  echo Picture::getPictureFromDatabase($_SESSION['name'])?>" alt="Ein Profilbild" width="80" height="80">
                    </div>

                    <div class="register-errorBox account-errorBox">
                        <?php if(isset($_GET['uploadFailed']) && $_GET['uploadFailed'] == 1) {
                            echo "Upload fehlgeschlagen";
                        }elseif(isset($_GET['falseFileExtension']) && $_GET['falseFileExtension'] == 1) {
                            echo "Falscher Dateityp";
                        } ?>
                    </div>

                    <div>
                        <button class="login-c-loginButton account-buttons account-change-button">Ändern</button>
                    </div>
                </div>

                <div class="account-hiddenSettings">
                        <form action="phpFiles/action_changePicture.php" method="POST" enctype="multipart/form-data" class="account-hiddenSettings-form">
                            <label for="uploadButton">Neues Profilbild auswählen:</label>
                                <input type="file" id="uploadButton" name="uploadedPicture" class="uploadButton" required>
                                <button class="login-c-loginButton account-buttons" type="submit" name="button_uploadPicture">
                                    Profilbild ändern
                                </button>
                        </form>
                </div>

            </div>

            <div class="account-box-child-containers">

                <div class="account-picture-box">
                    <div class="account-imageWrapper">Benutzername</div>

                    <div class="register-errorBox account-errorBox">
                        <?php if(isset($_GET['noInput']) && $_GET['noInput'] == 1) {
                            echo "Alle Felder ausfüllen!";
                        }elseif(isset($_GET['oldUserName']) && $_GET['oldUserName'] == 0) {
                            echo "Alter Benutzername falsch!";
                        }elseif(isset($_GET['longUserName']) && $_GET['longUserName'] == 1) {
                            echo "Neuer Benutzername zu lange!";
                        }elseif(isset($_GET['userNameExists']) && $_GET['userNameExists'] == 1) {
                            echo "Neuer Benutzername schon vergeben!";
                        } ?>
                    </div>

                    <div>
                        <button class="login-c-loginButton account-buttons account-change-button">Ändern</button>
                    </div>
                </div>

                <div class="account-hiddenSettings">
                    <form action="phpFiles/action_changeUsername.php" method="POST" class="account-hiddenSettings-form">
                        <div>
                            <label for="oldUserName" class="login-c-label">Alter Benutzername</label>
                            <input id="oldUserName" class="login-c-input account-pwdInput" type="text" name="oldUsername_changeUsername" required>
                        </div>

                        <div>
                            <label for="newUserName" class="login-c-label">Neuer Benutzername</label>
                            <input id="newUserName" class="login-c-input account-pwdInput" type="text" name="newUsername_changeUsername" required>
                        </div>

                        <input class="login-c-loginButton account-buttons" type="submit" value="Benutzername ändern" name="button_changeUsername">
                    </form>
                </div>

            </div>

            <div class="account-box-child-containers">

                <div class="account-picture-box">
                    <div class="account-imageWrapper">Passwort</div>

                    <div class="register-errorBox account-errorBox">
                        <?php if(isset($_GET['noPasswordInput']) && $_GET['noPasswordInput'] == 1) {
                            echo "Alle Felder ausfüllen!";
                        }elseif(isset($_GET['oldPassword']) && $_GET['oldPassword'] == 0) {
                            echo "Altes Passwort ist falsch!";
                        }elseif(isset($_GET['longPassword']) && $_GET['longPassword'] == 1) {
                            echo "Neues Passwort zu lange!";
                        }?>
                    </div>

                    <div>
                        <button class="login-c-loginButton account-buttons account-change-button">Ändern</button>
                    </div>
                </div>

                <div class="account-hiddenSettings">
                    <form action="phpFiles/action_changePassword.php" method="POST" class="account-hiddenSettings-form">

                        <div class="login-c-pwdInputContainer account-pwdInputContainer">
                            <label for="oldPassword" class="login-c-label">Altes Passwort:</label>
                            <input id="oldPassword" class="login-c-input account-pwdInput" type="password" name="oldPassword_changePassword" required>
                            <img src="images/login/visibility_off.svg" alt="Button zum sichtbar machen des Passworts" class="login-c-visibilityButton" width="20" height="20">
                        </div>

                        <div class="login-c-pwdInputContainer account-pwdInputContainer">
                            <label for="newPassword" class="login-c-label">Neues Passwort:</label>
                            <input id="newPassword" class="login-c-input account-pwdInput" type="password" name="newPassword_changePassword" required>
                            <img src="images/login/visibility_off.svg" alt="Button zum sichtbar machen des Passworts" class="login-c-visibilityButton" width="20" height="20">
                        </div>
                        <input class="login-c-loginButton account-buttons" type="submit" value="Passwort ändern" name="button_changePassword">
                    </form>
                </div>

            </div>


            <div class="account-box-child-containers">

                <div class="account-picture-box account-lastBox">
                    <div>
                        <button class="login-c-loginButton account-buttons account-change-button">Account löschen</button>
                    </div>
                </div>

                <div class="account-hiddenSettings">
                    <form action="phpFiles/action_deleteAccount.php" method="POST" class="account-hiddenSettings-form">
                        <label for="deleteAccountButton">Möchten Sie wirklich Ihren Account löschen?</label>
                        <input id="deleteAccountButton" class="login-c-loginButton account-buttons" type="submit" value="Account dauerhaft löschen" name="button_deleteAccount">
                    </form>
                </div>

            </div>
        </div>

    </div>

    <footer class="s-footer">
        <div class="s-footerContentBox">
            <div><a href="#">Impressum</a></div>
            <div><a href="#">DSGVO</a></div>
            <div><a href="#">Kontakt</a></div>
            <div class="s-socialMediaContainer">
                <div class="s-socialMediaImageContainer">
                    <div><a href="#"><img src="images/shared_images/twitter.svg" alt="Twitter" width="30" height="30"></a></div>
                    <div><a href="#"><img src="images/shared_images/facebook.svg" alt="Facebook" width="30" height="30"></a></div>
                </div>
                <div>Social Media</div>
            </div>
        </div>
    </footer>

</main>
<script src="script.js" defer></script>

</body>

</html>