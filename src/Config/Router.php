<?php
namespace App\Config;

final class Router {
    private static ?Router $instance = null;

    private array $routes = [
        'security/login'  => ['controller' => 'SecurityController', 'action' => 'login'],
        'security/logout' => ['controller' => 'SecurityController', 'action' => 'logout'],

        'wallet/create'   => ['controller' => 'WalletController', 'action' => 'create'],
        'wallet/deposit'  => ['controller' => 'WalletController', 'action' => 'deposit'],
        'wallet/withdraw' => ['controller' => 'WalletController', 'action' => 'withdraw'],
        'wallet/list'     => ['controller' => 'WalletController', 'action' => 'list'],
        'wallet/transactions' => ['controller' => 'WalletController', 'action' => 'transactions'],
    ];

    private array $protected = [
    ];

    private function __construct() {}

    public static function getInstance(): Router {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    public function resolve(string $uri): void {
        $path = ltrim(parse_url($uri, PHP_URL_PATH), '/');

        if ($path === '') {
            $path = 'wallet/list'; 
        }

        if (!array_key_exists($path, $this->routes)) {
            http_response_code(404);
            echo "Page Not Found";
            return;
        }

        if (array_key_exists($path, $this->protected)) {
            $requiredRole = $this->protected[$path];

            if (!Session::isConnected()) {
                header("location:/security/login");
                exit;
            }

            $user = Session::getUser();
            if ($user->getRole() !== $requiredRole) {
                http_response_code(403);
                echo "Accès refusé";
                return;
            }
        }

        $route      = $this->routes[$path];
        $controllerClass = "App\\Controller\\" . $route['controller'];
        $action     = $route['action'];

        $controller = new $controllerClass();

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            http_response_code(404);
            echo "Page Not Found";
        }
    }
}
