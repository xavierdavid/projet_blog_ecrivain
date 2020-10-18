<?php

// Chargement de la classe Manager pour la connexion à la base de données
require_once('model/Manager.php');



class CommentManager extends Manager { // Héritage des fonctions et propriétés de la classe Manager


    // Gestion de la récupération des commentaires en fonction de l'identifiant d'un article
    public function getComments($articleId){

      // requête SQL pour récupérer l'auteur, le contenu et la date de publication des commentaires dans la table "comments" de la base de données "blog_ecrivain"
      // Appel de la fonction dbConnect pour se connecter à la base de données blog_ecrivain //
      $db = $this->dbConnect();

      // Récupération des entrées des commentaires correspondant à l'identifiant de l'article
      // On prépare la requête dans sa partie variable à l'aide d'une marqueur nominatif pour l'identifiant (:id_billet)
      // On récupère les entrées auteur, commentaire, date au format français (alias date_creation_fr) ...
      // ... mais seulement pour les entrées correspondant à l'identifiant transmis via l'url

      $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date,\'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr, signal_comment, DATE_FORMAT(signal_date,\'%d/%m/%Y à %Hh%imin%ss\') AS signal_date_fr, moderation_comment, DATE_FORMAT(moderation_date,\'%d/%m/%Y à %Hh%imin%ss\') AS moderation_date_fr FROM comments WHERE post_id = ? ORDER BY comment_date DESC');

      // On exécute la requête
      $comments->execute(array($articleId));

