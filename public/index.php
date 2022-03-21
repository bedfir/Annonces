<?php

// on définit une constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));

use App\Autoloader;
use App\Core\Main;



// On importe l'autoloader
require_once ROOT . '/Autoloader.php';
Autoloader::register();

// On instancie Main (notre routeur)

$app = new Main();

// on demarre l'application

$app->start();
