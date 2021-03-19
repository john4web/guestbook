<?php
session_start();//Session wird aufrecht erhalten
require_once("phpFiles/config.inc.php"); // der Code von config.inc.php wir hier hereinkopiert
require_once ("phpClasses/Message.class.php"); //Damit ich auf die Klasse Message zugreifen kann.
require_once("phpFiles/dataBase_credentials.php"); // der Code von dataBase_credentials.php wir hier hereinkopiert
?>

<!DOCTYPE HTML>
<html lang="de" class="s-html">

<head>
    <title>Gästebuch</title>
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

            <?php
            if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true){?>
                <div class="popup-holder">
                    <div class="popup-box">
                        <h1>Bestätigen</h1>
                        <div>Sie sind bereits als <?php echo $_SESSION['name']?> angemeldet. Sie müssen sich abmelden, bevor Sie sich mit anderen Daten wieder anmelden.</div>
                        <div>
                            <form action="phpFiles/action_logout.php" method="post">
                                <button name="button_logout" type="submit">Logout</button>
                                <button name="button_stayLoggedIn" type="submit">Angemeldet bleiben</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <nav id="s-desktopMenu">
                <div class="s-logo"><a href="#">Gästebuch</a></div>

                <div class="s-headerLinkBox">

                </div>

                <div class="s-navItem s-accountButton">

                        <div class="s-accountButtonHolder">
                            <div class="s-accountButtonImageContainer">
                                <div>
                                    <img class="s-userImage" src="images/shared_images/user.png" alt="Ein User" width="50" height="43">
                                </div>
                            </div>

                            <div class="s-accountButtonTextContainer">
                                <div class="s-accountText"><a href="login.php">Account</a></div>
                                <div class="s-loginText"><a href="login.php">Login</a> / <a href="register.php">Registrieren</a></div>
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
                    <li><a href="login.php" onclick="hideMobileMenu()">Login</a></li>
                    <li class="s-mobileProductContainer">
                        <a href="register.php" onclick="hideMobileMenu()">Registrieren</a>
                    </li>
                    <li class="s-mobileMenuAccountContainer">
                        <a href="login.php" onclick="hideMobileMenu()">
                            <img class="s-userImageMobile" src="images/shared_images/user.png" alt="Ein User" width="50" height="43">
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

        <div class="s-content">

            <div class="c-welcomeContainer">
                <div class="c-welcomeContainer-headline">Willkommen im Gästebuch!</div>
                <div class="c-welcomeContainer-subtitle"><?php if(isset($_GET['successfullyLoggedOut']) && $_GET['successfullyLoggedOut'] == 1) {
                        echo "Sie sind jetzt abgemeldet";
                    }elseif(isset($_GET['successfullyDeleted']) && $_GET['successfullyDeleted'] == 1){
                        echo "Account erfolgreich gelöscht";
                    }else{
                        echo "Bitte melden Sie sich an.";
                    }?>
                </div>
            </div>

            <div class="s-pageHeading">
                    <h1 class="s-pageTitle">Aktuelle Einträge</h1>
            </div>

            <div>

                <?php
                echo Message::getAllMessagesFromDatabase();
                ?>

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