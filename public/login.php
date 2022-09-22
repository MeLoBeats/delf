<?php
require_once '../src/bootstrap.php';
view('header', ['title' => 'Connexion']);

if(isset($_SESSION['email'])) {
  header('location: index.php');
}

?>

<form method="POST" action="../src/login.php" class="mt-4">
    <h1 class="h3 mb-3 fw-normal">Connectez-vous</h1>
    <span class="text-danger">*</span><span class="text-muted"> Obligatoire</span>
    <?php if (isset($_SESSION['errLog'])): ?>
      <div class="alert alert-danger mt-3" role="alert">
          <?= $_SESSION['errLog'] ?>
      </div>
      <?php endif ?>
    <?php 
    echo form_input('email', 'email', 'Adresse mail', true);
    echo form_input('password', 'password', 'Mot de passe', true);
    ?>

    <div class="checkbox my-3">
      <label>
        <input type="checkbox" value="remember-me"> Se souvenir de moi
      </label>
    </div>
    <a href="register.php" class="me-2 mb-4">Je n'ai pas de compte ? Je m'inscris !</a>
    <input name="connexion" class="w-100 btn btn-lg mt-2 btn-primary" type="submit" value="Se connecter">
  </form>




<?php view('footer');?>
