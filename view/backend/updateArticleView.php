<!-- Titre de la page updateArticleView à insérer dans le template -->
<?php $title = "Billet simple pour l'Alaska";?>

<!-- Header de la page updateArticleView à insérer dans le template -->
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
          <h2 class="display-4">Modifier un article</h2>
          <p class="lead">Edition et publication d'un article</p>
        </div>
      </div>
    </div>
<?php $headerContent = ob_get_clean(); ?>


<!-- Body de la page updateArticleView à insérer dans le template -->
<?php ob_start(); ?>

  <!-- Grid Bootstrap Container -->

  <div class="container">
    <div class="row">
      <div class="col-lg-12">

        <form method="post" action="index.php?action=update&amp;article_id=<?php echo $article['id']; ?>">

          <div class="form-group">
            <label for="newArticleTitle" id="articleTitle">Titre de l'article</label>
            <input type="text" class="form-control" name="newArticleTitle" value="<?php echo htmlspecialchars($article['title']); ?>" required>
          </div>

          <div class="form-group">
            <label for="newArticleContent" id="contentTitle">Contenu de l'article</label>
            <textarea id="articleContent" name="newArticleContent"><?php echo $article['content'];?></textarea>
          </div>

          <button type="submit" class="btn btn-primary" name="publication" value="publish">Publier</button>
          <a href="index.php?action=edition&amp;article_id=<?php echo $article['id']; ?>" class="btn btn-secondary" id="cancel_link">Annuler</a>

        </form>
      </div>
    </div>
  </div> <!-- Fin du container Bootstrap -->

<?php $bodyContent = ob_get_clean(); ?>


<!-- Chargement du template -->
<?php require('view/backend/template.php'); ?>
