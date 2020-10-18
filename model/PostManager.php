<?php

// Chargement de la classe Manager pour la connexion à la base de données
require_once('model/Manager.php');



class PostManager extends Manager { // Héritage des fonctions et propriétés de la classe Manager


    // Gestion de la récupération de tous les articles publiés
    public function getArticles(){

        // requête SQL pour récupérer le titre, le contenu et la date de publication des articles dans la table "articles" de la base de données "blog_ecrivain"
        // Appel de la fonction dbConnect pour se connecter à la base de données blog_ecrivain //
        $db = $this->dbConnect();

        // Execution d'une requête simple pour afficher les derniers articles publiés dans la base
        $articles = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %H:%i:%s\') AS creation_date_fr FROM articles ORDER BY creation_date DESC');

        // Retour du résultat
        return $articles;
    }



    // Gestion de la récupération d'un article en fonction de son identifiant
    public function getArticle($articleId){

        // requête SQL pour récupérer le titre, le contenu et la date de publication de l'article dans la table "articles" de la base de données "blog_ecrivain"
        // Appel de la fonction dbConnect pour se connecter à la base de données blog_ecrivain //
        $db = $this->dbConnect();

        // Préparation de la requête pour récupérer l'article correspondant à l'identifiant transmis via l'URL du lien //
        $req = $db -> prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %H:%i:%s\') AS creation_date_fr FROM articles WHERE id= ?');

        // Execution de la requête
        $req -> execute(array($articleId));
        $article = $req->fetch();

        // Retour du résultat
        return $article;
    }



    // Gestion de la création d'un nouvel article et son stockage dans la base de données
    public function createArticle($title, $content) {

        // Stockage du titre et du contenu de l'article dans la table "articles" de la base de données "blog_ecrivain"

        // Appel de la fonction dbConnect() pour se connecter à la base de données
        $db = $this->dbConnect();

        // On prépare la requête
        $req = $db -> prepare('INSERT INTO articles(title, content, creation_date) VALUES(?,?, NOW())');
        // On exécute la requête SQL pour insérer les nouvelles entrées
        $newArticle = $req -> execute(array($title, $content));
    }



    // Gestion de la récupération des 3 derniers articles publiés et stockés dans la base de données
    public function getLastArticles(){

        // Requête SQL pour récupérer le titre, le contenu et la date de publication des articles dans la table "articles" de la base de données "blog_ecrivain"
        // Appel de la fonction dbConnect() pour se connecter à la base de données
        $db = $this->dbConnect();

        // Execution d'une requête simple pour afficher les derniers articles publiés
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %H:%i:%s\') AS creation_date_fr FROM articles ORDER BY creation_date DESC LIMIT 0,3');

        // Retour du résultat
        return $req;
    }



    // Gestion de la récupération du nombre total d'articles publiés
    public function countArticles() {

        // Appel de la fonction dbConnect() pour se connecter à la base de données
        $db = $this->dbConnect();

        // Requête simple
        $req = $db->query('SELECT COUNT(*) AS nbArticles FROM articles');

        // On affiche le résultat et on stocke la valeur dans la variable $adminRequest
        $countPostArticles = $req ->fetch();

        // Retour du résultat
        return $countPostArticles;
    }



    // Gestion de la suppression d'un article sélectionné en fonction de son identifiant ...
    public function deleteArticle($articleId) {

        // Appel de la fonction dbConnect() pour se connecter à la base de données
        $db = $this->dbConnect();

        // Execution d'une requête simple pour supprimer un article en fonction de son identifiant
        $req = $db->prepare('DELETE FROM articles WHERE id = ?');

        $req->execute(array($articleId));
    }



    // Gestion de la modification d'un article, en fonction de son identifiant
    public function updateArticle($newArticleTitle,$newArticleContent,$articleId) {

        // Appel de la fonction dbConnect() pour se connecter à la base de données
        $db = $this->dbConnect();

        // On prépare la requête
        $req = $db -> prepare('UPDATE articles SET title = :title, content = :content, creation_date= NOW() WHERE id = :id');
        // On exécute la requête SQL pour modifier l'entrée correspondant à l'identifiant
        $req -> execute(array(
            'title' => $newArticleTitle,
            'content'=> $newArticleContent,
            'id' => $articleId
        ));
    }
}
