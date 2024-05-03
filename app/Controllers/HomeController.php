<?php

class HomeController extends Controller
{
    public function __construct() 
    {
        $this->model = $this->loadModel('Post');
    }

    public function index()
    {
        Request::method('GET', function() {
            try {
                $posts = $this->model->getPublishedPost();
                $this->render('home', $posts);
                // print_r($posts);
            } catch (Exception $e) {
                exit($e);
            }
        });
    }

    public function search() {
        Request::method('POST', function() {
            $posts = $this->model->getSearchPost($_POST['search']);

            $this->render('home', $posts);
        });
    }
}
