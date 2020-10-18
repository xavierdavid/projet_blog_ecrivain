<?php

// Chargement de la classe Manager pour la connexion à la base de données
require_once('model/Manager.php');



class AdminManager extends Manager { // Héritage des fonctions et propriétés de la classe Manager


    // Gestion de la récupération des données administrateur dans la table 'admin' de la base de données 'blog_ecrivain'
    public function adminIdentification($adminLogin) {

        // Requête effectuée à partir du nom d'utilisateur saisi
        // Appel de la fonction dbConnect() pour se connecter à la base de données
        $db = $this->dbConnect();

        // On prépare la requête avec des marqueurs nominatifs
        $req = $db -> prepare('SELECT id, password FROM admin WHERE login = :login');
        // On exécute la requête SQL pour récupérer l'identifiant, le mot de passe correspondant au login (nom d'utilisateur) de l'administrateur
        $req -> execute(array(
          'login' => $adminLogin
        ));

        // On affiche le résultat et on stocke la valeur dans la variable $adminRequest
        $adminRequest = $req ->fetch();

        // Retour du résultat
        return $adminRequest;
    }
}
