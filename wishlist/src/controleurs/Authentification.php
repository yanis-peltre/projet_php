<?php

namespace mywishlist\controleurs;

use mywishlist\exceptions\AuthException;
use mywishlist\exceptions\InscriptionException;
use mywishlist\models\User;

class Authentification
{

    private $authSessionVar;

    /**
     * Crée un utilisateur
     * @param $username String nom d'utilisateur
     * @param $password String mot de passe
     * @throws InscriptionException
     */
    public static function createUser ($username, $password, $userRights){
        // Teste taille du password.
        if(strlen($password) < 12){
            throw new InscriptionException("Le password doit avoir au moins 12 caractères");
        }
        // Teste au moins 1 majuscule.
        $passwordTestNbMajs = preg_replace('#[a-z]*#', '', $password);
        $nbmaj = strlen($passwordTestNbMajs);
        if ($nbmaj == 0)
        {
            throw new InscriptionException("Le password doit avoir au moins une majuscule");
        }

        // si ok : hacher $password
        password_hash($password, PASSWORD_DEFAULT, ['cost'=> 10]);


     // créer et enregistrer l'utilisateur
        $user = new User();
        $user->inscrireUser($username, $password, $userRights);
        $userid = $user->userid;
        self::loadProfile($userid);

    }

    /**
     * @throws AuthException
     */
    public static function authenticate ($username, $password ) {
        // charger utilisateur $user
        $user = User::firstWhere('username',$username);
        $passwordHash = $user->password;

        // vérifier $user->hash == hash($password)
        $isPasswordMatching = password_verify($password,$passwordHash);

        // charger profil ($user->id)
        if($isPasswordMatching){
            $userid = $user->userid;
            self::loadProfile($userid);
        }
        else{
            throw new AuthException("Mauvais nom d'utilisateur ou mot de passe");
        }
    }

    private static function loadProfile( $userid ) {
        // charger l'utilisateur et ses droits
        $user = User::firstWhere('userid',$userid);
        $ipClient = $_SERVER['REMOTE_ADDR'];
        $role = $user->role()->first();
        $authentification_level = $role->auth_level;
        // détruire la variable de session
        if(isset($_SESSION['userid'])){
            unset($_SESSION['userid']);
        }
        // créer variable de session = profil chargé
        $_SESSION['profile'] = [
            'username' => $user->username,
            'userid' => $userid,
            'role_id' => $role->id,
            'client_ip' => $ipClient,
            'auth_level' => $role->auth_level
        ];
    }

    public static function checkAccessRights ( $required ) {
   /** si Authentication::$profil['level] < $required
     throw new AuthException ;*/
    }

    /**
     * Deconnecte l'utilisateur
     */
    public static function deconnexion(){
            unset($_SESSION['profile']);
    }

}