<?php
require_once '../src/bootstrap.php';
view('header', ['title' => 'Inscription']);
if (isset($_SESSION['email'])) {
?><script>
    window.location = '../public/index.php'
  </script><?php
          }

            ?>


<form class="mt-4" method="POST" action="../src/register.php">
  <h1 class="h3 mb-3 fw-normal">Inscrivez-vous</h1>
  <?php if (isset($_SESSION['errReg'])) : ?>
    <div class="alert alert-danger mt-3" role="alert">
      <?= $_SESSION['errReg'] ?>
    </div>
  <?php endif ?>
  <span class="text-danger">*</span><span class="text-muted"> Obligatoire</span>
  <?php
  echo form_input("text", "nom", "Nom", true, "mt-4");
  echo form_input("text", "prenom", "Prénom", true);
  echo form_input("email", "email", "Adresse mail", true);
  echo form_input("password", "password", "Mot de passe", true);
  echo form_input("password", "cf_password", "Confirmez votre mot de passe", true);
  ?>
  <div class="me-3">
    <a href="login.php" class="me-3">J'ai déjà un compte ? Je me connecte !</a>
  </div>
  <input name="connexion" class="mt-2 w-100 btn btn-lg btn-primary" type="submit" value="S'inscrire">
</form>

<?php
view('footer');
