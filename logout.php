<?php

include 'loader.php';

unset($_COOKIE['user']);

session_destroy();

# Set user offline after Logout
$query = "UPDATE users SET status=1 WHERE email='{$_SESSION["user"]}'"; // Status=1 means user is offline!
$db->query($query);

header('Location: /');