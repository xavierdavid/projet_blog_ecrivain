<?php


class Manager {

    protected function dbConnect(){
      // Connexion à la base de données blog_ecrivain //

           $db = new PDO('mysql:host=localhost;dbname=xavdavid28_blog_ecrivain;charset=utf8', 'xavdavid28_admin', 'saI[?s}4X]hg', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
           // Retour du résultat
           return $db;

    }
}
