<?php
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'models/autoload.php';
require_once 'models/connexion.php';
require_once 'models/characterModel.php';
require_once 'models/classModel.php';
require_once 'models/ItemModel.php';
require_once 'models/fight/MonsterModel.php';

session_start();

class Router
{
    private $routes = [];
    private $prefix;

    public function __construct($prefix = '')
    {
        $this->prefix = trim($prefix, '/');
    }

    public function addRoute($uri, $controllerMethod)
    {
        $this->routes[trim($uri, '/')] = $controllerMethod;
    }

    public function route($url)
    {
        // Enlève le préfixe du début de l'URL
        if ($this->prefix && strpos($url, $this->prefix) === 0) {
            $url = substr($url, strlen($this->prefix) + 1);
        }

        // Enlève les barres obliques en trop
        $url = trim($url, '/');

        // Vérification de la correspondance de l'URL à une route définie
        foreach ($this->routes as $route => $controllerMethod) {
            // Vérifie si l'URL correspond à une route avec des paramètres
            $routeParts = explode('/', $route);
            $urlParts = explode('/', $url);

            // Si le nombre de segments correspond
            if (count($routeParts) === count($urlParts)) {
                // Vérification de chaque segment
                $params = [];
                $isMatch = true;
                foreach ($routeParts as $index => $part) {
                    if (preg_match('/^{\w+}$/', $part)) {
                        // Capture les paramètres
                        $params[] = $urlParts[$index];
                    } elseif ($part !== $urlParts[$index]) {
                        $isMatch = false;
                        break;
                    }
                }

                if ($isMatch) {
                    // Extraction du nom du contrôleur et de la méthode
                    list($controllerName, $methodName) = explode('@', $controllerMethod);

                    // Instanciation du contrôleur et appel de la méthode avec les paramètres
                    $controller = new $controllerName();
                    call_user_func_array([$controller, $methodName], $params);
                    return;
                }
            }
        }

        // Si aucune route n'a été trouvée, gérer l'erreur 404
        require_once 'views/404.php';
    }
}

// Instantiation du routeur - using a more robust approach
$basePath = '/DungeonXplorer'; 
$currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$cleanUri = str_replace($basePath, '', $currentUri);

$_SESSION["basepath"] = $basePath;

$router = new Router();

// Ajout des routes
$router->addRoute('', 'HomeController@index');
$router->addRoute('chapter/{id}', 'ChapterController@show');

$router->addRoute('account', 'AccountController@index');
$router->addRoute('account/signIn', 'AccountController@signIn');
$router->addRoute('account/signUp', 'AccountController@signUp');
$router->addRoute('account/logout', 'AccountController@logout');

$router->addRoute('character', 'CharacterController@index');
$router->addRoute('character/create', 'CharacterController@create');
$router->addRoute('character/{id}', 'CharacterController@show');

// debug purposes
/*
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "currentUri: " . $currentUri . "<br>";
echo "cleanUri: " . $cleanUri . "<br>";
*/

// Appel de la méthode route
require_once __DIR__.'/views/objects/header.php';
$router->route(trim($cleanUri, '/'));
require_once __DIR__.'/views/objects/footer.php';
