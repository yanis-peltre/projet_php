<?php declare(strict_types = 1);

namespace mywishlist\controleurs;

use mywishlist\exceptions\AuthException;
use mywishlist\exceptions\InscriptionException;
use mywishlist\models\Role;
use mywishlist\models\User;

class Authentification
{

    private $authSessionVar;
    public static int $ADMIN_RIGHTS = 10000;
    public static int $CREATOR_RIGHTS = 5000;

    /**
     * Crée un utilisateur
     * @param $username String nom d'utilisateur
     * @param $password String mot de passe
     * @param $roleId string label du role à donner
     * @throws InscriptionException si le mot de passe ne correspond pas aux prérequis
     */
    public static function createUser ($username, $password, $role, $email){
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
        $roleId = Role::firstWhere('label',$role)->roleid;
        $user = new User();
        $user->inscrireUser($username, $password, $roleId,$email);
        $userid = $user->userid;
        self::loadProfile($userid);

    }

    /**
     * Teste la connexion de l'utilisateur
     * @param $username string Username de l'utilisateur
     * @param $password string Password de l'utilsateur
     * @throws AuthException si l'identifiant ou le mot de passe ne sont pas les bons
     */
    public static function authenticate ($username, $password ) {
        // charger utilisateur $user
        $user = User::firstWhere('username',$username);
        if(!isset($user)) throw new AuthException("Mauvais nom d'utilisateur ou mot de passe");
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

    /**
     * Charge le profiil de l'utilisateur et le connecte
     * @param $userid
     */
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

    /**
     * Teste si l'utilateur a des droits suffisants ou s'il est propriétaire si renseigné dans l'appel à la fonction
     * @param $required int droit minimum que l'utilisateur doit avoir
     * @param null $propriétaire facultatif, user du proprietaire de la donnee
     * @throws AuthException si l'utilisateur n'a pas les droits d'accès
     */
    public static function checkAccessRights ($required, $proprietaire = null) {
        // Si l'utisateur connecté est propriétaire du contenu
        if(isset($proprietaire) && isset($_SESSION['profile'])){
            $proprietaireid = $proprietaire->userid;
            if($proprietaireid == $_SESSION['profile']['userid']) return;
        }
        // Sinon si l'utilisateur a les droits suffisants pour accéder au contenu
        else if(isset($_SESSION['profile'])){
            if($_SESSION['profile']['auth_level'] >= $required) return;
        }
        throw new AuthException("Vous n'avez pas accès à cette page");
    }

    /**
     * Deconnecte l'utilisateur
     */
    public static function deconnexion(){
            unset($_SESSION['profile']);
    }

}