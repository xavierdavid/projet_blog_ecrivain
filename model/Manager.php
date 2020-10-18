<?php


class Manager {

    protected function dbConnect(){
      // Connexion à la base de données blog_ecrivain //

           $db = new PDO('mysql:host=localhost;dbname=xavdavid28_blog_ecrivain;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
           // Retour du résultat
           return $db;
    }
}
