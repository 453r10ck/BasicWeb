<?php

class Post extends Model 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addPost($author_id, $title, $content, $public, $image) {
        $slug = explode(' ', $title);
        $slug = implode('-', $slug);

        $this->_db->query('INSERT INTO posts (title, user_id, slug, content, published, image) VALUES (?,?,?,?,?,?)', [$title, $author_id, $slug, $content, $public, $image]);
        return true;
    }

    public function getAllPost() 
    {
        $post = $this->_db->query('SELECT p.id as id, title, content, published, u.username as author  FROM posts p JOIN users u ON p.user_id = u.id');
        return $post;
    }

    public function getPublishedPost() 
    {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] == 1) {
                $results = $this->_db->query('SELECT p.id as id, title, content, image, published, u.username as author FROM posts p JOIN users u ON p.user_id = u.id');
            } else {
                $results = $this->_db->query('SELECT p.id as id, title, content, image, published, u.username as author FROM posts p JOIN users u ON p.user_id = u.id WHERE published = ? OR user_id = ?', [true, $_SESSION['user_id']]);
            }
        } else {
            $results = $this->_db->query('SELECT p.id as id, title, content, image, published, u.username as author FROM posts p JOIN users u ON p.user_id = u.id WHERE published = ?', [true]);
        }

        return $results;
    }

    public function singlePost($post_id)
    {
        $post = $this->_db->query('SELECT * FROM posts WHERE id = ?', [$post_id]);

        // print_r($post);
        if ($post) {
            $post = $post[0];
            return $post;
        } else {
            return false;
        }
    }

    public function getAllAuthorPost($user_id)
    {
        $results = $this->_db->query('SELECT * FROM posts WHERE user_id = ?', [$user_id]);
        return $results;
    }

    public function getSearchPost($keyword)
    {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] == 1) {
                $results = $this->_db->query('SELECT p.id as id, title, content, image, published, u.username as author FROM posts p JOIN users u ON p.user_id = u.id AND (content LIKE \'%' . $keyword .'%\' OR title LIKE \'%' . $keyword . '%\')', []);
            } else {
                $results = $this->_db->query('SELECT p.id as id, title, content, image, published, u.username as author FROM posts p JOIN users u ON p.user_id = u.id WHERE (published = ? OR user_id = ?) AND (content LIKE \'%' . $keyword .'%\' OR title LIKE \'%' . $keyword . '%\')', [true, $_SESSION['user_id']]);
            }
        } else {
            $results = $this->_db->query('SELECT p.id as id, title, content, image, published, u.username as author FROM posts p JOIN users u ON p.user_id = u.id WHERE published = ? AND (content LIKE \'%' . $keyword . '%\' OR title LIKE \'%' . $keyword .'%\')', [true]);
        }

        return $results;
    }

    public function editPost($post_id, $title, $content, $public, $image) 
    {
        $new_post = $this->_db->query('UPDATE posts SET title = ?, content = ?, published = ?, image = ? WHERE id = ?', [$title, $content, $public, $image, $post_id]);

        if ($new_post) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePost($postId) 
    {
        $this->_db->query('DELETE FROM posts WHERE id = ?', [$postId]);
        return true;
    }

    public function countPostOfUser() {
        $count = $this->_db->query('SELECT COUNT(1) AS number FROM posts WHERE user_id=?', [$_SESSION['user_id']]);
        return $count[0];
    }

    // Admin
    public function searchPostAdmin($keyword) {
        $result = $this->_db->query('SELECT * FROM posts p JOIN users u ON p.user_id = u.id');
    }
}