      // Retour du résultat
      return $comments;
    }



    // Gestion du stockage des commentaires rattachés à l'identifiant d'un article
    public function postComment($articleId, $author, $comment) {

      // Requête SQL pour stocker l'id de l'article en cours, l'auteur, le contenu et la date de publication du commentaire dans la table "comments" de la base de données "blog_ecrivain"
      // Appel de la fonction dbConnect pour se connecter à la base de données blog_ecrivain //
      $db = $this->dbConnect();

      // On prépare la requête
      $comments = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?,?,?, NOW())');
      // On exécute la requête SQL pour insérer les nouvelles entrées
      // L'entrée post_id du commentaire prendra la valeur de l'identifiant de l'article sélectionné

      $newComment = $comments-> execute(array($articleId, $author, $comment));

      // Retour du résultat
      return $newComment;
    }



    // Gestion du stockage du signalement rattaché à l'identifiant d'un commentaire
    public function postSignalComment($commentId) {

      // Requête SQL pour mettre à jour le commentaire en cours dans la table "comments" de la base de données "blog_ecrivain" ...
      // ... en ajoutant le signalement qui prend la valeur 'true'
      $newSignal = true;

      // Appel de la fonction dbConnect pour se connecter à la base de données blog_ecrivain //
      $db = $this->dbConnect();

      // On prépare la requête
      $comments = $db->prepare('UPDATE comments SET signal_comment= :newSignal, signal_date= NOW() WHERE id= :commentId');

      $newSignalComment = $comments->execute(array(
        'newSignal' => $newSignal,
        'commentId' => $commentId
      ));

      // Retour du résultat
      return $newSignalComment;
    }



    // Gestion de la récupération du nombre total de commentaires publiés
    public function countComments() {

      // Appel de la fonction dbConnect() pour se connecter à la base de données
      $db = $this->dbConnect();

      // Requête simple
      $req = $db->query('SELECT COUNT(*) AS nbComments FROM comments');

      // On affiche le résultat et on stocke la valeur dans la variable $adminRequest
      $countPostComments = $req ->fetch();

      // Retour du résultat
      return $countPostComments;
    }




    // Gestion de la récupération du nombre total de commentaires signalés
    public function countSignalComments() {

      $signal = true;

      // Appel de la fonction dbConnect() pour se connecter à la base de données
      $db = $this->dbConnect();

      // Requête simple
      $req = $db->prepare('SELECT COUNT(*) AS nbSignalComments FROM comments WHERE signal_comment=?');

      // On exécute la requête
      $req -> execute(array($signal));

      // On affiche le résultat et on stocke la valeur dans la variable $countSignalComments
      $countSignalComments = $req ->fetch();

      // Retour du résultat
      return $countSignalComments;
    }



    // Gestion de la suppression de tous les commentaires rattachés à un article
    public function deleteComments($articleId) {

      // Appel de la fonction dbConnect() pour se connecter à la base de données
      $db = $this->dbConnect();

      $req = $db->prepare('DELETE FROM comments WHERE post_id = ?');

      $req->execute(array($articleId));
    }



    // Gestion de la récupération de tous les commentaires et de leurs articles associés
    public function getAllComments() {

      // Appel de la fonction dbConnect()
      $db = $this->dbConnect();

      // Exécution d'une requête simple pour récupérer tous les commentaires publiés et leur article associé
      // Jointure interne des tables articles et comments
      $comments = $db->query('SELECT a.id AS id_articles,a.title AS title_articles, a.content AS content_articles, c.id AS id_comments, c.post_id AS post_id_comments, c.author AS author_comments, c.comment AS comment_comments, DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %H:%i:%s\') AS comment_date_fr, c.signal_comment AS signal_comment, DATE_FORMAT(c.signal_date, \'%d/%m/%Y à %H:%i:%s\') AS signal_date_fr, c.moderation_comment AS moderation_comment_comments, DATE_FORMAT(c.moderation_date, \'%d/%m/%Y à %H:%i:%s\') AS moderation_date_fr FROM comments c INNER JOIN articles a ON c.post_id = a.id ORDER BY comment_date DESC');

      // Retour du résultat
      return $comments;
    }



    // Gestion de la récupération d'un commentaire à partir de son identifiant
    public function getComment($Id) {

      //Appel de la fonction dbConnect()
      $db = $this->dbConnect();

      // On prépare la requête
      $req = $db -> prepare('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %H:%i:%s\') AS comment_date_fr, signal_comment, DATE_FORMAT(signal_date, \'%d/%m/%Y à %H:%i:%s\') AS signal_date_fr FROM comments WHERE id = ?');

      // Execution de la requête
      $req -> execute(array($Id));

      // Affichage du résultat et stockage de la valeur dans la variable $detailArticle
      $detailComment = $req -> fetch();

      // Retour du résultat
      return $detailComment;
    }



    // Gestion de la récupération d'un commentaire et de son article associé à partir de l'identifiant du commentaire
    public function getThisComment($Id) {

      //Appel de la fonction dbConnect()
      $db = $this->dbConnect();

      // On prépare la requête
      // Jointure interne des tables articles et comments
      $req = $db -> prepare('SELECT a.id AS id_articles,a.title AS title_articles, a.content AS content_articles, c.id AS id_comments, c.post_id AS post_id_comments, c.author AS author_comments, c.comment AS comment_comments, DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %H:%i:%s\') AS comment_date_fr, c.signal_comment AS signal_comment, DATE_FORMAT(c.signal_date, \'%d/%m/%Y à %H:%i:%s\') AS signal_date_fr FROM comments c INNER JOIN articles a ON c.post_id = a.id WHERE c.id = ? ORDER BY comment_date DESC');

      // Execution de la requête
      $req -> execute(array($Id));

      // Affichage du résultat et stockage de la valeur dans la variable $detailArticle
      $detailComment = $req -> fetch();

      // Retour du résultat
      return $detailComment;
    }



    // Gestion de la récupération de tous les commentaires signalés
    public function getSignalComments() {

      $signal = true;

      //Appel de la fonction dbConnect()
      $db = $this->dbConnect();

      // Préparation de la requête
      $signalComments = $db->prepare('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %H:%i:%s\') AS comment_date_fr, DATE_FORMAT(signal_date, \'%d/%m/%Y à %H:%i:%s\') AS signal_date_fr FROM comments WHERE signal_comment = ? ORDER BY signal_date DESC');

      // Exécution de la requête
      $signalComments->execute(array($signal));

      // Retour du résultat
      return $signalComments;
    }



    // Gestion de la récupération de tous les commentaires signalés et leur article associé
    public function getThisSignalComments() {

      $signal = true;

      //Appel de la fonction dbConnect()
      $db = $this->dbConnect();

      // Préparation de la requête
      // Jointure interne des tables articles et comments
      $signalComments = $db->prepare('SELECT a.id AS id_articles,a.title AS title_articles, a.content AS content_articles, c.id AS id_comments, c.post_id AS post_id_comments, c.author AS author_comments, c.comment AS comment_comments, DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %H:%i:%s\') AS comment_date_fr, c.signal_comment AS signal_comment, DATE_FORMAT(c.signal_date, \'%d/%m/%Y à %H:%i:%s\') AS signal_date_fr FROM comments c INNER JOIN articles a ON c.post_id = a.id WHERE signal_comment = ? ORDER BY signal_date DESC');

      // Exécution de la requête
      $signalComments->execute(array($signal));

      // Retour du résultat
      return $signalComments;
    }



    // Gestion de la suppression d'un commentaire à partir de son identifiant
    public function deleteComment($commentId) {

      // Appel de la fonction dbConnect() pour se connecter à la base de données
      $db = $this->dbConnect();

      $req = $db->prepare('DELETE FROM comments WHERE id = ?');

      $req->execute(array($commentId));
    }



    // Gestion de la modification d'un commentaire à partir de son identifiant
    public function updateComment($commentContent,$commentId) {

      $moderation = true;

      // Appel de la fonction dbConnect() pour se connecter à la base de données
      $db = $this->dbConnect();

      // On prépare la requête
      $req = $db -> prepare('UPDATE comments SET comment = :newComment, signal_comment = :newSignalComment, moderation_comment = :newModerationComment, moderation_date= NOW() WHERE id= :commentId');
      // On exécute la requête SQL pour modifier l'entrée correspondant à l'identifiant
      $req -> execute(array(
        'newComment' => $commentContent,
        'newModerationComment' => $moderation,
        'newSignalComment' => "0",
        'commentId' => $commentId

      ));
    }
}
