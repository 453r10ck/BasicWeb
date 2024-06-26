<?php

class Validation
{
    public static function email($email, $minlength = 3) {
        if (!filter_var($email, FILTER_SANITIZE_EMAIL) ||   strlen($email) < 3) {
            return false;
        } else {
            return true;
        }
    }

    public static function unique($input, $fieldName, $tableName) {
        $db = Database::instance();
        $result = $db->query('SELECT count(*) AS count FROM ? WHERE ? = ?', [$tableName, $fieldName, $input]);
        return !boolval($result->first()->count());
    }

    public static function text($text, $minLength = 1, $maxLength = 500) {
        if (strlen($text) < $minLength || strlen($text) > $maxLength) {
            return false;
        } else return true;
    }

    public static function string($string, $minLength = 1, $maxLength = 32, $uppercase = false, $hasDigit = false) {
        if (self::text($string, $minLength, $maxLength)) {
            if ($uppercase && !(preg_match('/[A-Z]/', $string))) {
                return false;
            } else if ($hasDigit && !(preg_match('/[0-9]/', $string))) {
                return false;
            }
            return false;
        } else return true;
    }

    public function usernameUnique($username) {
        $db = Database::instance();
        $usernames = $db->query('SELECT username FROM users', [$username]);
        if (in_array($username, $usernames)) {
            return false;
        } else {
            return true;
        }
    }
}