<?php

include 'loader.php';

include 'theme\header.php';

if(isset($_SESSION['user'])) {
    include 'contacts.php';
} else {
    include 'login.php';
}

include 'theme\footer.php';