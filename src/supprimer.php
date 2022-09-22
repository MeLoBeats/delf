<?php
require_once './bootstrap.php';

if (isset($_SESSION['email'])) {
    if (!is_admin()) {
        header('../public/index.php');
    }

    if (set_get('user_id')) {
        if ($_GET['user_id'] !== 'all' && !set_get('type')) {

            try {
                $delete = "DELETE FROM users WHERE user_id ='" . $_GET['user_id'] . "';";
                $sql = db()->prepare($delete);
                $sql->execute();
                if ($sql) {
                    echo "Utilisateur Supprimé !";
?><script>
                        window.location = '../public/admin.php'
                    </script><?php
                            }
                        } catch (\Throwable $th) {
                            echo "Impossible de supprimer l'utilisateur";
                        }
                    } elseif ($_GET['user_id'] === 'all') {
                        $query = "UPDATE users SET form_rempli = 0;";
                        $res = db()->prepare($query);
                        $res->execute();
                        $$success = "Utilisateur bien réinitialisé !";
                        if (!$res) {
                            echo "Erreur lors de la suppression des données";
                        }
                                ?><script>
                window.location = '../public/admin.php'
            </script><?php
                    } elseif (set_get('type')) {
                        try {
                            $update = "UPDATE users SET form_rempli = 0 WHERE users.user_id =" . $_GET['user_id'] . ";";
                            $sql = db()->prepare($update);
                            $sql->execute();
                            if ($sql) {
                        ?><script>
                        window.location = '../public/admin.php'
                    </script><?php
                                echo "Utilisateur Réinitialisé !";
                            }
                        } catch (\Throwable $th) {
                            echo "Impossible de réinitialiser l'utilisateur " . $th;
                        }
                    }
                } elseif (set_get('form_id')) {
                    if ($_GET['form_id'] !== 'all') {

                        try {
                            $delete = "DELETE FROM formulaire WHERE form_id =" . htmlentities(stripcslashes($_GET['form_id'])) . ";";
                            // $update = "UPDATE `users` SET `form_rempli` = '0' WHERE `users`.`id` = ". $_GET['reinit'] . "';";
                            $sql = db()->prepare($delete);
                            $sql->execute();
                            // $sql2 = mysqli_query($conn, $update);
                            if ($sql) {
                                echo "Formulaire Supprimé !";
                                ?><script>
                        window.location = '../public/admin.php'
                    </script><?php
                            }
                        } catch (\Throwable $th) {
                            echo "Impossible de supprimer l'utilisateur" . $th;
                        }
                    } else {
                        $query = "DELETE FROM formulaire;";
                        $res = db()->prepare($query);
                        $res->execute();
                        if (!$res) {
                            $err = "Erreur lors de la suppression des données";
                        }
                                ?><script>
                window.location = '../public/admin.php'
            </script><?php
                    }
                } elseif (set_get('mail_id')) {
                    try {
                        $delete = "DELETE FROM mail WHERE mail_id ='" . $_GET['mail_id'] . "';";
                        $sql = db()->prepare($delete);
                        $sql->execute();
                        if ($sql) {
                            echo "Mail Supprimé !";
                        ?><script>
                    window.location = '../public/admin.php'
                </script><?php
                        }
                    } catch (\Throwable $th) {
                        echo "Impossible de supprimer le mail";
                    }
                } else {
                            ?><script>
            window.location = '../public/index.php'
        </script><?php
                }
            } else {
                    ?><script>
        window.location = '../public/index.php'
    </script><?php
            }

                ?>