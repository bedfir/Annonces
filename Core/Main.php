<?php

namespace App\Core;

use App\Controllers\MainController;

/**
 * Routeur principal
 */
class Main
{
    public function start()
    {
        // On démarre la session
        session_start();
        // On retire le "trailing slash" éventuel de l'url
        // On récupère l'adresse
        $uri = $_SERVER['REQUEST_URI'];

        // On vérifie si elle n'est pas vide et si elle se termine par un /
        if (!empty($uri) && $uri != '/' && $uri[-1] === '/') {
            // Dans ce cas on enlève le /
            $uri = substr($uri, 0, -1);

            // On envoie une redirection permanente
            http_response_code(301);

            // On redirige vers l'URL dans /
            header('Location: ' . $uri);
            exit;
        }


        // On gère les paramètres d'URL
        // p=controleur/methode/paramètres
        // On sépare les paramètres dans un tableau

        // On sépare les paramètres et on les met dans le tableau $params
        $params = explode('/', $_GET['p']);


        if ($params[0] != "") {
            // On a au moins 1 paramètre
            // On récupère le nom du contrôleur à instancier
            // On met une majuscule en 1ére lettre, on ajoute le namespace complet avant et on ajoute "Controller" après
            $controller = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';

            // On instancie le contrôleur
            $controller = new $controller();

            // On récupère le 2eme paramètre d'URL
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if (method_exists($controller, $action)) {
                // Si il reste des paramètres on les passe à la méthode
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                http_response_code(404);
                echo "La page recherchée n'existe pas zobi";
            }
        } else {
            // On a pas de paramètres 
            // on instancie le contrôleur par défaut
            $controller = new MainController;

            // On appel la methode index
            $controller->index();
        }
    }
}
