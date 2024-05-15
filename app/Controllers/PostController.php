<?php

class PostController extends Controller
{
    private $post_id;

    public function __construct() 
    {
        $this->model = $this->loadModel('Post');
    }

    public function detail($param)
    {
        $post_id = $param[0];

        $post = $this->model->singlePost($post_id);

        foreach($comments as $comment) {
            array_push($post['comment'], $comment);
        }

        if (!$post) {
            http_response_code(404);
        } else {
            $author = $post['user_id'];
        }

        // Check if you are logged in or whether you are the author of this post
        if ($this->checkAuthor($author)) {
            $post['isAuthor'] = true;
            $this->render('post/detail', $post);
        } else {
            if ($post['published'] == true) {
                $post['isAuthor'] = false;
                $this->render('post/detail', $post);                
            } else {
                http_response_code(404);
            }
        }
    }

    public function edit($param) 
    {
        $this->post_id = $param[0];
        Request::method('GET', function() {
            $post = $this->model->singlePost($this->post_id); 
            if ($this->checkAuthor($post['user_id'])) {
                $this->render('post/edit', $post);
            } else {
                http_response_code(404);
            }
        });

        Request::method('POST', function() {
            $post = $this->model->singlePost($this->post_id);
            $author = $post['user_id']; 
            if ($this->checkAuthor($author)) {
                $file = new File($_FILES['imageToEdit']);

                if (!empty($file->getFileName())) {
                    unlink(UPLOAD_POST . $post['image']);
                    $file->uploadForPost();
                    $image = $_FILES['imageToEdit']['name'];
                    $result = $this->model->editPost($post['id'], $_POST['title'], $_POST['content'], $_POST['published'], $image);
                    Redirect::to('post/detail/' . $post['id']);
                } else {
                    $image = $post['image'];
                    $result = $this->model->editPost($post['id'], $_POST['title'], $_POST['content'], $_POST['published'], $image);
                    Redirect::to('post/detail/' . $post['id']);
                }
            } else {
                http_response_code(404);
            }
        });
    }

    public function create() 
    {
        Request::method('GET', function() {
            if ($this->isLoggedIn()) {
                if ($_SESSION['role'] == 2) {
                    $count = $this->model->countPostOfUser();
                    $count = $count['number'];

                    if ($count <= 3) {
                        $this->render('post/create');
                    } else {
                        exit('Please upgrade your account to VIP Member to upload more posts!');
                    }
                } else {
                    $this->render('post/create');
                }
            } else {
                $this->render('login/login');
            }
        });

        Request::method('POST', function() {
            if ($this->isLoggedIn()) {
                $file = new File($_FILES['imageToUpload']);

                if (!empty($file->getFileName())) {
                    $file->uploadForPost();
                    unset($_FILES);
                }

                $image = md5($file->getFileName()) . '.jpg';

                if($this->model->addPost($_SESSION['user_id'], $_POST['title'], $_POST['content'], $_POST['published'], $image)) {
                    Redirect::to('home');
                } else {
                    exit('Failed to create new post');
                }
            } else {
                exit('Faled to create post!');
            }
        });
    }

    public function delete($post_id) {
        $post_id = $post_id[0];
        $post = $this->model->singlePost($post_id);
        $author = $post['user_id']; 
        if ($this->checkAuthor($author)) {
            unlink('images/post/' . $post['image']);
            $this->model->deletePost($post_id);
            Redirect::to('home');
        } else {
            Redirect::to('login/login');
        }
    }

    // Middleware
    private function checkAuthor($user_post_id)
    {
        if (!$this->isLoggedIn()) {
            return false;
        } else {
            if ($_SESSION['user_id'] == $user_post_id || $_SESSION['role'] == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    private function isLoggedIn() {
        if (!isset($_SESSION['loggedIn'])) {
            return false;
        } else {
            return true;
        }
    }
}