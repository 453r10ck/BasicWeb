<?php

class LoginController extends Controller
{
    private $_errors = array();

    public function __construct()
    {
        $this->model = $this->loadModel('User');
    }


    public function index()
    {
        if ($this->isLoggedIn()) {
            Redirect::to('home');
        }

        Request::method('GET', function() {
            $this->render('login/login');
        });
    }

    public function login() 
    {
        if ($this->isLoggedIn()) {
            Redirect::to('home');
        }

        Request::method('GET', function() {
            $this->render('login/login');
        });

        Request::method('POST', function() {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (empty($username)) { array_push($this->_errors, "Username required"); }
            if (empty($password)) { array_push($this->_errors, "Password required"); }

            if (empty($this->_errors)) {
                if ($this->model->loginuser($username, $password)) {
                    Redirect::to('home');
                } else {
                    exit('Wrong credentials');
                }
            } else {
                exit('Wrong credentials');
            }
        });
    }

    // Middleware
    private function isLoggedIn() {
        if (!isset($_SESSION['loggedIn'])) {
            return false;
        } else {
            return true;
        }
    }
}