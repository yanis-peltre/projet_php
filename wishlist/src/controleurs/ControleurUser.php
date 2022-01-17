<?php

namespace mywishlist\controleurs;


use mywishlist\exceptions\AuthException;
use mywishlist\exceptions\InscriptionException;
use mywishlist\models\Role;
use mywishlist\models\User;
use mywishlist\vue\VueAccount;
use Slim\Container;

class ControleurUser
{

    private $container;

    public function __construct(Container $c){
        $this->container = $c;
    }

    public function listerUsers($rq, $rs, $args ){
        $users = User::all();
        foreach ($users as $user){
            $rs->getBody()->write($user . $user->role);
        }
        return $rs;
    }

    public function listerRoles($rq, $rs, $args ){
        $roles = Role::all();
        foreach ($roles as $role){
            $rs->getBody()->write($role);
            $users = $role->users;
            foreach ($users as $user){
                $rs->getBody()->write($user);
            }
        }
        return $rs;
    }

    /**
     * Créé un formulaire d'inscription pour un utilisateur
     */
    public function formulaireInscription($rq, $rs, $args ){
        $vue = new VueAccount();
        $rs->write($vue->render(1));
        return $rs;
    }

    /**
     * Inscrit un utilisateur
     */
    public function inscription($rq, $rs, $args ){
        $data = $rq->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];
        try{
            Authentification::createUser($username,$password,'Createur');
            $rs->write("Utilisateur ". $username." inscrit");
        }
        catch(InscriptionException $e1){
            $rs->write($e1->getMessage());
        }
        return $rs;
    }

    public function formulaireConnexion($rq, $rs, $args ){
        $vue = new VueAccount();
        $rs->write($vue->render(2));
        return $rs;
    }


    public function connexion($rq, $rs, $args){
        $vue = new VueAccount();
        $data = $rq->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];
        try{
            Authentification::authenticate($username,$password);
            $rs->write($vue->render(3));
        }
        catch(AuthException $e1){
            $rs->write($e1->getMessage());
        }
        return $rs;
    }

    public function deconnexion($rq, $rs, $args){
        Authentification::deconnexion();
        $rs->write("Vous êtes déconnecté");
        header("Location: ./");
        Exit();
        return $rs;
    }



    /**
     * Crée un utilisateur
     * @param $username String nom d'utilisateur
     * @param $password String mot de passe
     * @throws InscriptionException
     */
    public static function createUser ($username, $password, $userRole){
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
        $user->inscrireUser($username, $password, $userRole);
        $userid = $user->userid;
        self::loadProfile($userid);

    }

    /**
     * Voir les infos de son compte
     */
    public function voirCompte($rq, $rs, $args){

    }

}