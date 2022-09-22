<?php
require_once './bootstrap.php';

if(set_post('nom') && set_post('prenom') && set_post('email') && set_post('password') && set_post('cf_password')) {
    $nom = ent($_POST['nom']);
    setcookie('nom', $nom, time() + 180, '/public/register.php', "", false, false);
    $prenom = ent($_POST['prenom']);
    setcookie('prenom', $prenom, time() + 180, '/' . 'public/register.php', "", false, false);
    $email = ent($_POST['email']);
    setcookie('email', $email, time() + 180, '/' . 'public/register.php', "", false, false);
    $password = htmlspecialchars(ent($_POST['password']));
    if(!passfilter($password)) {
        header('location: ../public/register.php');
        die();
    }
    $cfPassword = ent($_POST['cf_password']);
    if(!is_same($password, $cfPassword)) {
        $_SESSION['errReg'] = "Vos mots de passe ne correspondent pas.";
        header('location: ../public/register.php');
        die();
    }
    $hashpassword = hash('sha256', $password);
    $code = $hashpassword;
    try {
        $registerUser = register_user($nom, $prenom, $email, $password);
        if($registerUser) {
            $_SESSION['errReg'] = "";
            header('location: ../public/register.php');
        }
        header('location: ../public/register.php');
    } catch (\Throwable $th) {
        $_SESSION['errReg'] = "Une erreur est survenue.";
        header('location: ../public/register.php');
        echo $th;
    }
} else {
    $_SESSION['errReg'] = "Veuillez completer tout les champs";
    header('location: ../public/register.php');
    die();
}