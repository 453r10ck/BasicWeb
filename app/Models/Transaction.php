<?php

class Transaction extends model
{
    public function __construct() {
        parent::__construct();
    }

    public function addTransaction() {
        $query = $this->_db->query('INSERT INTO transaction (user_id, cash) VALUES (?,?)', []);
    }
}