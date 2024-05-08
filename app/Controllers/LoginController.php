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

            // Ensure username and password are not empty
            if (empty($username) || empty($password)) { exit("Username required"); }
            // check if username is exists or not
            if (!empty($username)) {
                $user = $this->model->getUserByUsername($username);
                if (empty($user)) { exit('Username does not exist.'); }
            }

            if ($this->model->loginuser($username, $password)) {
                Redirect::to('home');
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