<div class="h-100 collapse navbar-collapse" id="navbarsExample04">
        <ul class="h-100 navbar-nav me-auto mb-2 mb-md-0">
          <?= nav_item('index.php', 'Accueil', 'nav-link'); ?>
               
          <?php if(isset($_SESSION['email'])) : echo nav_item('#', "Bienvenue ". $_SESSION['prenom']. " " . $_SESSION['nom'] . " !", 'nav-link'); endif?>
        </ul>
        <div>
          <ul class="h-100 navbar-nav me-auto mb-2 mb-md-0">
            <?php if(!isset($_SESSION['email'])){

              echo nav_item('login.php', 'Connexion', 'nav-link'); 
              echo nav_item('register.php', 'Inscription', 'nav-link'); 
            } elseif(is_admin()) {
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