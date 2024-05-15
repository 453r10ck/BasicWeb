<?php

class Redirect
{
    public static function to($location = null) {
        if ($location) {
            if (is_numeric($location)) {
                switch($location) {
                    case 404:
                        header('Location: ');
                        break;
                    default:
                        break;
                }
            } else {
                header("Content-Security-Policy: default-src 'self';object-src 'none'; style-src 'self'; script-src 'self'; img-src 'self'; base-uri 'none';");
                header('Location: ' . URL . $location);
            }
        }
    }
}