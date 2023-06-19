<?php

namespace app;

use app\Database;

class Auth {
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    function loginUser($email, $password) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE email=? AND password=?";
        $data = $this->db->query($query, array($email, $password));
        $user = $data->fetch();

        if(!empty($user)) {
            $query = "UPDATE users SET status=2 WHERE email=?"; // status 2 means the user is online
            $this->db->query($query, array($email));

            $_SESSION['user'] = $email;
            $_SESSION['user_id'] = $user['id'];
            $_COOKIE['user'] = $email;
        }

        return $user;
    }

    function register($data) {
        if($this->db->select('users', $data)) {
            return "This email is already registered!";
        } else {

            $image_type = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION)); // get image extention

            if($image_type !== 'jpg' && $image_type !== 'png' && $image_type !== 'gif') {
                die('The file is not type of jpg, png or gif!');
            }

            $upload_path = 'photos/';
            $file_name = time() . '.' . $image_type; // change the name of uploaded file

            move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path . $file_name);

            $data['photo'] = $upload_path . $file_name;

            $query = "INSERT INTO users (photo, first_name, last_name, password, email, status) VALUES(:photo, :first_name, :last_name, :password, :email, :status)";

            return !empty($this->db->query($query, $data)); // if inserrted new user, then return TRUE
            
        }
    }
}