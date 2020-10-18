<!-- Titre de la page createArticleView à insérer dans le template de la vue -->
<?php $title = "Billet simple pour l'Alaska";?>

<!-- Header de la page createArticleView à insérer dans le template -->
<?php ob_start(); ?>
    <!-- Entête -->
    <div class="nav_container">
      <nav class="navbar navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="index.php?action=create">
          <img src="public/images/vintage-1751222_1280.png" width="30" height="30" class="d-inline-block align-top" alt="plume_et_encrier">
          <span class="index_title">Jean Forteroche</span>
        </a>
        <span class="navbar-text">
          <?php echo 'Bonjour '. $_SESSION['login']. ' !';?>
        </span>
        <a href="index.php?action=logout" class="btn btn-primary"><span id="login_icon"><i class="fas fa-sign-out-alt fa-lg"></i></span>Déconnexion</a>
      </nav>
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h2 class="display-4">Articles</h2>
          <p class="lead">Tous les articles publiés.</p>
        </div>
      </div>
    </div>
<?php $headerContent = ob_get_clean(); ?>



<!-- Body de la page createArticleView à insérer dans le template -->
<?php ob_start(); ?>
  <!-- Ecriture d'un nouvel article -->
  <!-- Grid Bootstrap Container -->

  <div class="container">

    <div class="row">
      <div class="col-lg-12" id="home_menu">
        <div class="first_link">
          <a href="index.php?action=create" class="btn btn-secondary">Ecrire un article </a>
        </div>
        <div class="second_link">
          <a href="index.php?action=recover_comments" class="btn btn-info">Tous les commentaires <span class="badge badge-light"><?php echo($countPostComments['nbComments']); ?></span></a>
        </div>
      </div>
    </div>



    <!-- Affichage de la liste des articles publiés -->

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
              <!-- Redirection vers le rooter : le paramètre action prend la valeur 'edition' -->
              <em><a href="index.php?action=edition&amp;article_id=<?php echo $data['id']; ?>" class="btn btn-primary">Détail de l'article</a></em>
            </div>
          </div>

          <?php
        }
          // On termine le traitement de la requête
          $articles->closeCursor();
          ?>
      </div>
    </div>

  </div> <!-- Fin du container Bootstrap -->

  <?php $bodyContent = ob_get_clean(); ?>

  <!-- Chargement du template -->
  <?php require('view/backend/template.php'); ?>
