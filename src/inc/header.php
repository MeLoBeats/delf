<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
      <?php if(isset($title)): ?>
        <?= $title ?>
      <?php else: ?>
        Inscription au DELF-DALF
      <?php endif ?>
    </title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  </head>

  <body>

    <nav class="sticky-top w-100 navbar navbar-expand-md navbar-dark bg-dark" aria-label="Fourth navbar example">
      <div class="h-100 container-fluid">
        <a class="navbar-brand" href="index.php">Inscription au DELF-DALF</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
          <?php 
          view("navbar") ?>

      </div>
      <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
        <ul class="h-100 navbar-nav me-auto mb-2 mb-md-0">
            <?php if(!isset($_SESSION['email'])){

              echo nav_item('connexion.php', 'Connexion', 'nav-link'); 
              echo nav_item('register.php', 'Inscription', 'nav-link'); 
            } elseif(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
              echo nav_item('admin.php', 'Administration', 'nav-link'); 
              echo nav_item('logout.php', 'Déconnexion', 'nav-link'); 
            } else {
              echo nav_item('form.php', 'Formulaire', 'nav-link'); 
              echo nav_item('logout.php', 'Déconnexion', 'nav-link'); 
            }
            ?>
          </ul>
          
        </div>
      </div>
    </nav>

    <main role="main" class="container">
