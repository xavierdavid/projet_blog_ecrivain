<!-- Titre de la page detailCommentView à insérer dans le template de la vue -->
<?php $title = "Billet simple pour l'Alaska";?>

<!-- Header de la page detailCommentView à insérer dans le template -->
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
          <h2 class="display-4">Edition d'un commentaire</h2>
          <p class="lead">Modifier ou supprimer un commentaire</p>
        </div>
      </div>
    </div>

<?php $headerContent = ob_get_clean(); ?>



<!-- Body de la page detailCommentView à insérer dans le template -->
<?php ob_start(); ?>
  <!-- Grid Bootstrap Container -->
  <!-- Lien de retour vers la page des articles publiés -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12" id="home_menu">
        <div class="first_link">
          <a href="index.php?action=create" class="btn btn-secondary" id="comment_link">Ecrire un article </a>
        </div>
        <div class="second_link">
          <a href="index.php?action=recover_articles" class="btn btn-info" id="articles_link">Tous les articles <span class="badge badge-light"><?php echo($countPostArticles['nbArticles']); ?></span></a>
        </div>
        <div class="third_link">
          <a href="index.php?action=recover_comments" class="btn btn-info" id="articles_link">Tous les commentaires <span class="badge badge-light"><?php echo($countPostComments['nbComments']); ?></span></a>
        </div>
      </div>
    </div>

    <!-- Affichage du commentaire à éditer -->

    <div class="row">
      <div class="col-lg-12">

        <div class="card" id="comment_card">
          <div class="card-header" id="comment_header">
            <p>
              <strong><?php echo htmlspecialchars($detailComment['author']);?></strong> le <?php echo $detailComment['comment_date_fr']; ?>
              <span><strong> - Article associé : </span></strong><a href="index.php?action=edition&amp;article_id=<?php echo $detailArticle['id'];?>"><?php echo htmlspecialchars($detailArticle['title']); ?></a>
            </p>
          </div>
          <div class="card-body">
            <p class="card-text" id="comment_content">
              <?php echo nl2br(htmlspecialchars($detailComment['comment'])); ?>
            </p>
            <br>
          </div>

          <?php
            if(isset($detailComment['signal_comment']) && $detailComment['signal_comment'] == 1) {
              ?>
              <div class="alert alert-danger" role="alert" id="signalMessage" value=<?php echo $detailComment['signal_comment']; ?>>
               Ce commentaire a été signalé le <?php echo $detailComment['signal_date_fr']; ?>
             </div>

            <?php }  ?>

            <div class="col-lg-4">
              <!-- Transmission des données vers index.php -->
              <a href="index.php?action=recover_comment&amp;comment_id=<?php echo $detailComment['id'];?>&amp;article_id=<?php echo $detailArticle['id'];?>" class="btn btn-secondary" id="update_link">Modifier</a>
              <a href="index.php?action=delete_comment&amp;comment_id=<?php echo $detailComment['id']; ?>" class="btn btn-danger" id="delete_link" onclick="return(confirm('Êtes-vous sûrs de vouloir supprimer ce commentaire ?'));">Supprimer</a>
            </div>
        </div>
      </div>
    </div>



    <!-- Affichage de l'article associé au commentaire -->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <em><?php echo 'Article associé publié le ' . $detailArticle['creation_date_fr'];?></em>
          </div>
          <div class="card-body">
            <h5 class="card-title">
              <?php echo htmlspecialchars($detailArticle['title']); ?>
            </h5>
            <p class="card-text">
              <?php echo nl2br($detailArticle['content']); ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- Fin du container Bootstrap -->

  <?php $bodyContent = ob_get_clean(); ?>

  <!-- Chargement du template -->
  <?php require('view/backend/template.php'); ?>
