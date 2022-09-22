<?php
include_once dirname(__FILE__) . '/../bootstrap.php';

if (!is_admin()) {
  header('location: ../../public');
}

?>
<div id="users" class="wrapper d-flex navbar">

  <?php
  $subOrder = "";
  $subWhere = "";

  if (isset($_GET['SubSearchWhere'])) {
    $subWhere = $_GET['SubSearchWhere'];
    $info = "SELECT * FROM `users` WHERE nom LIKE '$subWhere%' OR prenom LIKE '$subWhere%' ORDER BY 'user_id' DESC;";
  } else {
    $info = "SELECT * FROM `users` ORDER BY 'user_id' DESC;";
  }
  ?>

  <h2>Liste des utilisateurs</h2>
  <form class="d-flex" action="" method="get">
    <input type="text" class="form-control me-2" value="<?= $subWhere ?>" name="SubSearchWhere" id="where" placeholder="Rechercher par nom">
    <button class="btn btn-secondary" type="submit" id="subWhere">Rechercher</button>
  </form>
  <button onclick="window.location = 'confirm.php?suppr=all&type=user'" class="btn btn-warning" name="reinitall" type="submit">Tout Réinitialiser</button>
  <?php
  // if(isset($_POST['reinitall'])) {
  //   $query = "UPDATE users SET form_rempli = 0;";
  //   $res = db()->prepare($query);
  //   $res->execute();
  //   $$success = "Utilisateur bien réinitialisé !";
  //   if(!$res) {
  //     echo "Erreur lors de la suppression des données";
  //   }
  // } 
  ?>
</div>

<?php

$resInfo = db()->prepare($info);
$resInfo->execute();
$resInfo = $resInfo->fetchAll(PDO::FETCH_NUM);
if (count($resInfo) > 0) : ?>
  <div style="max-height: 600px;" class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr class="form_tr">
          <th scope="col">#</th>
          <th scope="col">Nom</th>
          <th scope="col">Prénom</th>
          <th scope="col">Adresse mail</th>
          <th scope="col">Administrateur</th>
          <th scope="col">A rempli un formulaire</th>
          <th scope="col">Date d'inscription</th>
          <th scope="col">Supprimer</th>
          <th scope="col">Réinitialiser</th>
        </tr>
      </thead>
      <tbody> <?php
              foreach ($resInfo as $user) {
              ?>
          <tr class="form_tr">
            <td><?= $user[0] ?></td>
            <td><?= $user[1] ?></td>
            <td><?= $user[2] ?></td>
            <td><?= $user[3] ?></td>
            <td><?= $user[5] ?></td>
            <td><?= $user[6] ?></td>
            <td><?= $user[7] ?></td>
            <td>
              <button onclick="window.location = './confirm.php?suppr=<?= $user[0] ?>&type=user'" name="supprimer" class="btn btn-danger" type="submit" value="<?= $user[0] ?>">Supprimer</button>
            </td>
            <td>
              <button onclick="window.location = './confirm.php?suppr=null&reinit=<?= $user[0] ?>&type=user'" name="reinit" class="btn btn-warning" type="submit" value="<?= $user[0] ?>">Réinitialiser</button>
            </td>
          </tr>

        <?php } ?>
        <?php
        if (isset($_POST['supprimer'])) {
          // try {
          //     $delete = "DELETE FROM users WHERE user_id ='" . $_POST['supprimer'] . "';";
          //     $sql = db()->prepare($delete);
          //     $sql->execute();
          //     if($sql) {
          //         echo "Utilisateur Supprimé !";
          //     }
          // } catch (\Throwable $th) {
          //     echo "Impossible de supprimer l'utilisateur";
          // }
        }
        if (isset($_GET['reinit'])) {
          // try {
          //     $update = "UPDATE users SET form_rempli = 0 WHERE users.user_id =" . $_GET['reinit'] . ";";
          //     $sql = db()->prepare($update);
          //     $sql->execute();
          //     if($sql) {
          //         echo "Utilisateur Réinitialisé !";
          //     }
          // } catch (\Throwable $th) {
          //     echo "Impossible de réinitialiser l'utilisateur " . $th;
          // }
        }
        ?>
      <?php else : ?>
        <div class="table-responsive">
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">Aucun Utilisateur</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Aucun utilisateur trouvé</td>
              </tr>
            </tbody>
          <?php endif ?>

      </tbody>
    </table>
  </div>