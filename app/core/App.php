<?php

class App
{
    private $controller = 'HomeController';
    private $method = 'index';
    private $params = array();

    public function __construct()
    {
        $url = $this->getUrl();

        if (isset($url[0])) {
            if (file_exists(APP_ROOT . 'Controllers/' . ucfirst($url[0]) . 'Controller.php')) {
                $this->controller = ucfirst($url[0]) . 'Controller';
            }
        }

        require_once APP_ROOT . '/Controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if(isset($url[1])) {
			// Check, if method exists inside the controller class
			if(method_exists($this->controller, $url[1])) {
				$this->method = $url[1];
			}
		}

        if (isset($url[2])) {
            $this->params[] = $url[2];
        }

        // echo $this->controller;
        
        call_user_func_array(array($this->controller, $this->method), array($this->params));
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            // trim right slash
            $url = rtrim($_GET['url'], '/');
            // Sanitize url string
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // Convert into array
            $url = explode('/', $url);

            return $url;
        }
    }
}