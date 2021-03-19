<?php
session_start();//Session wird aufrecht erhalten

require_once("phpFiles/config.inc.php"); // der Code von config.inc.php wir hier hereinkopiert

require_once("phpFiles/dataBase_credentials.php"); // der Code von dataBase_credentials.php wir hier hereinkopiert
require_once ("phpClasses/Picture.class.php"); //Damit ich auf die Klasse Picture zugreifen kann.
require_once ("phpClasses/Message.class.php"); //Damit ich auf die Klasse Message zugreifen kann.

if(!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] != true){
    header("Location: index.php");
}
?>

<!DOCTYPE HTML>
<html lang="de" class="s-html">

<head>
    <title>Gästebuch - Eintrag hinzufügen</title>
    <meta charset="utf-8">
    <meta name="Content-Language" content="de-at">
    <meta name="Language" content="de-at">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css?v=1.0" media="all">
    <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>

    <script>
        tinymce.init({
            selector: '#entry-textArea'
        });
    </script>

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
                <div class="s-navItem"><a id="chosenMenuItem" href="#">Eintrag hinzufügen</a></div>
            </div>

            <div class="s-navItem s-accountButton">

                <div class="s-accountButtonHolder">
                    <div class="s-accountButtonImageContainer">
                        <div>
                            <img class="s-userImage" src="<?php  echo Picture::getPictureFromDatabase($_SESSION['name'])?>" alt="Ein User" width="50" height="43">
                        </div>
                    </div>

                    <div class="s-accountButtonTextContainer">
                        <div class="s-accountText"><a href="account.php">Account</a></div>
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
                <li><a id="chosenMenuItemMobileMenu" href="#" onclick="hideMobileMenu()">Eintrag hinzufügen</a></li>
                <li><form action="phpFiles/action_logout.php" method="post"><button type="submit" class="logoutButton logoutButton-mobile" name="button_logout">Abmelden</button></form></li>
                <li class="s-mobileMenuAccountContainer">
                    <a href="account.php" onclick="hideMobileMenu()">
                        <img class="s-userImageMobile" src="<?php  echo Picture::getPictureFromDatabase($_SESSION['name'])?>" alt="Ein User" width="50" height="43">
                        <div>Account</div>
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

    <div class="s-content" id="entryBox-Parent">

        <div class="s-pageHeading">
            <h1 class="s-pageTitle">Eintrag hinzufügen</h1>
        </div>


        <form action="phpFiles/action_postMessage.php" method="post" id="postMessageForm">
            <div>
                <label for="entry-textArea"></label>
                <textarea id="entry-textArea" cols="60" rows="10" name="textarea_message"></textarea>
            </div>

            <div class="register-errorBox entry-errorbox">
                <?php if(isset($_GET['noMessage']) && $_GET['noMessage'] == 1) {
                    echo "Sie müssen eine Nachricht eingeben!";
                }?>
            </div>

            <div>
                <button type="submit" class="login-c-loginButton entry-entryPostButton" name="button_postMessage">Eintrag Posten</button>
            </div>
        </form>


        <div class="s-pageHeading">
            <h1 class="s-pageTitle">Meine Einträge</h1>
        </div>


<?php
echo Message::getPrivateMessagesFromDatabase($_SESSION['name']);
?>


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
<script src="jquery-3.3.1.min.js" defer></script>
<script src="ajax.js" defer></script>

</body>

</html>