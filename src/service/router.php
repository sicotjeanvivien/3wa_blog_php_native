<?php

require_once dirname(__DIR__) . "/Controller/HomeController.php";
require_once dirname(__DIR__) . "/Controller/ContactController.php";


/**
 * Constant stockant le routing de l'application, si on veut rajouter une url c'est ici
 */
const ROUTING = [
    "home" => [
        "controller" => "HomeController",
        "action" => "index"
    ],
    "contact" => [
        "controller" => "ContactController",
        "action" => "index"
    ]
];

/**
 * function vérifiant l'existence d'une page avant d'instancier le bon controleur définie dans ROUTING
 */
function getRouteFromUrl():void
{
    $path = ROUTING["home"];
    if (isset($_GET["page"]) && isset(ROUTING[$_GET["page"]])) {
        $path =   ROUTING[$_GET["page"]];
    }
    
    $controller = new $path['controller'];
    $controller->{$path['action']}();
}
