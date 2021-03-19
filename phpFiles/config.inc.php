<?php
/**
 * Created by PhpStorm.
 * User: Johannes Gerstbauer
 * Date: 15.10.2018
 * Time: 12:44
 */


spl_autoload_register('autoload'); //Immer wenn ein Objekt instanziert wird, wird autoload() aufgerufen
                                    // und somit die Klasse eingebunden

function autoload($className) {
    require_once '../phpClasses/' . $className . '.class.php';
}



