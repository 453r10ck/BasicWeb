<?php

class Transaction extends model
{
    public function __construct() {
        parent::__construct();
    }

    public function addTransaction($user_id, $cash) {
        $query = $this->_db->query('INSERT INTO transaction (user_id, cash) VALUES (?,?)', [$user_id, $cash]);
        return true;
    }

    public function transfer($transimitter, $reciever, $cash) {
        $query1 = $this->_db->query('INSERT INTO transaction (user_id, cash) VALUES (?,?)', [$transimitter, $cash]);
        $query2 = $this->_db->query('INSERT INTO transaction (user_id, cash) VALUES (?,?)', [$reciever, $cash]);

        return true;
    }
}