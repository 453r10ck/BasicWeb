<?php

class Controller
{
    protected $model;
    protected $model2;

    public function loadModel($model)
    {
        require_once APP_ROOT . 'Models/' . $model . '.php';
        return new $model; 
    }

    public function render($view_name, array $datas = [])
    {
        $filename = '/var/www/basicweb/src/views/'.$view_name.'.view.php';
        if (file_exists($filename))
        {
            require $filename;
            return $datas;
        } else {
            http_response_code(404);
        }
    }
}
// call_user_func_array([Controllername,method],[parameters])