<?php
require_once 'php/bdd/login.php';
@session_start();
/*$password='Test_sosinf75';
$hashedPassword=password_hash($password,PASSWORD_DEFAULT);
print $password;
print $hashedPassword;*/




try {
    if (!isset($_GET['action']))
        $_GET['action'] = '';
    switch ($_GET['action']) {

//login
        case 'login':
            login($_POST['_username'], $_POST['_password']);
            if (isset($_SESSION['id'])) {
                header("Location:index.php?action=patients");
            }else{
                authErr();
            }
            break;

//vue patients
        case 'patients':
            if (isset($_SESSION['id'])){
                require 'patients.php';
            }else{
                authErr();
            }
            break;

//logout
        case 'logout':
            session_destroy();
            require 'login_view.php';
            break;

        default:
            require 'login_view.php';
    }
}catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}