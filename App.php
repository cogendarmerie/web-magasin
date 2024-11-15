<?php
require_once '../autoload.php';
class App
{
    private $routes;

    public function __construct()
    {
        // Charger les routes
        $this->loadRoutes();
    }

    /**
     * Charger les routes à partir du fichier YAML
     * @return void
     * @throws Exception Si le fichier YAML n'est pas trouvé ou si le contenu est invalide
     */
    private function loadRoutes(): void
    {
        $filePath = __DIR__ . '/config/routes.yaml';
        if (!file_exists($filePath)) {
            throw new Exception("Le fichier de routes YAML n'a pas été trouvé.");
        }

        $yaml = file_get_contents($filePath);
        if ($yaml === false) {
            throw new Exception("Impossible de lire le fichier de routes YAML.");
        }

        $routes = Spyc::YAMLLoadString($yaml);
        if (!isset($routes['routes'])) {
            throw new Exception("Le fichier de routes YAML est invalide.");
        }

        $this->routes = $routes['routes'];
    }

    /**
     * Obtenir le contrôleur et la méthode correspondant à l'URI
     * @param string $uri
     * @return void
     * @throws Exception Si le contrôleur ou la méthode n'est pas trouvé
     */
    private function getController(string $uri): void
    {
        foreach ($this->routes as $route) {
            if ($route['path'] === $uri) {
                list($controller, $method) = explode('@', $route['controller']);
                $controllerClass = "Controllers\\" . $controller;

                if (!class_exists($controllerClass)) {
                    throw new Exception("Le contrôleur $controllerClass n'a pas été trouvé.");
                }

                $controllerInstance = new $controllerClass();
                if (!method_exists($controllerInstance, $method)) {
                    throw new Exception("La méthode $method n'a pas été trouvée dans le contrôleur $controllerClass.");
                }

                $controllerInstance->$method();
                return;
            }
        }

        // Si aucune route ne correspond, afficher une erreur 404
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }

    /**
     * Lancer l'application
     * @return void
     */
    public function run(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->getController($uri);
    }
}