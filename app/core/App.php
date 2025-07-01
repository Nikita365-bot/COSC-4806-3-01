<?php
class App {
    protected $controller = 'login';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $url = $this->parseUrl();

        if (isset($url[0])) {
            $controller = ucfirst($url[0]);

            if (file_exists('app/controllers/' . $controller . '.php')) {
                require_once 'app/controllers/' . $controller . '.php';
                $this->controller = $controller;
                unset($url[0]);
            }
        } else {
            require_once 'app/controllers/' . $this->controller . '.php';
        }

        $this->controller = new $this->controller;

        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // This method is REQUIRED and must be inside the class
    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
