<?php declare(strict_types = 1);

namespace mywishlist\controleurs;

use Illuminate\Support\Facades\Auth;
use mywishlist\exceptions\AuthException;
use mywishlist\exceptions\InscriptionException;
use mywishlist\models\Liste;
use mywishlist\models\Role;
use mywishlist\models\User;
use mywishlist\vue\VueAccount;
use mywishlist\vue\VueParticipant;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ControleurUser
{

    private $container;

    public function __construct(Container $c){
        $this->container = $c;
    }

    public function listerUsers(Request $rq, Response $rs, array $args):Response{
        $users = User::all();
        foreach ($users as $user){
            $rs->getBody()->write($user . $user->role);
        }
        return $rs;
    }

    public function listerRoles(Request $rq, Response $rs, array $args):Response{
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
    public function formulaireInscription(Request $rq, Response $rs, array $args):Response{
        $vue = new VueAccount($this->container);
        $rs->write($vue->render(1));
        return $rs;
    }

    /**
     * Inscrit un utilisateur
     */
    public function inscription(Request $rq, Response $rs, array $args):Response{
        $data = $rq->getParsedBody();
        $username = filter_var($data['username'], FILTER_SANITIZE_STRING);
        $password = filter_var($data['password'],FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'],FILTER_SANITIZE_STRING);
        try{
            Authentification::createUser($username,$password,'Createur', $email);
            $rs->write("Utilisateur ". $username." inscrit");
        }
        catch(InscriptionException $e1){
            $rs->write($e1->getMessage());
        }
        return $rs;
    }

    public function formulaireConnexion(Request $rq, Response $rs, array $args):Response{
        $vue = new VueAccount($this->container);
        $rs->write($vue->render(2));
        return $rs;
    }


    public function connexion(Request $rq, Response $rs, array $args):Response{
        $vue = new VueAccount($this->container);
        $data = $rq->getParsedBody();
        $username = filter_var($data['username'],FILTER_SANITIZE_STRING);
        $password = filter_var($data['password'],FILTER_SANITIZE_STRING);
        try{
            Authentification::authenticate($username,$password);
            $rs->write($vue->render(3));
        }
        catch(AuthException $e1){
            $rs->write($e1->getMessage());
        }
        return $rs;
    }

    public function deconnexion(Request $rq, Response $rs, array $args):Response{
        Authentification::deconnexion();
        $rs->write("Vous êtes déconnecté");
        $url = $this->container->router->pathFor('accueil');
        $rs = $rs->withStatus(302)->withHeader('Location', $url);
        return $rs;
    }



    /**
     * Crée un utilisateur
     * @param $username String nom d'utilisateur
     * @param $password String mot de passe
     * @param $email String email de l'utilisateur
     * @throws InscriptionException
     */
    public static function createUser ($username, $password, $userRole,$email){
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
        $user->inscrireUser($username, $password, $userRole, $email);
        $userid = $user->userid;
        self::loadProfile($userid);

    }

    /**
     * Voir les infos de son compte
     */
    public function voirCompte(Request $rq, Response $rs, array $args):Response{
        try{
            Authentification::checkAccessRights(Authentification::$CREATOR_RIGHTS);
            $userid = $_SESSION['profile']['userid'];
            $user = User::firstWhere('userid',$userid);
            $vue = new VueAccount($this->container,$user);
            $rs->write($vue->render(4));
        }
        catch (AuthException $e1){
            $v = new VueAccount($this->container);
            $rs->write($v->render(5));
        }
        return $rs;
    }

    /**
     * Modifier les infos de son compte
     */
    public function formModifCompte(Request $rq, Response $rs, array $args):Response{
        try{
            Authentification::checkAccessRights(Authentification::$CREATOR_RIGHTS);
            $userid = $_SESSION['profile']['userid'];
            $user = User::firstWhere('userid',$userid);
            $v = new VueAccount($this->container,$user);
            $rs->write($v->render(6));
        }
        catch (AuthException $e1){
            $v = new VueAccount($this->container);
            $rs->write($v->render(5));
        }
        return $rs;
    }

    public function modifCompte(Request $rq, Response $rs, array $args):Response{
        try {
            Authentification::checkAccessRights(Authentification::$CREATOR_RIGHTS);
            $data = $rq->getParsedBody();
            $newMail = filter_var($data['email'],FILTER_SANITIZE_STRING);
            $newPassword = filter_var($data['password'],FILTER_SANITIZE_STRING);
            $user = User::firstWhere('userid', $_SESSION['profile']['userid']);
            $user->password = $newPassword;
            $user->email = $newMail;
            $user->save();
            if (strlen($newPassword) != 0) {
                Authentification::deconnexion();
                $url = $this->container->router->pathFor('formConnexion');
            } else {
                $this->container->router->pathFor('formConnexion');
                $url = $this->container->router->pathFor('voirProfil');
            }
            $rs = $rs->withStatus(302)->withHeader('Location', $url);
        }
        catch (AuthException $e1){
            $v = new VueAccount($this->container);
            $rs->write($v->render(5));
        }
        return $rs;
    }

    public function supprimerCompte(Request $rq, Response $rs, array $args):Response{
        try{
            Authentification::checkAccessRights(Authentification::$CREATOR_RIGHTS);
            $userid = $_SESSION['profile']['userid'];
            $user = User::firstWhere('userid',$userid);
            $listes = $user->listes;
            // Suppression des listes
            foreach ($listes as $li){
                $items = $li->items;
                // Supression des items
                foreach ($items as $item) {
                    $item->delete();
                }
                $li->delete();
            }
            $user->delete();
            Authentification::deconnexion();
            $url = $this->container->router->pathFor('accueil');
            $rs = $rs->withStatus(302)->withHeader('Location', $url);
        }
        catch (AuthException $e1){
            $v = new VueAccount($this->container);
            $rs->write($v->render(5));
        }
        return $rs;
    }

}