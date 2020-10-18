<?php

// Ouverture de session
session_start();

// Chargement des classes du contrôleur
require_once('controller/AdminController.php');
require_once('controller/PostController.php');
require_once('controller/CommentController.php');


try { // Gestion des erreurs du rooter - Ajout d'exceptions

    // Appel des classes du contrôleur
    $postController = new PostController(); // Création d'un objet PostController par instanciation
    $commentController = new CommentController(); // Création d'un objet CommentController par instanciation
    $adminController = new AdminController(); // Création d'un objet AdminController par instanciation


    // Gestion des actions : test du paramètre 'action' pour le choix du contrôleur
    if (isset($_GET['action'])) {

        if ($_GET['action'] == 'listArticles') {
        // Appel de la fonction listArticles() de l'objet PostController
        $postController->listArticles();

        } elseif ($_GET['action'] == 'listAllArticles') {
          // Appel de la fonction listArticles() de l'objet PostController
          $postController->listAllArticles();

        } elseif ($_GET['action'] == 'post') {

            // Test : on vérifie qu'on a bien reçu l'identifiant 'article_id' du post dans l'url du lien 'commentaires'
            if (isset($_GET['article_id']) && $_GET['article_id'] > 0) {
                // Appel de la fonction article() de l'objet PostController
                $postController->article();
            } else {
                // Erreur - Envoi d'exception et renvoi vers catch
                throw new Exception('Erreur : aucun identifiant d\'article envoyé');
            }

        } elseif ($_GET['action'] == 'addComment') {

            // On récupère les informations saisies dans le formulaire d'ajout de commentaires
            // Protection contre d'éventuelles failles XSS
            $_POST['author'] = htmlspecialchars($_POST['author']);
            $_POST['comment'] = htmlspecialchars($_POST['comment']);

            // Test : on vérifie qu'on a bien reçu l'identifiant 'article_id' du post dans l'url lors de l'envoi du formulaire d'ajout de commentaires
            if (isset($_GET['article_id']) && $_GET['article_id'] > 0) {

                // Test : on vérifie également qu'un nom d'auteur et un commentaire ont bien été envoyés
                if(!empty($_POST['author']) && !empty($_POST['author'])) {
                    // On appelle de la fonction addComment() de l'objet CommentController avec les trois paramètres suivants :
                    $commentController->addComment($_GET['article_id'], $_POST['author'], $_POST['comment']);
                } else {
                    // Erreur - Envoi d'exception et renvoi vers catch
                    throw new Exception('Erreur : tous les champs ne sont pas remplis !');
                }
            } else {
                // Erreur - Envoi d'exception et renvoi vers catch
                throw new Exception('Erreur : aucun identifiant d\'article envoyé');
            }

        } elseif ($_GET['action'] == 'signal') {

            // Test : on vérifie qu'on a bien reçu l'identifiant 'article_id' du post dans l'url lors de l'envoi du formulaire d'ajout de commentaires
            if (isset($_GET['article_id']) && $_GET['article_id'] > 0) {
                // Test : on vérifie qu'on a bien reçu l'identifiant du commentaire à signaler
                if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                    // Appel du contrôleur addSignal avec comme paramètre l'identifiant du commentaire
                    $commentController->addSignal($_GET['comment_id'], $_GET['article_id']);
                } else {
                    // Erreur - Envoi d'exception et renvoi vers catch
                    throw new Exception('Erreur : aucun identifiant de commentaire envoyé');
                }
            } else {
                // Erreur - Envoi d'exception et renvoi vers catch
                throw new Exception('Erreur : aucun identifiant d\'article envoyé');
            }

        } elseif ($_GET['action'] == 'login') {
            // Appel du contrôleur adminVerification()
            $adminController->adminVerification();

        } elseif ($_GET['action'] == 'create') {
            // Appel du contrôleur createNewArticle()
            $postController->createNewArticle();

        } elseif ($_GET['action'] == 'edition') {
            if (isset($_GET['article_id']) && $_GET['article_id'] > 0) {
                // Appel du contrôleur articleEdition()
                $postController->articleEdition();
            } else {
                // Erreur - Envoi d'exception et renvoi vers catch
                throw new Exception('Erreur : aucun identifiant d\'article envoyé');
            }

        } elseif ($_GET['action'] == 'delete') {
            if (isset($_GET['article_id']) && $_GET['article_id'] > 0) {
                // Appel du contrôleur deleteThisArticle()
                $postController->deleteThisArticle();
            } else {
                // Erreur - Envoi d'exception et renvoi vers catch
                throw new Exception('Erreur : aucun identifiant d\'article envoyé');
            }

        } elseif ($_GET['action'] == 'recover') {
            if (isset($_GET['article_id']) && $_GET['article_id'] > 0) {
                // Appel du contrôleur recoverThisArticle()
                $postController->recoverThisArticle();
            } else {
                // Erreur - Envoi d'exception et renvoi vers catch
                throw new Exception('Erreur : aucun identifiant d\'article envoyé');
            }

        } elseif ($_GET['action'] == 'update') {
            if (isset($_GET['article_id']) && $_GET['article_id'] > 0) {
                // Appel du contrôleur updateThisArticle()
                $postController->updateThisArticle();
            } else {
                // Erreur - Envoi d'exception et renvoi vers catch
                throw new Exception('Erreur : aucun identifiant d\'article envoyé');
            }

        } elseif ($_GET['action'] == 'recover_comments') {
            // Appel du contrôleur recoverAllComments()
            $commentController->recoverAllComments();

        } elseif ($_GET['action'] == 'recover_articles') {
            // Appel du contrôleur recoverAllArticles()
            $postController->recoverAllArticles();

        } elseif ($_GET['action'] == 'recover_signalComments') {
            // Appel du contrôleur recoverSignalComments()
            $commentController->recoverSignalComments();

        } elseif ($_GET['action'] == 'moderation') {
            if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0 && isset($_GET['article_id']) && $_GET['article_id'] > 0) {
                // Appel du contrôleur moderateComment()
                $commentController->moderateComment();
            } else {
                  // Erreur - Envoi d'exception et renvoi vers catch
                  throw new Exception('Erreur : aucun identifiant d\'article ou de commentaire envoyé');
            }

        } elseif ($_GET['action'] == 'delete_comment') {
            if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                // Appel du contrôlleur deleteThisComment()
                $commentController->deleteThisComment();
            } else {
                  // Erreur - Envoi d'exception et renvoi vers catch
                  throw new Exception('Erreur : aucun identifiant de commentaire envoyé');
            }

        } elseif ($_GET['action'] == 'recover_comment') {
            if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0 && isset($_GET['article_id']) && $_GET['article_id'] > 0) {
                // Appel du contrôleur recoverThisComment()
                $commentController->recoverThisComment();
            } else {
                // Erreur - Envoi d'exception et renvoi vers catch
                throw new Exception('Erreur : aucun identifiant d\'article ou de commentaire envoyé');
            }

        } elseif ($_GET['action'] == 'update_comment') {
            if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                // Appel du contrôlleur deleteThisComment()
                $commentController->updateThisComment();
            } else {
                // Erreur - Envoi d'exception et renvoi vers catch
                throw new Exception('Erreur : aucun identifiant de commentaire envoyé');
            }
        } elseif ($_GET['action'] == 'logout') {
          // Appel du contrôleur adminLogout()
          $adminController->adminLogout();
        }

    } else {
      $postController->listArticles(); // Appel par défaut de la fonction listArticles() de l'objet PostController
    }

}


// Centralisation des erreurs dans le bloc catch du router
catch(Exception $e) { // En cas d'erreur, on execute le code ci-après ...
  echo 'Erreur : ' . $e->getMessage();
  // Création d'une vue spécifique pour l'affichage des erreurs
  // $errorMessage = $e->getMessage();
  // require('view/errorView.php');
}
