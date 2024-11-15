<?php
// Fichier routeur
require_once '../autoload.php';
require_once '../vendor/autoload.php';

define('ROOT', dirname(__DIR__));

try
{
    $app = new App();
    $app->run();
}
catch (Exception $e)
{
    header("HTTP/1.0 500 Internal Server Error");
    echo "Erreur interne du serveur : " . $e->getMessage();
}