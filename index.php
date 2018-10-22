<?php
require_once 'php/bdd/login.php';
@session_start();


try {
    if (!isset($_GET['action']))
        $_GET['action'] = '';
    switch ($_GET['action']) {

//login
        case 'login':
            login($_POST['_mail'], $_POST['_password']);
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

        case 'planning':
            if (isset($_SESSION['id'])){
                require 'planning.php';
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