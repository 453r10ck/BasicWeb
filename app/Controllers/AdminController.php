<?php

class AdminController extends Controller
{
    private $user_id;

    public function __construct()   
    {
        $this->model = $this->loadModel('User');
        $this->model2 = $this->loadModel('Post');
    }

    public function index()
    {
        // print_r($_SESSION);
        // echo $this->isAdmin();
        if ($this->isAdmin()) {
            $results = [];
            $posts = $this->model2->getAllPost();
            $users = $this->model->getAllUser();

            array_push($results, $posts, $users);
            // print_r($results[0]);
            $this->render('admin/admin_panel', $results);
        } else {
            Redirect::to('home');
        }
    }

    public function addUser() 
    {
        Request::method('GET', function() {
            if ($this->isLoggedIn()) {
                if ($_SESSION['role'] == 1) {
                    $this->render('admin/add_user');
                } else {
                    http_response_code(404);
                }
            } else {
                http_response_code(404);
            }
        });

        Request::method('POST', function() {
            if ($this->isLoggedIn()) {
                if ($_SESSION['role'] == 1) {
                    $other_users = $this->model->getAllUser();
                    $username_list = [];
                    $email_list = [];

                    foreach ($other_users as $user) {
                        array_push($username_list, $user['username']);
                        array_push($email_list, $user['email']);
                    }

                    if (in_array($_POST['username'],$username_list)) {
                        exit('Username is already existed');
                    }

                    if (in_array($_POST['email'],$email_list)) {
                        exit('Username is already existed');
                    }

                    if (empty($_POST['password'])) {
                        exit('Please fill password');
                    }

                    $this->model->addUserAdmin($_POST['username'], $_POST['password'], $_POST['email'], $_POST['address'], $_POST['role']);
                    Redirect::to('admin');
                } else {
                    http_response_code(404);
                }
            } else {
                http_response_code(404);
            }
        });
    }

    public function search() {
        Request::method('POST', function() {
            $results = [];
            if ($this->isAdmin()) {
                if (!isset($_POST['searchPost']) && isset($_POST['searchUser'])) {
                    $user = $this->model->searchUser($_POST['searchUser']);
                    $post = $this->model2->getAllPost();
                    array_push($results, $post, $user);
                    $this->render('admin/admin_panel', $results);
                }

                if (isset($_POST['searchPost']) && !isset($_POST['searchUser'])) {
                    $user = $this->model->getAllUser();
                    $post = $this->model2->getSearchPost($_POST['searchPost']);
                    array_push($results, $post, $user);
                    $this->render('admin/admin_panel', $results);
                }

                if (isset($_POST['searchPost']) && isset($_POST['searchUser'])) {
                    $user = $this->model->searchUser($_POST['searchUser']);
                    $post = $this->model2->getSearchPost($_POST['searchPost']);
                    array_push($results, $post, $user);
                    $this->render('admin/admin_panel', $results);
                }
            } else {
                http_response_code(404);
            }
        });
    }

    public function change_password($user_id)
    {
        $this->user_id = $user_id[0];

        Request::method('GET', function() {
            if ($this->isAdmin()) {
                $user = $this->model->getuser($this->user_id);
                $this->render('admin/change_password', $user);
            } else {
                Redirect::to('login');
            }
        });

        Request::method('POST', function() {
            if ($this->isAdmin()) {
                $user = $this->model->getuser($this->user_id);

                if ($_POST['password1'] == $_POST['password2']) {
                    $this->model->updatePassword($user['id'], sha1($_POST['password1']));

                    if ($_SESSION['user_id'] == $this->user_id) {
                        Redirect::to('user/logout');
                    } else {
                        Redirect::to('admin');
                    }
                } else {
                    exit('Two new password do not match!');
                }
            } else {
                Redirect::to('login');
            }
        });
    }

    public function edit_user($param) {
        $this->user_id = $param[0];

        Request::method('GET', function() {
            if ($this->isAdmin()) {
                $user = $this->model->getUser($this->user_id);
                $this->render('admin/edit_user', $user);
            } else {
                Redirect::to('home');
            }
        });

        Request::method('POST', function() {
            $user = $this->model->getUser($this->user_id);
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

            if ($this->isAdmin()) {
                $this->model->editUserForAdmin($user['id'], $_POST['username'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['role']);
                Redirect::to('admin');
            } else {
                Redirect::to('home');
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

    private function isAdmin() 
    {
        if ($this->isLoggedIn()) {
            if ($_SESSION['role'] == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}