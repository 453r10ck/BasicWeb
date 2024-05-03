<?php

class Database
{
    private static  $_instance;
    private $_host = DBHOST;
    private $_user = DBUSER;
    private $_password = DBPASS;
    private $_dbname = DBNAME;

    private $_pdo, $_query, $_results, $_error;

    private function __construct()
    {
        $dsn = 'mysql:host=' . $this->_host . ';dbname=' . $this->_dbname;

        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => FALSE,
            PDO::ATTR_PERSISTENT => TRUE
        );

        try {
            $this->_pdo = new PDO($dsn, $this->_user, $this->_password, $options);
        } catch (Exception $exception) {
            http_response_code(404);
        }
    }

    public static function instance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new Database();
        }

        return self::$_instance;
    }

    public function query($query, $params = array()) {
		$this->_error = false;
		$this->_results = [];

		$stmt = $this->_pdo->prepare($query);

	    if (!$stmt->execute($params)) {
			$this->_error = true;
            return false;
	    } else {
	    	$this->_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->_results;
	    }
	}

    public function error() {
        return $this->_error;
    }
}