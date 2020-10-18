<!-- Titre de la page updateCommentView à insérer dans le template de la vue -->
<?php $title = "Billet simple pour l'Alaska";?>

<!-- Header de la page updateCommentView à insérer dans le template -->
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
          <h2 class="display-4">Modification d'un commentaire</h2>
          <p class="lead">Modérer un commentaire</p>
        </div>
      </div>
    </div>

<?php $headerContent = ob_get_clean(); ?>

<!-- Récupération du formulaire de saisie de commentaire pré-rempli avec les données du commentaire à modérer -->

  <div class="container">

    <!-- Affichage du bandeau du commentaire à éditer -->

    <div class="row">
      <div class="col-lg-12">

        <div class="card" id="comment_card">
          <div class="card-header" id="comment_header">
            <p>
              <strong><?php echo htmlspecialchars($detailComment['author_comments']);?></strong> le <?php echo $detailComment['comment_date_fr']; ?>
              <span><strong> - Article associé : </span></strong><a href="index.php?action=edition&amp;article_id=<?php echo $detailComment['id_articles'];?>"><?php echo htmlspecialchars($detailComment['title_articles']);?></a>
            </p>
          </div>

          <?php
            if(isset($detailComment['signal_comment']) && $detailComment['signal_comment'] == 1) {
              ?>
              <div class="alert alert-danger" role="alert" id="signalMessage" value=<?php echo $detailComment['signal_comment']; ?>>
               Ce commentaire a été signalé le <?php echo $detailComment['signal_date_fr']; ?>
             </div>

            <?php }  ?>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-lg-12">

        <!-- Formulaire d'édition du commentaire -->
        <!-- Envoi du formulaire vers l'action update_comment() du rooter et transmission de l'identifiant du commentaire via l'url-->
        <form class="comment_form" action="index.php?action=update_comment&amp;comment_id=<?php echo $detailComment['id_comments']; ?>" method="post">
          <h4>Modérer le commentaire</h4>

          <div class="form-group">
            <label for="comment">Commentaire</label> : <textarea type="text" class="form-control" name="comment" rows="2" id="comment_area" required> <?php echo htmlspecialchars($detailComment['comment_comments']);?></textarea>
          </div>
          <button type="submit" class="btn btn-primary" name="comment_publication" value="comment_publish">Publier</button>
          <a href="index.php?action=moderation&amp;comment_id=<?php echo $detailComment['id_comments'];?>&amp;article_id=<?php echo $detailComment['id_articles'];?>" class="btn btn-secondary" id="cancel_link">Annuler</a>
        </form>
      </div>
    </div>

  </div> <!-- Fin du container Bootstrap -->

  <?php $bodyContent = ob_get_clean(); ?>

  <!-- Chargement du template -->
  <?php require('view/backend/template.php'); ?>
