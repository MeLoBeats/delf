<?php
require_once '../src/bootstrap.php';
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$mail = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$form_rempli = isset($_SESSION['form_rempli']) ? $_SESSION['form_rempli'] : null;
view('header', ['title' => 'Accueil']);
// if(!isset($_SESSION['user']) or !isset($_SESSION['email'])) {
//     header('location: register.php');
// }
if(isset($mail)) {
    if(isset($form_rempli) && $form_rempli == 1) {
    ?>
    <div class="starter-template">
        <div class="alert alert-success mt-3" role="alert">
          Merci <?= $_SESSION['prenom'] ?> d'avoir rempli votre candidature.
        </div>
      </div> <?php
  } else { ?>
      <div class="starter-template">
        <div class="alert alert-warning mt-3" role="alert">
          Bienvenue <?= $_SESSION['prenom'] ?> ! <a class="alert-link" href="form.php">Cliquez ici</a> pour accéder au formulaire.
        </div>
      </div>
<?php }
} else {
  ?>
      <div class="starter-template">
        <div class="alert alert-danger mt-3" role="alert">
          Veuillez-<a class="alert-link" href="login.php">vous connecter</a> pour accéder au formulaire.
        </div>
      </div>
      
<?php } 
view('footer');
?>
