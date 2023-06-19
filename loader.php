<?php

use app\Auth;
use app\Database;

ob_start();
session_start();

spl_autoload_register(function($class_name) {
    include $class_name . '.php';
});

$db = new Database; // this will make a instance of Databse and we can use it every where include this file
$auth = new Auth;