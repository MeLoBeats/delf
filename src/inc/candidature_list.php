<?php
include_once dirname(__FILE__) . '/../bootstrap.php';
if (!is_admin()) {
  header('location: ../../public');
}



?>

<div id="form" class="wrapper d-flex navbar">

  <h2>Liste des candidatures</h2>
  <div id="optDrop" class="btn-group" role="group" aria-label="Basic outlined example">
    <button type="button" class="btn shadow-none btn-outline-info"><i class="bi bi-menu-app"></i> Options</button>
    </button>
  </div>
  <div id="optNone" class="container-sm gap-2 d-none">
    <div class="row-sm align-items-start">
      <?php if (isset($_GET['searchWhere'])) : $value = htmlentities(stripcslashes($_GET['searchWhere']));
      else : $value = "";
      endif ?>
      <form class="col d-flex" action="" method="get">
        <input type="text" class="form-control me-2" name="searchWhere" id="where" value="<?= $value ?>" placeholder="Rechercher par nom">
        <button class="btn btn-secondary" type="submit" id="subWhere">Rechercher</button>
      </form>
    </div>
    <div class="row-sm w-20 align-items-end">
      <form action="" method="GET" class="col d-flex">
        <select name="formation" id="">
          <optgroup>
            <option value="A1">Delf A1</option>
            <option value="A2">Delf A2</option>
            <option value="B1">Delf B1</option>
            <option value="B2">Delf B2</option>
            <option value="C1">Dalf C1</option>
            <option value="C2">Dalf C2</option>
          </optgroup>
        </select>
        <input type="number" min="0" max="50" class="form-control me-2" name="limit" placeholder="Limite par niveau">
        <button class="btn btn-primary" type="submit">Limiter</button>
      </form>
    </div>

    <div class="row align-items-center">

      <button onclick="window.location = 'confirm.php?suppr=all&type=form'" class="btn btn-danger" name="deleteall" type="submit">Tout supprimer</button>
      <?php
      if (isset($_POST['deleteall'])) {
        //   $query = "DELETE FROM formulaire;";
        //   $res = db()->prepare($query);
        //   $res->execute();
        // if(!$res) {
        //   $err = "Erreur lors de la suppression des données";
        // }
      } ?>
    </div>
  </div>
</div>

<?php
$order = "";
$where = "";

if (isset($_GET['searchWhere'])) {
  $where = $_GET['searchWhere'];
}
$info = "SELECT * FROM `formulaire` WHERE nom LIKE '$where%' OR prenom LIKE '$where%' ORDER BY `form_id` DESC;";
$resFormInfo = db()->prepare($info);
$resFormInfo->execute();
$resFormInfo = $resFormInfo->fetchAll(PDO::FETCH_NUM);
if ($count = count($resFormInfo) > 0) : ?>
  <div style="max-height: 600px;" class="table-responsive">
    <table class="form_table table table-bordered table-striped ">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nom</th>
          <th scope="col">Nom d'épouse</th>
          <th scope="col">Prénom</th>
          <th scope="col">Date de naissance</th>
          <th scope="col">Ville de naissance</th>
          <th scope="col">Pays de naissance</th>
          <th scope="col">Nationalité</th>
          <th scope="col">Langue Maternelle</th>
          <th scope="col">Adresse Mail</th>
          <th scope="col">Numéro de téléphone</th>
          <th scope="col">A déja passé DELF-DALF</th>
          <th scope="col">Ancien numéro de candidat</th>
          <th scope="col">Niveau souhaité</th>
          <th scope="col">Prise en charge</th>
          <th scope="col">Carte d'identité</th>
          <th scope="col">Date du formulaire</th>
          <th scope="col">Paiement</th>
          <th scope="col">user_id</th>
          <th scope="col">Supprimer</th>
        </tr>
      </thead>
      <tbody> <?php
              foreach ($resFormInfo as $formInfo) {
              ?>
          <tr>
            <?php for ($i = 0; $i < 15; $i++) : ?>
              <td><?= $formInfo[$i] ?></td>
            <?php endfor ?>
            <td>
              <form action="../src/get_ci.php" method="POST">
                <button class="btn btn-warning" name="carte_idd" value="<?= $formInfo[15] ?>">Télécharger</button>
              </form>
            </td>

            <?php for ($i = 16; $i < 19; $i++) : ?>
              <td><?= $formInfo[$i] ?></td>
            <?php endfor ?>
            <td>
              <button onclick="window.location = './confirm.php?suppr=<?= $formInfo[0] ?>&type=form'" class="btn btn-danger" name="suppr" value="<?= $formInfo[0] ?>">Supprimer</button>
            </td>
          </tr>
          <?php
                if (isset($_GET['suppr'])) {
                  // try {
                  //     $delete = "DELETE FROM formulaire WHERE form_id =" . htmlentities(stripcslashes( $_GET['suppr'])) . ";";
                  //     // $update = "UPDATE `users` SET `form_rempli` = '0' WHERE `users`.`id` = ". $_GET['reinit'] . "';";
                  //     $sql = db()->prepare($delete);
                  //     $sql->execute();
                  //     // $sql2 = mysqli_query($conn, $update);
                  //     if($sql) {
                  //         // echo "Formulaire Supprimé !";
                  //     } elseif($sql2) {
                  //     echo "Formulaire réinitialisé !";
                  //     }
                  // } catch (\Throwable $th) {
                  //     echo "Impossible de supprimer l'utilisateur" . $th;
                  // }
                }
          ?>
        <?php } ?>
      <?php else : ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped ">
            <thead>
              <tr>
                <th scope="col">Aucun Formulaires</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Aucun Formulaires remplis</td>
              </tr>
            </tbody>
          <?php endif ?>

      </tbody>
    </table>
  </div>