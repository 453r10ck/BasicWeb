<?php

class Request
{
    public static function method($type = 'GET', $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] === $type) {
            $callback();
        }
    }
}