<?php

// Chargement de la classe Manager pour la connexion à la base de données
require_once('model/AdminManager.php');



class AdminController {


    public function adminVerification() {

      // Chargement de la vue connexion.php
      require('view/backend/connexionView.php');

      // Récupération des informations saisies via le formulaire de connexion
      // Protection contre d'éventuelles faille SSX
      $_POST['login'] = htmlspecialchars(($_POST['login']));
      $_POST['password'] = htmlspecialchars(($_POST['password']));

      // Test : vérification des données saisies dans le formulaire de connexion
      // On vérifie que l'utilisateur a soumis le formulaire de login
      if (isset($_POST['connexion']) AND $_POST['connexion'] == 'Entrer') {

        // On vérifie préalablement que le login et le mot de passe ont bien été saisis et envoyés via le formulaire
        // ... et que les valeurs de 'login' et 'password' ne sont pas nulles
        if (isset($_POST['login']) AND !empty($_POST['login']) AND isset($_POST['password']) AND !empty($_POST['password'])){
            // et si tel est le cas, alors on effectue la suite des opérations ...

            $adminManager = new AdminManager(); // Création d'un nouvel objet AdminManager par instanciation
            // Appel de la fonction adminIdentification() de l'objet AdminManager pour récupérer les informations de l'administrateur
            $adminRequest = $adminManager->adminIdentification($_POST['login']);

            // Hachage du mot de passe saisi dans le formulaire de login et comparaison avec celui stocké dans la table 'admin'
            $passwordCorrect = password_verify($_POST['password'], $adminRequest['password']);

            // Si la requête n'obtient pas de résultat (le nom d'utilisateur n'est pas présent dans la base), ...
            if (!$adminRequest){
                // ... on affiche un message d'alerte
                echo '<p class="form_message">Mauvais identifiant ou mauvais mot de passe !</p>';

            // Sinon, s'il y a un résultat (et donc un nom d'utilisateur correspondant) ...
            } else {
                // ... et si les deux mots de passe sont identiques, ...
                if ($passwordCorrect){
                    // ... alors on démarre une nouvelle session
                    session_start();
                    // On stocke l'identifiant 'id' et le 'login' dans des variables de session
                    $_SESSION['id'] = $adminRequest['id'];
                    $_SESSION['login'] = $_POST['login'];
                    // Redirection vers le routeur - Le paramètre 'action' prend la valeur 'create'
                    // Le routeur appelle du contrôleur article() qui déclenche l'affichage de l'article et de ses commentaires actualisés
                    header('Location: index.php?action=create');

                } else {
                    // Et on affiche le message d'erreur
                    echo '<p class="form_message">Mauvais identifiant ou mauvais mot de passe !</p>';
                }
            }

            // Définition de cookies pour la connexion automatique de l'administrateur
            // Le cookie est sécurisé avec l'option httpOnly (true)
            // On vérifie si l'admnistrateur a coché l'option "connexion automatique"
            if (isset($_POST['autoConnexion'])) {
                // Si la case est cochée, alors on stocke le login et le password dans des cookies
                setcookie('login', $_POST['login'], time() + 365*24*3600, null, null, false, true);
                setcookie('password', $_POST['password'], time() + 365*24*3600, null, null, false, true);
                // Ces cookies serviront à pré-remplir la mire de login lors de la prochaine connexion

            } else {
                // Si l'option "connexion automatique" n'est pas cochée, ...
                // ... on supprime les cookies de connexion automatique
                setcookie('login', '');
                setcookie('password', '');
            }

        } else {
          // Alors on affiche un message invitant l'administrateur à saisir les champs manquants
          echo '<p class="form_message">Tous les champs doivent être renseignés</p>';
        }
      }
    }

    public function adminLogout(){
      // Suppression des variables de session et de la session
      $_SESSION = array();
      session_destroy();
      // Redirection vers le routeur et la vue listArticlesView.php
      header('Location: index.php?action=listArticles');
    }
}
