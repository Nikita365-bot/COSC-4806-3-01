<?php

class App {

    protected $controller = 'login';
    protected $method = 'index';
    protected $special_url = ['apply'];
    protected $params = [];

    public function __construct() {
        if (isset($_SESSION['auth']) == 1) {
            //$this->method = 'index';
            $this->controller = 'home';
        } 
        $url = $this->parseUrl();

        // Fix: avoid undefined index error
        if (isset($url[1]) && file_exists('app/controllers/' . $url[1] . '.php')) {
            $this->controller = $url[1];
            $_SESSION['controller'] = $this->controller;

            if (in_array($this->controller, $this->special_url)) {
                $this->method = 'index';
            }

            unset($url[1]);
            
        } 

        require_once 'app/controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller;

        // check to see if method is passed
        // check to see if it exists
        if (isset($url[2])) {
            if (method_exists($this->controller, $url[2])) {
                $this->method = $url[2];
                $_SESSION['method'] = $this->method;
                unset($url[2]);
            }
        }

        // This will rebase the params to a new array (starting at 0)
        // if params exist
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);		
    }

    public function parseUrl() {
        $u = "{$_SERVER['REQUEST_URI']}";
        //trims the trailing forward slash (rtrim), sanitizes URL, explode it by forward slash to get elements
        $url = explode('/', filter_var(rtrim($u, '/'), FILTER_SANITIZE_URL));
		unset($url[0]);
		return $url;
    }

}
