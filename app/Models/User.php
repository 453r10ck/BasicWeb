<?php

class User extends Model
{
    public function __construct() {
        // connect to database
        parent::__construct();
    }

    public function addUser($username, $password, $email) {
        $password = sha1($password);

        $this->_db->query('INSERT INTO users (username, email, password, created_at, updated_at, role) VALUES (?,?,?,NOW(),NOW(),?)', [$username, $email, $password, 2]);

        return true;
    }

    public function addUserAdmin($username, $password, $email, $address, $role) {
        $password = sha1($password);

        $this->_db->query('INSERT INTO users (username, email, password, address, created_at, updated_at, role) VALUES (?,?,?,?,NOW(),NOW(),?)', [$username, $email, $password, $address, $role]);

        return true;
    }

    public function loginuser($username, $password) {
        $result = $this->_db->query('SELECT * FROM users WHERE username = ?', [$username]);

        if (!$result) {
            return false;
        }

        $result = $result[0];

        $user_password = $result['password'];
        $user_id = $result['id'];

        if (sha1($password) === $user_password) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $result['role'];
            // setcookie('session', uniqid(), time() + 3600, '/', '', false, true);
            session_set_cookie_params(['httponly' => true]);

            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        session_destroy();
        return true;
    }

    public function getUser($user_id)
    {
        $result = $this->_db->query('SELECT * FROM users WHERE id = ?', [$user_id]);

        if ($result) {
            $result = $result[0];
            return $result;
        } else {
            return false;
        }
    }

    public function getUserByUsername($username)
    {
        $result = $this->_db->query('SELECT * FROM users WHERE username = ?', [$username]);

        if ($result) {
            $result = $result[0];
            return $result;
        } else {
            return false;
        }
    }

    public function editUser($id, $username, $email, $phone, $address) {
        $result = $this->_db->query('UPDATE users SET username=?, email=?, phone=?, address=? WHERE id=?', [$username, $email, $phone, $address, $id]);
        return true;
    }

    public function editUserForAdmin($id, $username, $email, $phone, $address, $role) {
        $result = $this->_db->query('UPDATE users SET username=?, email=?, phone=?, address=?, role=? WHERE id=?', [$username, $email, $phone, $address, $role, $id]);
        return true;
    }

    public function getAllUser() 
    {
        $result = $this->_db->query('SELECT * FROM users');
        return $result;
    }

    public function searchUser($keyword)
    {
        $result = $this->_db->query('SELECT * FROM users WHERE username LIKE \'%'. $keyword .'%\'', []);

        return $result;
    } 

    public function updatePassword($user_id, $new_password) {
        $result = $this->_db->query('UPDATE users SET password = ? WHERE id = ?', [$new_password, $user_id]);
        return true;
    }

    public function deleteUser($user_id) {
        $result = $this->_db->query('DELETE FROM users WHERE id = ?', [$user_id]);
        return true;
    }
    // public function validateUser($username, $password) 
    // {
    //     // validate email
    //     if (!Validation::email($email, 5)) {
    //         echo "Ivalid email";
    //         return false;
    //     } else if (!Validation::unique($email, )) {

    //     }
    // }
}