<?php
require_once 'param.php';
function login($_mail, $_password)
{
    //password hash check
    $result = get_password($_mail);
    $isPasswordCorrect = password_verify($_password, $result['user_pass']);
    if ($isPasswordCorrect) {
        @session_start();
        $_SESSION['id'] = $result['user_id'];
        $_SESSION['mail'] = $result['user_mail'];
    } else {
        echo 'Mauvais identifiant ou mot de passe !';
        require 'login_view.php';
    }
}


function get_password($mail)
{
    $db=dbConnect();
    $req="SELECT user_id, user_mail, user_pass FROM user WHERE user_mail LIKE '".$mail."%'; ";
    $result=$db->query($req);
    $post=$result->fetch_assoc();
    $db->close();
    return $post;
}



function authErr()
{
    session_destroy();
    echo 'Veuillez vous identifier';
    require 'login_view.php';
}
