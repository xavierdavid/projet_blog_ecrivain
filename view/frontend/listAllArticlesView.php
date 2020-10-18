
<!-- Titre de la page listArticlesView à insérer dans le template de la vue -->
<?php $title = "Billet simple pour l'Alaska";?>

<!-- Header de la page listArticlesView à insérer dans le template -->
<?php ob_start(); ?>
    <!-- Entête -->
    <div class="nav_container">
      <nav class="navbar navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="index.php?action=listArticles">
          <img src="public/images/vintage-1751222_1280.png" width="30" height="30" class="d-inline-block align-top" alt="plume_et_encrier">
          <span class="index_title">Jean Forteroche</span>
        </a>
        <a href="index.php?action=login" class="btn btn-primary"><span id="login_icon"><i class="fas fa-sign-in-alt fa-lg"></i></span>Connexion</a>
      </nav>
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h2 class="display-4">Billet simple pour l'Alaska</h2>
          <p class="lead">Le nouveau roman de <span class="index_second_title">Jean Forteroche ...</span></p>
        </div>
      </div>
    </div>
<?php $headerContent = ob_get_clean(); ?>



<!-- Body de la page listArticlesView à insérer dans le template -->
<?php ob_start(); ?>
    <!-- Grid Bootstrap Main Container -->
    <div class="container">
      <!-- Articles introduction -->
      <div class="row">
        <div class="col-lg-12">
          <p id="intro">Découvrez mon nouveau roman, épisode par épisode, au fur et à mesure de son écriture... et réagissez en laissant vos commentaires.</p>
        </div>
      </div>

      <div class="row">
          <div class="col-lg-12" id="home_menu">
              <div class="first_link">
                  <a href="index.php?action=listArticles" class="btn btn-secondary">Derniers articles publiés </a>
              </div>
          </div>
      </div>



      <!-- Articles display -->
      <div class="row">
        <div class="col-lg-12">
          <span class="badge badge-pill badge-info">Tous les articles publiés</span>
          <?php
            while($data = $articles -> fetch()){
          ?>
              <!-- Affichage des articles -->
              <div class="card">
                <div class="card-header">
                  <em><?php echo 'Article publié le ' . $data['creation_date_fr'];?></em>
                </div>
                <div class="card-body">
                  <h5 class="card-title">
                    <?php echo htmlspecialchars($data['title']); ?>
                  </h5>
                  <p class="card-text">
                    <?php echo nl2br($data['content']); ?>
                  </p>
                  <br>
                </div>
                <div class="card-footer text-muted">
                  <!-- On transmet le numéro (identifiant) de l'article via l'url contenu dans le lien -->
                  <!-- L'article pourra ainsi être récupéré dans comments.php et pour afficher les commentaires correspondant -->
                  <em><a href="index.php?action=post&amp;article_id=<?php echo $data['id']; ?>" class="btn btn-primary">Commentaires </a></em>
                </div>
              </div>

          <?php
        } // Fin de boucle while

            // On termine le traitement de la requête
            $articles->closeCursor();
          ?>
        </div>
      </div>
    </div> <!-- Fin de div container Bootstrap -->

    <?php $bodyContent = ob_get_clean(); ?>



<!-- Chargement du template -->
<?php require('view/frontend/template.php'); ?>
