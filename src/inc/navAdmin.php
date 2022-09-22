<nav id="sidebarMenu" class="position-sticky col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          
          <?= dashboard_list("Administration", "#") ?>
          <?= dashboard_list("Formulaires", "#form") ?>
          <?= dashboard_list("Utilisateurs", "#users") ?>
          <?= dashboard_list("Mails", "#mails") ?>
          
        </ul>

        
      </div>
    </nav>