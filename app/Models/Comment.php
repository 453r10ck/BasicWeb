<?php

class Comment extends Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getPostComments($post_id) 
    {
        $comments = $this->_db->query('SELECT c.id as comment_id, c.content as comment, c.updated_at as updated_at, u.id as user FROM comments c JOIN users u ON c.user_id = u.id JOIN posts p ON c.post_id = p.id WHERE p.id = ?', [$post_id]);
        return $comments;
    }

    public function addComment($user_id, $post_id, $content) 
    {
        $query = $this->_db->query('INSERT INTO comments (user_id, post_id, content) VALUES (?,?,?)', [$user_id, $post_id, $content]);
        return true;
    }
}