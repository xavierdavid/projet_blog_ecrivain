<?php

// Chargement des classes du modèle
require_once('model/PostManager.php');
require_once('model/CommentManager.php');



class PostController {


    // Contrôle de l'affichage des derniers articles publiés
    public function listArticles(){

      // Création d'un objet PostManager par instanciation
      $postManager = new PostManager();
      // Appel de la fonction getLastArticles de l'objet postManager
      $articles = $postManager->getLastArticles();
      // Appel de la fonction countArticles de l'objet postManager
      $countPostArticles = $postManager->countArticles();

      // Chargement de la vue listArticlesView.php pour l'affichage des résultats
      require('view/frontend/listArticlesView.php');
    }



    // Contrôle de l'affichage de tous les articles publiés
    public function listAllArticles(){

      // Création d'un objet PostManager par instanciation
      $postManager = new PostManager();
      // Appel de la fonction getArticles de l'objet postManager
      $articles = $postManager->getArticles();

      // Chargement de la vue listArticlesView.php pour l'affichage des résultats
      require('view/frontend/listAllArticlesView.php');
    }



    // Contrôle de l'affichage d'un article (selon son identifiant) et de ses commentaires associés
    public function article() {
      // Création d'un objet PostManager par instanciation
      $postManager = new PostManager();
      // Appel de la fonction getArticle de l'objet PostManager
      $article = $postManager->getArticle($_GET['article_id']);
      // Appel de la fonction countArticles de l'objet postManager
      $countPostArticles = $postManager->countArticles();
      // Création d'un objet CommentManager par instanciation
      $commentManager = new CommentManager();
      // Appel de la fonction getComments de l'objet commentManager
      $comments = $commentManager->getComments($_GET['article_id']);

      // Chargement de la vue postView.php pour l'affichage des résultats
      require('view/frontend/postView.php');
    }



    // Contrôle de la création d'un nouvel article
    public function createNewArticle() {

      // Récupération des informations saisies via l'éditeur d'articles Tiny MCE
      // Protection contre d'éventuelles faille SSX
      $_POST['articleTitle'] = htmlspecialchars(($_POST['articleTitle']));

      // Test : vérification des données saisies dans l'éditeur Tiny MCE
      // On vérifie que l'administrateur a bien soumis la publication de son article
      if(isset($_POST['publication']) && $_POST['publication'] == 'publish') {

        // On vérifie préalablement que le titre et le contenu de l'article ont bien été saisis et envoyés
        if(isset($_POST['articleTitle']) && !empty($_POST['articleTitle']) && isset($_POST['articleContent']) && !empty($_POST['articleContent'])) {

          $postManager = new PostManager(); // Création d'un nouvel objet PostManager par instanciation
          // Appel de la fonction createArticle() de l'objet PostManager pour stocker le titre et le contenu de l'article dans la base de données
          $newArticle = $postManager->createArticle($_POST['articleTitle'], $_POST['articleContent']);

        } else {
          // Alors on affiche un message invitant l'administrateur à saisir les champs manquants
          echo '<p class="form_message">Veuillez saisir le titre et le contenu de l\'article</p>';
        }
      }

      $postManager = new PostManager(); // Création d'un nouvel objet PostManager par instanciation
      // Appel de la fonction getAllArticles() de l'objet PostManager pour afficher tous les articles publiés
      $req = $postManager->getLastArticles();

      // Appel de la fonction countArticles() de l'objet PostManager pour récupérer le nombre total d'articles publiés
      $countPostArticles = $postManager->countArticles();

      $commentManager = new CommentManager(); // Création d'un nouvel objet PostManager par instanciation
      // Appel de la fonction countComments() pour récupérer le nombre total de commentaires publiés
      $countPostComments = $commentManager->countComments();

      // Chargement de la vue createArticleView.php
      require('view/backend/createArticleView.php');
    }



    // Contrôle de l'édition d'un nouvel article
    public function articleEdition() {

      $postManager = new PostManager();
      // Appel de la fonction getArticle() de l'objet PostManager pour afficher l'article sélectionné selon son indentifiant
      $article = $postManager->getArticle($_GET['article_id']);

      // Appel de la fonction countArticles() pour récupérer le nombre total d'articles publiés
      $countPostArticles = $postManager->countArticles();

      $commentManager = new CommentManager();
      // Appel de la fonction countComments() de l'objet CommentManager pour récupérer le nombre total de commentaires publiés
      $countPostComments = $commentManager->countComments();

      // Chargement de la vue detailArticleView.php
      require('view/backend/detailArticleView.php');
    }



    // Contrôle de la suppression d'un article et de ses commentaires associés
    public function deleteThisArticle() {

      $postManager = new PostManager();
      // Appel de la fonction deleteArticle() de l'objet PostManager
      $postManager->deleteArticle($_GET['article_id']);

      $commentManager = new CommentManager();
      // Appel de la fonction deleteComments de l'objet CommentManager
      $commentManager->deleteComments($_GET['article_id']);

      // Redirection vers le rooter pour l'affichage de l'éditeur d'article
      header('Location: index.php?action=create');
    }



    // Contrôle de la récupération des données d'un article (selon son identifiant)
    public function recoverThisArticle() {

      $postManager = new PostManager();
      // Appel de la fonction getArticle() de l'objet PostManager pour afficher l'article sélectionné selon son identifiant
      $article = $postManager->getArticle($_GET['article_id']);

      // Chargement de la vue updateArticleView.php
      require('view/backend/updateArticleView.php');
    }



    // Contrôle de la modification d'un article
    public function updateThisArticle() {

      // Récupération des informations saisies via l'éditeur d'articles Tiny MCE //
      // Protection contre d'éventuelles faille SSX
      $_POST['articleTitle'] = htmlspecialchars(($_POST['articleTitle']));

      // Test : on vérifie que l'administrateur a bien soumis la publication de l'article qu'il souhaite modifier
      if(isset($_POST['publication']) && $_POST['publication'] == 'publish') {

        // On vérifie préalablement que le titre et le contenu de l'article ont bien été saisis et envoyés
        if(isset($_POST['newArticleTitle']) && !empty($_POST['newArticleTitle']) && isset($_POST['newArticleContent']) && !empty($_POST['newArticleContent'])) {

          $postManager = new PostManager();
          // Appel de la fonction updateArticle() de l'objet PostManager
          $postManager->updateArticle($_POST['newArticleTitle'],$_POST['newArticleContent'],$_GET ['article_id']);

          // Redirection vers le rooter pour l'affichage de l'éditeur d'article
          header('Location: index.php?action=create');

        } else {
          // Alors on affiche un message invitant l'administrateur à saisir les champs manquants
          echo '<p class="form_message">Veuillez saisir le titre et le contenu de l\'article</p>';
        }
      }
    }



    // Contrôle de la récupération de tous les articles publiés
    public function recoverAllArticles() {

      $postManager = new PostManager();
      // Appel de la fonction getAllArticles() de l'objet PostManager pour afficher tous les articles publiés
      $articles = $postManager->getArticles();

      $commentManager = new CommentManager();
      // Appel de la fonction countComments() pour récupérer le nombre total de commentaires publiés
      $countPostComments = $commentManager->countComments();

      // Chargement de la vue articlesView.php
      require('view/backend/articlesView.php');
    }

}
