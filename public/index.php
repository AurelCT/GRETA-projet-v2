<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../app/config.php';
require '../vendor/autoload.php';
session_start();
require '../app/routes.php';

//Récupération de l'URL courante, avec la page home comme page de défaut
$getRoute = $_GET['action'] ?? 'home';

//On vérifie dans nos tableaux de routes si la route existe
if(array_key_exists($getRoute, $routes)){
    //Si la route existe on récupère les informations
    list($controllerName, $actionName) = explode('::', $routes[$getRoute]);
    
    //Appel de l'action sur le controller
    echo(new $controllerName())->$actionName();
}
else {
    echo "404 la page n'existe pas";
}