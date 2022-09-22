<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;





require_once '../config/db.php';

function db() {
    $options = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $host = DB_HOST;
    $db = DB_NAME;
    $charset = "utf8mb4";
    $user = DB_USER;
    $pass = DB_PASS;
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset;";
    try {
         $pdo = new \PDO($dsn, $user, $pass, $options);
         return $pdo;
    } catch (\PDOException $e) {
         throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}


function view(string $fichier = "", array $attribut = []) {
    foreach ($attribut as $key => $value) {
        $$key = $value;
    }
    if($fichier !== "") {
        return require_once __DIR__ . '/../inc/' . $fichier . '.php';
    }
}

function set_post(string $nom): bool {
    return isset($_POST[$nom]) && !empty($_POST[$nom]);
}

function set_get(string $nom): bool {
    return isset($_GET[$nom]) && !empty($_GET[$nom]);
}

function is_same(string $a, string $b): bool {
    return $a === $b;
}

function ent(string $var, $filter = ""): string {
    return stripcslashes($var);
}

function fltr_inp(string $input) {
    return filter_input(INPUT_POST, $input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

function fltr_inp_mail(string $input) {
    return filter_input(INPUT_POST, $input, FILTER_SANITIZE_EMAIL);
}

function passfilter(string $password): bool {
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    if(strlen($password) < 6) {
        $_SESSION['errReg'] = "Votre mot de passe doit faire au moins 6 caractères.";
        return false;
    } elseif(!$uppercase || !$lowercase || !$number ) {
        $_SESSION['errReg'] = "Votre mot de passe doit contenir une majuscule une minuscule et un nombre.";
        return false;
    } else {
        return true;
    }
}

function register_user(string $nom, string $prenom, string $email, string $password) {
    $verif = verifUser($email);
    if($verif) {
            $_SESSION['errReg'] = "Cette adresse mail est déja utilisée.";
            return false;
            die;
    }
    $hahPass = password_hash($password, PASSWORD_BCRYPT);
    $stmt = db()->prepare('INSERT INTO users (nom, prenom, email, password) VALUES (?, ?, ?, ?);');
    $stmt->bindParam(1, $nom);
    $stmt->bindParam(2, $prenom);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $hahPass);
    $stmt->execute();
    if($stmt) {
        // header('../public/index.php');
        setsession($email);
        return true;
    } else {
        return false;
    }
}

function login_user(string $email, string $password) {
    $verif = verifUser($email, $password, 'login');
    if(!$verif) {
            $_SESSION['errLog'] = "Adresse mail ou mot de passe incorrect";
            return false;
            die;
    } else {
        setsession($email);
        return true;
    }
}

function setsession($email) {
    $sess = db()->prepare("SELECT user_id AS id, nom, prenom, email, form_rempli, admin FROM users WHERE email = :email;");
    $sess->bindParam(':email', $email);
    $sess->execute();
    $res = $sess->fetch();
    // var_dump($res['username']);
    $_SESSION['email'] = $res['email'];
    $_SESSION['id'] = $res['id'];
    $_SESSION['nom'] = $res['nom'];
    $_SESSION['prenom'] = $res['prenom'];
    $_SESSION['form_rempli'] = $res['form_rempli'];
    $_SESSION['admin'] = $res['admin'];
}


function verifUser(string $email, string $password = "", string $method = ""): bool {
    if($method == "login") {
        try {
	$password = htmlspecialchars($password);
            $verif = db()->prepare('SELECT email, password from users WHERE email = :email;');
            $verif->bindParam(':email', $email);
            $verif->execute();
            $res = $verif->fetch();
            if($res) {
                if(password_verify($password, $res['password'])) {
                    return true;
                } else {
                    return false;
                }
            }
            return false;
        } catch (\Throwable $th) {
            throw $th;
        }
    } else {

        try {
            $verif = db()->prepare('SELECT email from users WHERE email = :email');
            $verif->bindParam(':email', $email);
            $verif->execute();
            $res = $verif->fetch();
            if($res) {
                return true;
            }
            return false;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

function logout() {
    unset($_SESSION['email']);
    unset($_SESSION['nom']);
    unset($_SESSION['prenom']);
    unset($_SESSION['form_rempli']);
    unset($_SESSION['admin']);
    session_destroy();
    session_unset();
}

function nav_item(string $link, string $name, string $class) {
    if ($_SERVER['SCRIPT_NAME'] === "/delf-v2" . "/public" . "/" .  $link) {
        $class .= ' active';
    }
    return <<<HTML
        <li class="nav-item dropdown">
            <a class="$class" href="$link">$name</a>
        </li>
    HTML;

}

function form_input(string $type, string $name, string $text, bool $required = false, string $mt = "", string $value = "") {
    if(isset($_COOKIE["$name"])) {
        $value = $_COOKIE["$name"];
    }
    if ($required == true) {
        $text .= " <span class='text-danger'>*</span>";
        return <<<HTML
        <div class="form-floating my-2 $mt">
            <input type="$type" class="form-control" value="$value" required id="floatingInput" name="$name">
            <label class="text-muted" for="floatingInput">$text </label>
        </div>
        HTML;
        die();
    }
    
    return <<<HTML
    <div class="form-floating my-2 $mt">
        <input type="$type" class="form-control" value="$value" id="floatingInput" name="$name">
        <label class="text-muted" for="floatingInput">$text </label>
    </div>
    HTML;
}

function input(string $type, string $title, string $name, string $required = "", string $value = "") {
    if($required === "required" && $value !== "") {
        return <<<HTML
            <div class="form-floating my-2">
            <input style="cursor: not-allowed; background: lightgray;" value="$value" type="$type" class="form-control" id="disabledTextInput floatingInput" name="$name" $required>
            <label class="text-muted" for="floatingInput">$title 
            <span class="text text-danger">*</span></label>
            </div>
        HTML;
    } elseif ($required === "required") {
        return <<<HTML
            <div class="form-floating my-2">
            <input value="$value" type="$type" class="form-control" id="disabledTextInput floatingInput" name="$name" $required >
            <label class="text-muted" for="floatingInput">$title
            <span class="text text-danger">*</span></label>
            </label>
            </div>
        HTML;
    } else {
        return <<<HTML
            <div class="form-floating my-2">
            <input value="$value" type="$type" class="form-control" id="disabledTextInput floatingInput" name="$name" $required >
            <label class="text-muted" for="floatingInput">$title</label>
            </div>
        HTML;
    }
 
}

function radio(string $title, array $choix = [], string $name, string $required = "") {
    $query = '
    <div class="form-radio my-2 my-3 d-flex flex-column bd-highlight">';
    if($required === "required") {
        $query .= '<h5 class="text-muted">' . $title . "<span class='text-danger'>*</span>" . '</h5>';
        foreach($choix as $inp) {
            $query .= '
                <div d-flex gap-5>
                <input value="' . $inp . '" class="form-check-input" type="radio" name="' . $name . '" id="'. $inp . '" required">
                <label class="form-check-label" for="' . $inp . '">
                '. $inp . '
                </label> <br />
                </div>';
            }
            $query .= '</div>';
       
    } else {
        foreach($choix as $inp) {
            $query .= '
            <input class="form-check-input" type="radio" name="' . $name . '" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
            '. $inp . '
            </label>
        </div>';
    }
}
return $query;
}

function dashboard_list(string $name, string $link) {
    return <<<HTML
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="$link">
                <span data-feather="home"></span>
                    $name
            </a>
        </li>
        HTML;
}

function is_admin(): bool {
    if(isset($_SESSION['email']) && isset($_SESSION['admin'])) {
        $query = "SELECT admin from users WHERE email = '" . $_SESSION['email'] . "';";
        $res = db()->prepare($query);
        $res->execute();
        $user = $res->fetch();
        if($user['admin'] == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
    
}

function change_limit($err, $success) {
        try {
          $newLimit = htmlentities(stripcslashes($_GET['limit']));
          $formation = htmlentities(stripcslashes($_GET['formation']));
          $query = "UPDATE delf_limite SET delf_lim = $newLimit WHERE formation = '$formation';";
          $res = db()->prepare($query);
          $res->execute();
          return $$success = "La limite a bien été modifée a $newLimit pour le niveau $formation!";
        } catch (\Throwable $th) {
          return $$err = "Un problème est survenu. La limite n'a pas été modifée $th";
        }
}

function envoi_mail(string $to, string $sub = "no", string $msg = "no") {

    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . 'Exception.php';
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . 'SMTP.php';
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'phpmailer' . DIRECTORY_SEPARATOR . 'PHPMailer.php';

    $mail = new PHPMailer(true);
        try {
            $query = "SELECT sujet, message FROM mail WHERE choisi = 1;";
            $res = db()->prepare($query);
            $res->execute();
            $display = $res->fetch();
            if($sub === "no"):
                $sub = $display['sujet'];
            endif;
            if($msg === "no"):
                $msg = $display['message'];
            endif;
        //     // Config
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        //     // SMTP Config
            $mail->isSMTP();
            $mail->Host = "upn.univ-paris13.fr";
            $mail->Port = 25;

        //     // Charset
            $mail->CharSet = "utf-8";

        //     // Destinataire
            $mail->addAddress($to);

        //     // Expediteur
            $mail->setFrom("noreply@univ-paris13.fr");

        //     // Contenu
            $mail->isHTML(true);
            $mail->Subject = $sub;
            $mail->Body = $msg;

        //     // Envoi
            $mail->send();
            return true;
        //     echo "Mail envoyé !";

        } catch (\Throwable $th) {
            echo "Message non envoyé. Erreur: {$th}";
        }
}

function is_logged() {
    if(isset($_SESSION['email']) && isset($_SESSION['form_rempli']) && !empty($_SESSION['email']) && !empty($_SESSION['form_rempli'])) {
        return true;
    } else {
        return false;
    }
}
