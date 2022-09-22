<?php
require_once '../src/bootstrap.php';
view('header', ['title' => 'Formulaire']);

if(!isset($_SESSION['email'])) {
    header('location: index.php');
    exit();
}

isset($_SESSION['errForm']) ? $err = $_SESSION['errForm'] : $err = "";
isset($_SESSION['successForm']) ? $success = $_SESSION['successForm'] : $success = ""

// if(isset($_GET['err']) or (isset($_GET['success']))) {
//   if(!isset($_GET['success']) and $_GET['err'] == 1) {
//     $err = "Veuillez remplir tout les champs";
//   } elseif (!isset($_GET['err']) and $_GET['success'] == 1) {
//     $success = "Votre formulaire a bien été pris en compte ! Redirection vers la page d'acceuil ...";
//     header("Refresh: 3; index.php");
//   } elseif(!isset($_GET['success']) and $_GET['err'] == 2) {
//     $err = "Veuillez renseigner votre ancien numéro candidat.";
//   } elseif(!isset($_GET['success']) and $_GET['err'] == 3) {
//     $err = "Désolé. Le quota d'inscription au niveau de formation que vous avez choisi est plein.";
//   } elseif(!isset($_GET['success']) and $_GET['err'] == 4) {
//     $err = "Le format de votre carte identité est invalide.";
//   } elseif(!isset($_GET['success']) and $_GET['err'] == 5) {
//     $err = "Le format de votre carte identité dépasse la taille maximale autorisée.";
//   } elseif(!isset($_GET['success']) and ($_GET['err'] == 6 or $_GET['err'] == 7)) {
//     $err = "Désolé. Une erreur est survenue lors du transfert de votre carte d'identité. Veuillez réessayer.";
//   } elseif(!isset($_GET['success']) and $_GET['err'] == 8) {
//     $err = "Désolé. Une erreur est survenue. Veuillez réessayer.";
//   }
  
// } else {
//   $err = "";
// }
?>



<?php if(isset($_SESSION['form_rempli']) && $_SESSION['form_rempli'] == 1) {
  ?>
  <div class="alert alert-success mt-3" role="alert">
        Vous avez déja rempli le formulaire.
  </div>
<?php } else { ?>
<form enctype="multipart/form-data" class="mt-4" method="POST" action="../src/form.php">
    <h1 class="h3 mb-3 fw-normal">Formulaire d'inscription au DELF-DALF</h1>
    <span class="text-danger">*</span><span class="text-muted"> Obligatoire</span>
    <?php if ($err !== ""): ?>
      <div class="alert alert-danger mt-3" role="alert">
          <?= $err ?>
      </div>
    <?php elseif($success !== "") : ?>
      <div class="alert alert-success mt-3" role="alert">
        <?= $success ?>
      </div>
    <?php endif ?>
    <?php view('form') ?>
  </form>
  <script>
      const radioButtons = document.querySelectorAll('input[name="delfdalf"]')
      const radioButtonsPay = document.querySelectorAll('input[name="priseEncharge"]')
      const oui = document.getElementById('ifOui')
      const non = document.getElementById('ifNon')
      const submit = document.getElementById('submit')
      radioButtons.forEach(radioButton => {
          radioButton.addEventListener('change', (e) => {
              if(e.target.value === 'Oui') {
                oui.style.display = "block"
              } else {
                oui.style.display = "none"
              }
          });
      });
      radioButtonsPay.forEach(radioButton => {
          radioButton.addEventListener('change', (e) => {
              if(e.target.value === "Vous") {
                  submit.addEventLister('click', () => window.location.href = 'https://paiement.univ-paris13.fr/sel/')
              }
          })
      })
  </script>
  <?php } 
  view('footer');
  ?>
