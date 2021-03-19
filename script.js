"use strict";

let globalVariables = {
    mobileMenuIsHidden: true,
    mobileMenu: document.getElementById("s-mobileMenu"),
    burgerMenuImage: document.getElementById("s-burgerMenuImage"),
    doubleMenuContainer: document.getElementById("s-doubleMenuContainer"),
    passwordInputContainer: document.querySelectorAll(".login-c-pwdInputContainer"),
    accountSettingsContainer: document.querySelectorAll(".account-box-child-containers")
};

function displayMobileMenu(){ // zeigt das mobile Menü

    if (globalVariables.mobileMenuIsHidden){

        globalVariables.mobileMenu.style.height = "100vh";
        changeImageTo("arrow");

    }else{
        globalVariables.mobileMenu.style.height = "0";
        changeImageTo("burger");
       // setTimeout(triggerLeftMenu, 200);
    }
    globalVariables.mobileMenuIsHidden = !globalVariables.mobileMenuIsHidden;
}

function hideMobileMenu(){ // versteckt das mobile Menü
    globalVariables.mobileMenu.style.height = "0";
    changeImageTo("burger");
    // setTimeout(triggerLeftMenu, 200);
    globalVariables.mobileMenuIsHidden = true;
}

function changeImageTo(name){//ändert das Burgermenü-Bild

    globalVariables.burgerMenuImage.removeAttribute("src");

    if(name === "arrow"){
        globalVariables.burgerMenuImage.setAttribute("src", "images/shared_images/arrow_down.svg");
    }else{
        globalVariables.burgerMenuImage.setAttribute("src", "images/shared_images/burgermenu.svg");

    }

}


//Passwort Show Funktion
globalVariables.passwordInputContainer.forEach(function(element) {
   showPasswords(element);
});

function showPasswords(passwordInputContainer){
    const eyeImage = passwordInputContainer.getElementsByTagName('img')[0];
    const passwordInput = passwordInputContainer.getElementsByTagName('input')[0];

    eyeImage.addEventListener('mousedown', function(){
        passwordInput.setAttribute('type', 'text');
        this.setAttribute('src', 'images/login/visibility_on.svg');
    });

    eyeImage.addEventListener('mouseup', function(){
        passwordInput.setAttribute('type', 'password');
        this.setAttribute('src', 'images/login/visibility_off.svg');
    });

    eyeImage.addEventListener('mouseleave', function(){
        passwordInput.setAttribute('type', 'password');
        this.setAttribute('src', 'images/login/visibility_off.svg');
    });

}


//Aufklapp-Funktion auf der Account-Seite
globalVariables.accountSettingsContainer.forEach(function(element) {
    openMenus(element);
});

function openMenus(accountSettingsContainer){

    const button = accountSettingsContainer.getElementsByClassName('account-change-button')[0];
    const buttonValue = button.innerHTML;
    const hiddenSettings = accountSettingsContainer.getElementsByClassName('account-hiddenSettings')[0];
    let isHidden = true;

    button.addEventListener('click', function(){

        if (isHidden){
            hiddenSettings.style.height = "130px";
            button.innerHTML = "Abbrechen";
        }else{
            hiddenSettings.style.height = "3px";
            button.innerHTML = buttonValue;
        }
        isHidden = !isHidden;
    });

}