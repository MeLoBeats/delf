<?php
require_once '../src/bootstrap.php';
if (!is_logged()) {
    header('location: ../public');
}
$err = '';
$sucess = '';
$reponses = [];
$civilite = (stripcslashes($_POST['civilite']));
$nom = (stripcslashes($_POST['nom']));
$prenom = (stripcslashes($_POST['prenom']));
$email = (stripcslashes($_POST['email']));
$nom_epouse = (stripcslashes($_POST['nom_epouse']));
$birthDate = (stripcslashes($_POST['birthDate']));
$countryBirth = (stripcslashes($_POST['countryBirth']));
$cityBirth = (stripcslashes($_POST['cityBirth']));
$nationalite = (stripcslashes($_POST['nationalite']));
$langueMat = (stripcslashes($_POST['langueMat']));
$numTel = (stripcslashes($_POST['numTel']));
$delfdalf = (stripcslashes($_POST['delfdalf']));
$num_candidat = (stripcslashes($_POST['num_candidat']));
$niveau = (stripcslashes($_POST['niveau2']));
$priseEnCharge = (stripcslashes($_POST['priseEnCharge']));
$ci = (stripcslashes($_FILES['ci']['name']));
$ci_dos = (stripcslashes($_FILES['ci_dos']['name']));
$donnees = (stripcslashes($_POST['donnees']));
if (
    isset($civilite) && !empty($civilite) &&
    isset($birthDate) && !empty($birthDate) &&
    isset($countryBirth) && !empty($countryBirth) &&
    isset($cityBirth) && !empty($cityBirth) &&
    isset($nationalite) && !empty($nationalite) &&
    isset($langueMat) && !empty($langueMat) &&
    isset($numTel) && !empty($numTel) &&
    isset($delfdalf) && !empty($delfdalf) &&
    isset($niveau) && !empty($niveau) &&
    isset($priseEnCharge) && !empty($priseEnCharge) &&
    isset($ci) && !empty($ci) &&
    isset($ci_dos) && !empty($ci_dos) &&
    isset($donnees) && !empty($donnees)
) {
    if ($delfdalf == "Oui" and empty($num_candidat)) {
        $_SESSION['errForm'] = "Veuillez renseigner votre ancien numéro candidat.";
        header('location: ../public/form.php');
        die();
    }
    if (!empty($niveau)) {
        $verifMax = "SELECT COUNT(*) AS count from formulaire WHERE niveau LIKE '$niveau'";
        $res = db()->prepare($verifMax);
        $res->execute();
        $res = $res->fetch();
        try {
            //code...
            if ($niveau === 'DELF A1 (95 €)') {
                $niveauLim = 'A1';
            } elseif ($niveau === 'DELF A2 (115 €)') {
                $niveauLim = 'A2';
            } elseif ($niveau === 'DELF B1 (130 €)') {
                $niveauLim = 'B1';
            } elseif ($niveau === 'DELF B2 (155 €)') {
                $niveauLim = 'B2';
            } elseif ($niveau === 'DALF C1 (195 €)') {
                $niveauLim = 'C1';
            } elseif ($niveau === 'DALF C2 (195 €)') {
                $niveauLim = 'C2';
            }
            $limitQuery = "SELECT delf_lim from delf_limite WHERE formation LIKE '%$niveauLim%'";
            $limitRes = db()->prepare($limitQuery);
            $limitRes->execute();
            $limit = $limitRes->fetch();
            if (intval($res['count']) >= intval($limit['delf_lim'])) {
                $_SESSION['errForm'] = "Désolé. Le quota d'inscription au niveau de formation que vous avez choisi est plein.";
                header('location: ../public/form.php');
                die();
            }
        } catch (\Throwable $th) {
            $_SESSION['errForm'] = "Désolé. Une erreur est survenue. Veuillez réessayer.";
            // header('location: ../public/form.php');
            die;
        }
    }
    $error_messages = array(
        UPLOAD_ERR_OK         => 'There is no error, the file uploaded with success',
        UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload',
    );

    // prints "The uploaded file exceeds the upload_max_filesize directive in php.ini"
    // echo $error_messages[$_FILES['ci']['error']] . "\n";
    // var_dump($_FILES);
    $maxSize = 5000000;
    $validExt = array('.jpg', '.jpeg', '.png', '.pdf');
    $prefixCi = $nom;
    foreach ($_FILES as $files => $file) {
        if ($files == "ci_dos") {
            $prefixCi = $nom . "_dos";
        }
        if ($file['error'] > 0) {
            echo "Une erreur est survenue lors du transfert";
            var_dump($error_messages[$file['error']]);
            $_SESSION['errForm'] = "Désolé. Une erreur est survenue lors du transfert de votre carte d'identité. Veuillez réessayer.";
            header('location: ../public/form.php');
            die;
        }

        $fileSize = $file['size'];
        if ($fileSize > $maxSize) {
            echo "le fichier est trop gros";
            $_SESSION['errForm'] = "Le format de votre carte identité dépasse la taille maximale autorisée.";
            header('location: ../public/form.php');
            die;
        }

        $fileExt = "." . strtolower(substr(strrchr($file['name'], '.'), 1));
        if (!in_array($fileExt, $validExt)) {
            echo "Fichier non valide";
            $_SESSION['errForm'] = "Le format de votre carte identité est invalide.";
            header('location: ../public/form.php');
            die;
        }

        $tmpName = $file['tmp_name'];
        $uniqueName = md5(uniqid(rand(), true));
        $file_onUpload = $prefixCi . "_" . $uniqueName . $fileExt;
        if ($files == "ci") {
            $dirfile = $nom . "_" . $uniqueName;
            $dirTmp = dirname(__DIR__) . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . $dirfile;
            mkdir($dirTmp, 0777, false);
        }
        $fileName = dirname(__DIR__) . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . $dirfile . DIRECTORY_SEPARATOR . $file_onUpload;
        $resultat = move_uploaded_file($tmpName, $fileName);
        // var_dump($resultat);
        // echo $fileName;
        if ($resultat) {
            // echo "Parfait";
        } else {
            // echo "False";
            $_SESSION['errForm'] = "Désolé. Une erreur est survenue lors du transfert de votre carte d'identité. Veuillez réessayer.";
            header('location: ../public/form.php');
            die();
        }
    }
    // echo $dirTmp;
    // var_dump($_FILES['ci']);

    if ($num_candidat == "" || $num_candidat == null) {
        $num_candidat = 0;
    }
    $reponses[] = $civilite;
    $reponses[] = $nom_epouse;
    $reponses[] = $birthDate;
    $reponses[] = $countryBirth;
    $reponses[] = $cityBirth;
    $reponses[] = $nationalite;
    $reponses[] = $langueMat;
    $reponses[] = $numTel;
    $reponses[] = $delfdalf;
    $reponses[] = $niveau;
    $reponses[] = $priseEnCharge;
    $reponses[] = $ci;
    $reponses[] = $donnees;
    $query = "INSERT INTO formulaire (nom, nom_depouse, prenom, date_naissance, ville_naissance, pays_naissance, nationalite, langue_mat, email, num_tel, deja_passer_delf, numero_candidat, niveau, prise_en_charge, carte_identite, user_id) VALUES ('$nom', '$nom_epouse', '$prenom', '$birthDate', '$cityBirth', '$countryBirth', '$nationalite', '$langueMat', '$email', '$numTel', '$delfdalf', '$num_candidat', '$niveau', '$priseEnCharge', '$dirfile'," . $_SESSION['id'] . ");";
    $update = "UPDATE users SET form_rempli = 1 WHERE email = '$email';";
    $res = db()->prepare($query);
    $res->execute();
    // var_dump($conn);
    $res = db()->prepare($update);
    $res->execute();
    // echo implode($reponses);
    if ($priseEnCharge !== "Vous") {
        try {
            envoi_mail($email, "no", "no");
            $_SESSION['form_rempli'] = 1;
            // header("location: ../public/index.php");
        } catch (\Throwable $th) {
            throw $th;
        }
    } else {
        $_SESSION['form_rempli'] = 1;
        echo "Votre inscription a bien été prise en charge ! Redirection vers la page de paiement ...";
        header('location: https://paiement.univ-paris13.fr/sel/');
    }
} else {
    $_SESSION['errForm'] = "Veuillez remplir tout les champs";
    header("location: ../public/form.php");
}
