<?php
include_once dirname(__FILE__) . '/../bootstrap.php';
if (!is_admin()) {
  header('location: ../../public');
}

?>

<div id="mails" class="mt-5 wrapper d-flex navbar">


  <h2>Mails</h2>

</div>

<div class="mb-5">

  <form class="form" method="POST" action="../src/gerer_mail.php">
    <div class="form-floating mb-1">
      <input class="form-control" type="text" name="sujet" id="floatingInput2" placeholder="Sujet du mail">
      <label for="floatingInput2">Sujet du mail</label>
    </div>
    <div class="form-floating mb-2">
      <textarea class="form-control" name="message" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
      <label for="floatingTextarea2">Contenu du message</label>
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
  </form>
  <div class="wrapper d-flex navbar">


    <form class="mt-5 d-flex" action="" method="get">
      <input type="text" class="form-control me-2" name="searchWhere" id="where" placeholder="Rechercher par nom">
      <button class="btn btn-secondary" type="submit" name="SubSearchWhere" id="subWhere">Rechercher</button>
    </form>
  </div>

  <?php
  $info = "SELECT * FROM `mail` ORDER BY 'id' ASC;";
  $resInfo = db()->prepare($info);
  $resInfo->execute();
  $resInfo = $resInfo->fetchAll(PDO::FETCH_NUM);
  if (count($resInfo) > 0) : ?>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Sujet</th>
            <th scope="col">Message</th>
            <th scope="col">Supprimer</th>
            <th scope="col">Choisir</th>
          </tr>
        </thead>
        <tbody> <?php
                foreach ($resInfo as $mail) {

                ?>
            <tr>
              <td><?= $mail[0] ?></td>
              <td><?= $mail[1] ?></td>
              <td><?= $mail[2] ?></td>
              <td>
                <button onclick="window.location = './confirm.php?suppr=<?= $mail[0] ?>&type=mail'" name="supprimer" class="btn btn-danger" type="submit" value="<?= $mail[0] ?>">Supprimer</button>
              </td>
              <?php
                  if ($mail[3] == 1) {
              ?>
                <td>
                  <button disabled class="btn btn-secondary" style="cursor: not-allowed;" type="button">Choisi !</button>
                </td>
              <?php
                  } else {
              ?>
                <td>
                  <form action="" method="GET">
                    <button name="choisirmail" class="btn btn-primary" type="submit" value="<?= $mail[0] ?>">Choisir</button>
                  </form>
                </td>
              <?php }
                  if (isset($_GET['choisirmail'])) {
                    $update = "UPDATE mail SET choisi = 0";
                    $query = "UPDATE mail SET choisi = 1 WHERE mail_id = " . $_GET['choisirmail'] . ";";
                    try {
                      $resUpdate = db()->prepare($update);
                      $resUpdate->execute();
                      $res = db()->prepare($query);
                      $res->execute();
                    } catch (\Throwable $th) {
                      echo $th;
                    }
                  }
              ?>
            </tr>

          <?php } ?>
          <?php
          if (isset($_GET['supprimermail'])) {
            try {
              $delete = "DELETE FROM mail WHERE mail_id ='" . $_GET['supprimermail'] . "';";
              $sql = db()->prepare($delete);
              $sql->execute();
              if ($sql) {
                echo "Mail Supprimé !";
              }
            } catch (\Throwable $th) {
              echo "Impossible de supprimer l'email";
            }
          }
          ?>
        <?php else : ?>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th scope="col">Aucun Mails</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Aucun Mails trouvé</td>
                </tr>
              </tbody>
            <?php endif ?>

        </tbody>
      </table>
    </div>