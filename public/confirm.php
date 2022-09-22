<?php
require_once '../src/bootstrap.php';
view('header', ['title' => 'Confirmation']);

if(!isset($_SESSION['email'])) {
    header('location: index.php');
    exit();
  }
  if(!is_admin()) {
    header('location: index.php');
    die;
  }
  if(!set_get('suppr') || !set_get('type')) {
  header('location: index.php');
  exit();
}
?>

<div class="" id="myModal" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="false">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Confirmez votre choix</h5>
                  <button onclick="history.back()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <?php if($_GET['type'] === 'user'): ?>
                <?php if($_GET['suppr'] !== 'all' && !set_get('reinit')): ?>
                  <?= strtoupper('ê') ?>tes-vous sûr(e) de vouloir supprimer cet utilisateur ?
                </div>
                <div class="modal-footer">
                  <button onclick="history.back()" type="" class="btn btn-secondary" >Fermer</button>
                  <a href="../src/supprimer.php?user_id=<?= $_GET['suppr'] ?>" type="button" class="btn btn-danger">Supprimer</a>
                <?php elseif($_GET['suppr'] === 'all') : ?>
                  <?= strtoupper('ê') ?>tes-vous sûr(e) de vouloir réinitialiser <strong>tous</strong> les utilisateurs ?
                  <div class="modal-footer">
                    <button onclick="history.back()" type="" class="btn btn-secondary" >Fermer</button>
                    <a href="../src/supprimer.php?user_id=<?= $_GET['suppr'] ?>" type="button" class="btn btn-warning">Réinitialiser</a>
                    <?php elseif($_GET['suppr'] === 'null' && set_get('reinit')): ?>
                      <?= strtoupper('ê') ?>tes-vous sûr(e) de vouloir réinitialiser cet utilisateur ?
                      <div class="modal-footer">
                        <button onclick="history.back()" type="" class="btn btn-secondary" >Fermer</button>
                        <a href="../src/supprimer.php?user_id=<?= $_GET['reinit']?>&type=reinit" type="button" class="btn btn-warning">Réinitialiser</a>
                    <?php endif ?>
                  <?php elseif($_GET['type'] === "form") : ?>
                    <?php if($_GET['suppr'] !== 'all'): ?>
                  <?= strtoupper('ê') ?>tes-vous sûr(e) de vouloir supprimer cette candidature ?
                </div>
                <div class="modal-footer">
                  <button onclick="history.back()" type="" class="btn btn-secondary" >Fermer</button>
                  <a href="../src/supprimer.php?form_id=<?= $_GET['suppr'] ?>" type="button" class="btn btn-danger">Supprimer</a>
                <?php else : ?>
                  <?= strtoupper('ê') ?>tes-vous sûr(e) de vouloir supprimer <strong>toutes</strong> les candidatures ?
                  <div class="modal-footer">
                    <button onclick="history.back()" type="" class="btn btn-secondary" >Fermer</button>
                    <a href="../src/supprimer.php?form_id=<?= $_GET['suppr'] ?>" type="button" class="btn btn-danger">Supprimer</a>
                  <?php endif ?>
                <?php elseif($_GET['type']==='mail'): ?>
                  <?= strtoupper('ê') ?>tes-vous sûr(e) de vouloir supprimer ce mail ?
                </div>
                <div class="modal-footer">
                  <button onclick="history.back()" type="" class="btn btn-secondary" >Fermer</button>
                  <a href="../src/supprimer.php?mail_id=<?= $_GET['suppr'] ?>" type="button" class="btn btn-danger">Supprimer</a>
                  <?php endif ?>
                </div>
              </div>
            </div>
          </div>


<?php
view('footer');
?>