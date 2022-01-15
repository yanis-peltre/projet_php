<?php

namespace mywishlist\controleurs;


use mywishlist\exception\AuthException;
use mywishlist\exception\InscriptionException;
use mywishlist\models\Role;
use mywishlist\models\User;
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

    public function formulaireInscription($rq, $rs, $args ){
        $rs->write("<form action=\"inscription/"."\" method=\"POST\" name=\"formInscr\" id=\"formInscr\">
				<p><label>Pseudo : </label><input type=\"text\" name=\"username\" size=40 required=\"true\"></p>
				<p><label>Password : </label><input type=\"text\" name=\"password\" size=60 required=\"true\"></p>
				<input type=\"submit\" value=\"S'inscrire\">
			</form>");
        return $rs;
    }

    public function inscription($rq, $rs, $args ){
        $data = $rq->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];
        try{
            Authentification::createUser($username,$password,1);
            $rs->write("Utilisateur ". $username." inscrit");
        }
        catch(InscriptionException $e1){
            $rs->write($e1->getMessage());
        }
        return $rs;
    }

    public function formulaireConnexion($rq, $rs, $args ){
        $rs->write("<form action=\"connexion/"."\" method=\"POST\" name=\"formConnex\" id=\"formConnex\">
				<p><label>Pseudo : </label><input type=\"text\" name=\"username\" size=40 required=\"true\"></p>
				<p><label>Password : </label><input type=\"text\" name=\"password\" size=60 required=\"true\"></p>
				<input type=\"submit\" value=\"Connexion\">
			</form>");
        return $rs;
    }


    public function connexion($rq, $rs, $args){
        $data = $rq->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];
        try{
            Authentification::authenticate($username,$password);
            $rs->write("<script>alert(\"Utilisateur $username connecté\")</script>");
            $rs->write("<a href=\"..\">Accueil</a>");
        }
        catch(AuthException $e1){
            $rs->write($e1->getMessage());
        }
        return $rs;
    }

    public function deconnexion($rq, $rs, $args){
        Authentification::deconnexion();
        $rs->write("Vous êtes déconnecté");
        return $rs;
    }



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

}