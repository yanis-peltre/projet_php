<?php

class Authentification
{

    private $authSessionVar;

    public static function createUser ( $userid, $password ) {

        // Teste taille du password.
        if(strlen($password) < 12){
            throw new Error("Le password doit avoir au moins 12 caractères");
        }
        // Teste au moins 1 majuscule.
        $passwordTestNbMajs = preg_replace('#[a-z]*#', '', $password);
        $nbmaj = strlen($passwordTestNbMajs);
        if ($nbmaj == 0)
        {
            throw new Error("Le password doit avoir au moins une majuscule");
        }

        // si ok : hacher $password
        password_hash($password, PASSWORD_DEFAULT, ['cost'=> 10]);


     // créer et enregistrer l'utilisateur
    }

    public static function authenticate ( $userid, $password ) {
        // charger utilisateur $user
        // vérifier $user->hash == hash($password)
        // charger profil ($user->id)
    }

    private static function loadProfile( $userid ) {
        // charger l'utilisateur et ses droits
        // détruire la variable de session
        // créer variable de session = profil chargé
    }

    public static function checkAccessRights ( $required ) {
   /** si Authentication::$profil['level] < $required
     throw new AuthException ;*/
    }

}