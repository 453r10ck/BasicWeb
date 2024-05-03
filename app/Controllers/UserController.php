<?php

class UserController extends Controller
{
    private $user_id;

    public function __construct()
    {
        $this->model = $this->loadModel('User');
    }

    public function profile($user_id)
    {
        $this->user_id = $user_id[0];
        Request::method('GET', function() {
            $user = $this->model->getUser($this->user_id);

            if ($user) {
                if ($this->isYourself($this->user_id)) {
                    $user['isYourself'] = true;
                    $this->render('user/profile', $user);
                } else {
                    http_response_code(404);
                }
            } else {
                http_response_code(404);
            }
        });
    }

    public function edit($param) 
    {
        $this->user_id = $param[0];

        Request::method('GET', function() {
            $user = $this->model->getUser($this->user_id);
            if ($this->isYourself($this->user_id)) {
                $this->render('user/edit', $user);
            } else {
                http_response_code(404);
            }
        });

        Request::method('POST', function() {
            $other_users = $this->model->getAllUser();
            $username_list = [];
            $email_list = [];

            foreach ($other_users as $user) {
                array_push($username_list, $user['username']);
                array_push($email_list, $user['email']);
            }

            if (empty($_POST['username'])) {
                exit('Username must be not empty');
            }

            if (empty($_POST['email'])) {
                exit('Email must be not empty');
            }

            $user = $this->model->getUser($this->user_id);
            if ($_POST['username'] != $user['username']) {
                if (in_array($_POST['username'],$username_list)) {
                    exit('Username is already existed');
                }
            }

            if ($_POST['email'] != $user['email']) {
                if (in_array($_POST['email'],$email_list)) {
                    exit('Email is already existed');
                }
            }


            if ($this->isYourself($this->user_id)) {
                // edit user
                $this->model->editUser($user['id'], $_POST['username'], $_POST['email'], $_POST['phone'], $_POST['address']);
                $_SESSION['username'] = $_POST['username'];

                Redirect::to('user/profile/' . $user['id']);
            } else {
                http_response_code(404);
            }
        });
    }

    public function change_password($user_id)
    {
        $this->user_id = $user_id[0];

        Request::method('GET', function() {
            if ($this->isYourself($this->user_id)) {
                $user = $this->model->getuser($this->user_id);
                $this->render('user/change_password', $user);
            } else {
                Redirect::to('login');
            }
        });

        Request::method('POST', function() {
            if ($this->isYourself($this->user_id)) {
                $user = $this->model->getuser($this->user_id);

                if (empty($_POST['current_password']) || !isset($_POST['current_password'])) {
                    exit('Please enter your current password');
                }

                if (empty($_POST['password1']) || !isset($_POST['password1'])) {
                    exit('Missing parameters');
                }

                if (empty($_POST['password2']) || !isset($_POST['password2'])) {
                    exit('Missing parameters');
                }

                // If the form is fulfilled
                if (sha1($_POST['current_password']) != $user['password']) {
                    exit('Current password is not correct!');
                }

                if ($_POST['password1'] == $_POST['password2']) {
                    $this->model->updatePassword($user['id'], sha1($_POST['password1']));

                    Redirect::to('user/logout');
                } else {
                    exit('Two new password do not match!');
                }
            } else {
                Redirect::to('login');
            }
        });
    }

    public function logout()
    {
        Request::method('GET', function() {
            $result = $this->model->logout();
            if ($result) {
                Redirect::to('home');
            } else {
                exit('Failure');
            }
        });
    }

    public function delete($param)
    {
        $user_id = $param[0];
        if ($this->isYourself($user_id)) {
            $this->model->deleteUser($user_id);
            Redirect::to('admin');
        } else {
            http_response_code(404);
        }
    }

    public function upgrade($param) {
        $user_id = $param[0];

        // show upgrade information
        Request::method('GET', function() {
            if ($this->isLoggedIn()) {
                if ($_SESSION['role'] == 2) {
                    $this->render('user/upgrade');
                } else {
                    Redirect::to('home');
                }
            } else {
                Redirect::to('login/login');
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

    private function isYourself($user_id) 
    {
        if($this->isLoggedIn()) {
            if ($_SESSION['user_id'] != $user_id && $_SESSION['role'] != 1) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}