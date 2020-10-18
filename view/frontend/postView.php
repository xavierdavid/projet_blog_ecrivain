<!-- Titre de la page indexView à insérer dans le template de la vue -->
<?php $title = "Billet simple pour l'Alaska";?>

<!-- Header de la page indexView à insérer dans le template -->
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



<!-- Header de la page indexView à insérer dans le template -->
<?php ob_start(); ?>

  <div class="container">

    <div class="row">
      <div class="col-lg-12" id="home_menu">
        <div class="first_link">
          <!-- Lien de retour vers la page des articles publiés -->
          <a href="index.php?action=listArticles" class="btn btn-secondary" >Derniers articles</a>
        </div>
        <div class="second_link">
          <!-- Lien de retour vers la page des articles publiés -->
          <a href="index.php?action=listAllArticles" class="btn btn-info" >Tous les articles <span class="badge badge-light"><?php echo($countPostArticles['nbArticles']); ?></span></a>
        </div>
      </div>
    </div>


    <!-- Récupération et affichage de l'article -->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <em><?php echo 'Article publié le ' . $article['creation_date_fr'];?></em>
          </div>
          <div class="card-body">
            <h5 class="card-title">
              <?php echo htmlspecialchars($article['title']); ?>
            </h5>
            <p class="card-text">
              <?php echo nl2br($article['content']); ?>
            </p>
            <br>
          </div>
        </div>
      </div>
    </div>




    <!-- Formulaire de saisie de commentaires -->

    <div class="row">
      <div class="col-lg-12">

        <!-- Formulaire -->
        <!-- Envoi du formulaire vers l'action addComment() du rooter et transmission de l'identifiant de l'article via l'url-->
        <form class="comment_form" action="index.php?action=addComment&amp;article_id=<?php echo $article['id']; ?>" method="post">
          <h4>Ajouter un commentaire</h4>
          <div class="form-group">
            <label for="author">Auteur</label> : <input type="text" class="form-control" name="author" id="pseudo_input" required/>
            <br>
          </div>
          <div class="form-group">
            <label for="comment">Commentaire</label> : <textarea type="text" class="form-control" name="comment" rows="2" id="comment_area" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary" name="post" value="Enter">Valider</button>
        </form>
      </div>
    </div>

    <!-- Affichage des commentaires -->

    <div class="row">
      <div class="col-lg-12">
        <br>
        <span class="badge badge-pill badge-info">Derniers commentaires</span>

        <?php
          // On affiche les commentaires
          while($comment = $comments->fetch()){
        ?>

        <div class="card" id="comment_card">
          <div class="card-header" id="comment_header">
            <p>
              <strong><?php echo htmlspecialchars($comment['author']);?></strong> le <?php echo $comment['comment_date_fr']; ?>
            </p>
          </div>
          <div class="card-body">
            <p class="card-text" id="comment_content">
              <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
            </p>
            <br>
          </div>
          <!-- Signaler un commentaire -->
          <div class="card-footer text-muted">
            <!-- On transmet le numéro (identifiant) du commentaire via l'url contenu dans le lien -->
            <!-- Le signalement du commentaire pourra ainsi être récupéré puis être traité par le routeur -->
            <em><a href="index.php?action=signal&amp;comment_id=<?php echo $comment['id']; ?>&amp;article_id=<?php echo $article['id']; ?>" class="btn btn-secondary" onclick="return(confirm('Êtes-vous sûrs de vouloir signaler ce commentaire ?'));">Signaler</a></em>
          </div>
          <?php
            if(isset($comment['signal_comment']) && $comment['signal_comment'] == 1) {
              ?>
              <div class="alert alert-danger" role="alert" id="signalMessage" value=<?php echo $comment['signal_comment']; ?>>
               Ce commentaire a été signalé le <?php echo $comment['signal_date_fr']; ?>
             </div>

            <?php }  ?>

            <?php
              if(isset($comment['signal_comment']) && $comment['moderation_comment'] == 1) {
                ?>
                <div class="alert alert-success" role="alert" id="signalMessage" value=<?php echo $comment['signal_comment']; ?>>
                  Ce commentaire a été modéré par l'administrateur le <?php echo $comment['moderation_date_fr']; ?>
               </div>

              <?php }  ?>


        </div>

        <?php
            } // Fin de la boucle while des commentaires

        // On termine le traitement de la requête
        $comments->closeCursor();
        ?>
      </div>
    </div>
  </div> <!-- Fin de div container Bootstrap -->

<?php $bodyContent = ob_get_clean(); ?>




<!-- Chargement du template -->
<?php require('view/frontend/template.php'); ?>
