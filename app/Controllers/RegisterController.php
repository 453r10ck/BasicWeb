<?php

class RegisterController extends Controller 
{
    public function __Construct()
    {
        $this->model = $this->loadModel('User');
    }

    public function index()
    {
        Request::method('GET', function() {
            if ($this->isLoggedIn()) {
                Redirect::to('home');
            } else {
                $this->render('register/register');
            }
        }); 
    }
    
    public function register() {
        Request::method('POST', function() {
            // Validate
            $user = $this->model->getUserByUsername($_POST['username']);

            if ($user) {
                exit('The username already exists!');
            }

            if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
                exit('Please complete registration form');
            }

            if (strlen($_POST['password']) < 8) { exit("Password must be at least 8 long characters."); }

            if (preg_match('/' . $_POST['username'] . '/i', $_POST['password']) == 1) {
                exit('Password must not contain username');
            }

            $result = $this->model->addUser($_POST['username'], $_POST['password'], $_POST['email']);
            if ($result) {
                echo '<p>Register successfully!<br>You can <a href="'. PUBLIC_ROOT .'">login</a> here</p>';
            } else {
                exit('Failed to rgister!');
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