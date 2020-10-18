<?php

// Chargement des classes du modèle
require_once('model/PostManager.php');
require_once('model/CommentManager.php');



class CommentController {


   // Contrôle de la publication d'un nouveau commentaire
   public function addComment($articleId, $author, $comment) {

      // Récupération des valeurs des paramètres $articleId, $author et $comment puis transmission au modèle par appel de fonction
      // Création d'un objet commentManager par instanciation
      $commentManager = new CommentManager();
      // Appel de la fonction postComment() de l'objet commentManager
      $newComment = $commentManager->postComment($articleId, $author, $comment);

      // Test du retour de la requête
      if ($newComment === false) {
        // En cas d'erreur, celle-ci est remontée vers le router
        throw new Exception('Impossible d\'ajouter le commentaire !');

      } else {
       // Sinon, on redirige le visiteur vers la page des commentaires correspondant à l'article sélectionné
       // Retour vers le routeur - Le paramètre 'action' prend la valeur 'post' - $articleId  est tranmis dans l'url
       header('Location: index.php?action=post&article_id=' . $articleId);
      }
   }



   // Contrôle du signalement d'un commentaire
   public function addSignal($commentId, $articleId) {

      // Récupération de la valeur du paramètre $commentId puis transmission au modèle
      // Création d'un objet commentManager par instanciation
      $commentManager = new CommentManager();
      // Appel de la fonction postSignalComment() de l'objet commentManager
      $newSignalComment = $commentManager->postSignalComment($commentId);

      // Test du retour de la requête
      if ($newSignalComment === false) {
         // En cas d'erreur, on remonte jusqu'au bloc try du routeur
         throw new Exception('Impossible d\'ajouter le signalement du commentaire !');

      } else {
         // Sinon, on redirige le visiteur vers la page des commentaires correspondant à l'article sélectionné
         // Retour vers le routeur - Le paramètre 'action' prend la valeur 'post'
         // L'identifiant $articleId  est tranmis dans l'url
         // Le routeur appelle du contrôleur article() qui déclenche l'affichage de l'article et de ses commentaires actualisés
         header('Location: index.php?action=post&article_id=' . $articleId);
      }
    }



   // Contrôle de la récupération de tous les commentaires
   public function recoverAllComments() {

      $commentManager = new CommentManager();
      // Appel de la fonction getComments() de l'objet commentManager pour afficher tous les commentaires publiés et leur article associé
      $comments = $commentManager->getAllComments();

      // Appel de la fonction countSignalComments() pour récupérer le nombre total de commentaires signalés
      $countSignalComments = $commentManager->countSignalComments();

      $postManager = new PostManager();
      // Appel de la fonction countArticles() de l'objet postManager pour récupérer le nombre total d'articles publiés
      $countPostArticles = $postManager->countArticles();

      // Chargement de la vue commentsView.php
      require('view/backend/commentsView.php');
   }



   // Contrôle de la récupération de tous les commentaires signalés
   public function recoverSignalComments() {

      $commentManager = new CommentManager();
      // Appel de la fonction getSignalComments() de l'objet commentManager pour afficher tous les commentaires signalés
      $signalComments = $commentManager->getThisSignalComments();

      // Appel de la fonction countComments() pour récupérer le nombre total de commentaires publiés
      $countPostComments = $commentManager->countComments();

      $postManager = new PostManager();
      // Appel de la fonction countArticles() de l'objet postManager pour récupérer le nombre total d'articles publiés
      $countPostArticles = $postManager->countArticles();

      // Chargement de la vue signalCommentsView.php
      require('view/backend/signalCommentsView.php');
   }



   // Contrôle de la modification d'un commentaire
   public function moderateComment() {

      $commentManager = new CommentManager();
      // Appel de la fonction getComment() de l'objet commentManager pour afficher le commentaire sélectionné selon son identifiant
      $detailComment = $commentManager->getComment($_GET['comment_id']);

      // Appel de la fonction getSignalComments() de l'objet commentManager pour afficher tous les commentaires publiés
      $signalComments = $commentManager->getSignalComments();

      // Appel de la fonction countComments() pour récupérer le nombre total de commentaires publiés
      $countPostComments = $commentManager->countComments();

      $postManager = new PostManager();
      // Appel de la fonction getArticle() de l'objet postManager pour afficher l'article sélectionné selon son identifiant
      $detailArticle = $postManager->getArticle($_GET['article_id']);

      // Appel de la fonction countArticles() pour récupérer le nombre total d'articles publiés
      $countPostArticles = $postManager->countArticles();

      // Chargement de la vue signalCommentsView.php
      require('view/backend/detailCommentView.php');
   }



   // Contrôle de la suppression d'un commentaire
   public function deleteThisComment() {

      $commentManager = new CommentManager();
      // Appel de la fonction deleteComment de l'objet commentManager
      $commentManager->deleteComment($_GET['comment_id']);

      // Redirection vers le router pour l'affichage de l'éditeur d'article
      header('Location: index.php?action=recover_comments');
   }



   // Contrôle de la récupération d'un commentaire et de son article associé
   public function recoverThisComment() {

      $commentManager = new CommentManager();
      // Appel de la fonction getThisComment() de l'objet commentManager pour afficher le commentaire sélectionné selon son identifiant avec son article associé
      $detailComment = $commentManager->getThisComment($_GET['comment_id']);

      // Chargement de la vue updateArticleView.php
      require('view/backend/updateCommentView.php');
   }



   // Contrôle de la mise à jour d'un commentaire
   public function updateThisComment() {

      // Récupération des informations saisies via le formulaire d'édition de commentaire //
      // Protection contre d'éventuelles faille SSX
      $_POST['comment'] = htmlspecialchars(($_POST['comment']));

      // Test : on vérifie que l'administrateur a bien soumis la publication de l'article qu'il souhaite modifier
      if (isset($_POST['comment_publication']) && $_POST['comment_publication'] == 'comment_publish') {

        // On vérifie préalablement que le contenu du commentaire a bien été saisis et envoyé
        if (isset($_POST['comment']) && !empty($_POST['comment']))  {

          $commentManager = new CommentManager();
          // Appel de la fonction updateArticle() de l'objet commentManager
          $commentManager->updateComment($_POST['comment'],$_GET['comment_id']);

          // Redirection vers le rooter pour l'affichage des commentaires
          header('Location: index.php?action=recover_comments');

        } else {
          // Alors on affiche un message invitant l'administrateur à saisir les champs manquants
          echo '<p class="form_message">Veuillez saisir un contenu pour le commentaire</p>';
        }
      }
   }
}
