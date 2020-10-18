<!-- Titre de la page connexionView.php à insérer dans le template de la vue -->
<?php $title = "Billet simple pour l'Alaska";?>



<!-- Header de la page connexionView.php à insérer dans le template -->
<?php ob_start(); ?>
    <!-- Entête -->
    <div class="nav_container">
      <nav class="navbar navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="index.php?action=listArticles">
          <img src="public/images/vintage-1751222_1280.png" width="30" height="30" class="d-inline-block align-top" alt="plume_et_encrier">
          <span class="index_title">Jean Forteroche</span>
        </a>
        <a href="index.php?action=listArticles" class="btn btn-primary"><span id="login_icon"><i class="fas fa-home fa-lg"></i></span>Accueil</a>
      </nav>
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h2 class="display-4">Billet simple pour l'Alaska</h2>
          <p class="lead">Le nouveau roman de <span class="index_second_title">Jean Forteroche ...</span></p>
        </div>
      </div>
    </div>
<?php $headerContent = ob_get_clean(); ?>



<!-- Body de la page connexionView.php à insérer dans le template -->
<?php ob_start(); ?>
  <!-- Affichage du formulaire d'identification -->
  <!-- Grid Bootstrap Container -->
    <div class="container">

      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <!--<h2>Blog de Jean Forteroche</h2>offset-lg-3-->

          <!-- Formulaire -->
          <form class="admin_form" action="index.php?action=login" method="post">
            <legend class="p-3 mb-2 bg-secondary text-white rounded">Connexion au compte administrateur</legend> <!-- Légende avec un fond gris et coins arrondis -->

            <div class="form-group">
              <label for="login">Nom d'utilisateur</label> : <input type="text" class="form-control" name="login" value="<?php echo $_COOKIE['login'];?>" required/>
              <br>
            </div>
            <div class="form-group form-password">
              <label for="password">Mot de passe</label> : <input type="password" class="form-control" name="password" value="<?php echo $_COOKIE['password'];?>" required/>
              <br>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="autoConnexion" id="autoConnexion" checked="checked">
                <label class="form-check-label" for="autoConnexion">Connexion automatique</label>
            </div>
            <button type="submit" class="btn btn-primary" name="connexion" value="Entrer">Entrer</button>

          </form>
        </div>
      </div>
    </div> <!-- Fin de container -->


<?php $bodyContent = ob_get_clean(); ?>

<!-- Chargement du template -->
<?php require('view/backend/template.php'); ?>
