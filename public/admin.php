<?php 
require_once '../src/bootstrap.php';
view('header', ['title' => 'Administration']);

if (!is_admin()) {
  header('location: index.php');
};
$err = "";
$success = "";
?>

<?php 
if(set_get('limit') && set_get('formation')) {
    $success = change_limit($err, $success);
}

  
?>

<div class="">
  <div class="row d-flex">
    <?php view('navAdmin') ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tableau d'administration</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <form action="../src/export.php">
            <button type="submit" id="export" class="exportForm btn btn-sm btn-outline-secondary">
              Exporter
            </button>
          </form>
        </div>
      </div>
      <?php 
      if(isset($err) && $err !== "") {
        ?>
        <div class="alert alert-danger" style="border-left: red;"><?= $err ?></div> <?php
      } elseif (isset($success) && $success !=="") {
        ?>
        <div class="alert alert-success"><?= $success ?></div> <?php
      }
      ?>

      <?php view('candidature_list') ?>

<hr>

      <?php view('user_list', ['success' => $success, 'err' => $err]) ?>
      
      <hr class="mt-5">
      
      <?php view('mail_list') ?>

      </div>
    </main>
  </div>
</div>

<script>
  const drop = document.getElementById('optDrop');
  const opt = document.getElementById('optNone');
  const btnActive = document.querySelector('#optDrop button')
  drop.addEventListener('click', () => {
    opt.classList.toggle('d-none');
    opt.classList.toggle('mt-3');
    btnActive.classList.toggle('active');
  })
</script>

<?php view('footer');?>
