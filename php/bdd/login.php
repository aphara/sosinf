<?php
require_once 'param.php';
function login($_username, $_password)
{
    //password hash check
    $result = get_password($_username);
    $isPasswordCorrect = password_verify($_password, $result['user_pass']);
    if ($isPasswordCorrect) {
        @session_start();
        $_SESSION['id'] = $result['user_id'];
        $_SESSION['username'] = $result['user_pseudo'];
    } else {
        echo 'Mauvais identifiant ou mot de passe !';
        require 'login_view.php';
    }
}


function get_password($username)
{
    $db=dbConnect();
    $req="SELECT user_id, user_pseudo, user_pass FROM user WHERE user_pseudo LIKE '".$username."%'; ";
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
