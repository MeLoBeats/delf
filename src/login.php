<?php
require_once 'bootstrap.php';
$_SESSION['test'] = "a";
if (set_post('email') && set_post('password')) {
    $email = ent($_POST['email']);
    // setcookie('email', $email, time() + 180, '/' . 'public/login.php', "", false, false);
    $password = ent($_POST['password']);

    try {
        $logUser = login_user($email, htmlspecialchars($password));
        if ($logUser) {
            $_SESSION['errLog'] = "";
?><script>
                window.location = '../public/index.php'
            </script><?php
                    } ?><script>
            window.location = '../public/login.php'
        </script><?php
                } catch (\Throwable $th) {
                    $_SESSION['errLog'] = "Une erreur est survenue.";
                    // var_dump($_SESSION);
                    ?><script>
            window.location = '../public/login.php'
        </script><?php
                    // header('location: ../public/login.php');
                    echo $th;
                }
            } else {
                $_SESSION['errLog'] = "Veuillez completer tout les champs";
                header('location: ../public/login.php');
                die();
            }
