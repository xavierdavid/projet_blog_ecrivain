<!-- Titre de la page createArticleView à insérer dans le template de la vue -->
<?php $title = "Billet simple pour l'Alaska";?>

<!-- Header de la page commentsView à insérer dans le template -->
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
          <h2 class="display-4">Commentaires signalés</h2>
          <p class="lead">Tous les commentaires signalés.</p>
        </div>
      </div>
    </div>
<?php $headerContent = ob_get_clean(); ?>


<!-- Body de la page commentsView à insérer dans le template -->
<?php ob_start(); ?>

  <!-- Grid Bootstrap Container -->

  <div class="container">

    <div class="row">
      <div class="col-lg-12" id="home_menu">
        <div class="first_link">
          <a href="index.php?action=create" class="btn btn-secondary">Ecrire un article </a>
        </div>
        <div class="second_link">
          <a href="index.php?action=recover_articles" class="btn btn-info">Tous les articles <span class="badge badge-light"><?php echo($countPostArticles['nbArticles']); ?></span></a>
        </div>

        <div class="third_link">
          <a href="index.php?action=recover_comments" class="btn btn-info">Tous les commentaires <span class="badge badge-light"><?php echo($countPostComments['nbComments']); ?></span></a>
        </div>
      </div>
    </div>


  <!-- Affichage de la liste des commentaires publiés -->

    <!-- Affichage des commentaires -->

    <div class="row">
      <div class="col-lg-12">
        <br>
        <span class="badge badge-pill badge-info">Tous les commentaires signalés</span>

        <?php
          // On affiche les commentaires
          while($signalComment = $signalComments->fetch()){
        ?>

        <div class="card" id="comment_card">
          <div class="card-header" id="comment_header">
            <p>
              <strong><?php echo htmlspecialchars($signalComment['author_comments']);?></strong> le <?php echo $signalComment['comment_date_fr']; ?>
              <span><strong> - Article associé : </span></strong><a href="index.php?action=edition&amp;article_id=<?php echo $signalComment['id_articles'];?>"><?php echo htmlspecialchars($signalComment['title_articles']);?></a>
            </p>
          </div>
          <div class="card-body">
            <p class="card-text" id="comment_content">
              <?php echo nl2br(htmlspecialchars($signalComment['comment_comments'])); ?>
            </p>
            <br>
          </div>
          <!-- Modifier un commentaire -->
          <div class="card-footer text-muted">
            <!-- On transmet le numéro (identifiant) du commentaire via l'url contenu dans le lien -->
            <!-- Le signalement du commentaire pourra ainsi être récupéré puis être traité par le routeur -->
            <em><a href="index.php?action=moderation&amp;comment_id=<?php echo $signalComment['id_comments']; ?>&amp;article_id=<?php echo $signalComment['id_articles']; ?>" class="btn btn-secondary" >Modérer</a></em>
          </div>
          <div class="alert alert-danger" role="alert" id="signalMessage" value=<?php echo $signalComment['signal_comment']; ?>>
            Ce commentaire a été signalé le <?php echo $signalComment['signal_date_fr']; ?>
          </div>
        </div>

        <?php
            } // Fin de la boucle while des commentaires

        // On termine le traitement de la requête
        $signalComments->closeCursor();
        ?>
      </div>
    </div>
  </div> <!-- Fin de div container Bootstrap -->

<?php $bodyContent = ob_get_clean(); ?>




<!-- Chargement du template -->
<?php require('view/backend/template.php'); ?>
