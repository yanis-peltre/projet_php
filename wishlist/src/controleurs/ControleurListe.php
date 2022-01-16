<?php

namespace mywishlist\controleurs;

require_once __DIR__ . '/Controleur.php';

use Illuminate\Support\Facades\Auth;
use mywishlist\exceptions\AuthException;
use mywishlist\models\User;
use mywishlist\vue\VueAccount;
use mywishlist\vue\VueParticipant;
use mywishlist\models\Liste;
use mywishlist\controleurs\Controleur;
use mywishlist\models\Item;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ControleurListe extends Controleur
{
    public function __construct(Container $c)
    {
        parent::__construct($c);
    }
	
	/**
	* Permet de lister les listes publiques
	*/
	public function publicLists(Request $rq, Response $rs, array $args) {
		$container = $this->container ;
		/**$base = $rq->getUri()->getBasePath() ;
		$route_uri = $container->router->pathFor('liste') ;
		$url = $base . $route_uri ;*/
		
		$v = new VueParticipant(Liste::allListe());
		$rs->getBody()->write($v->render(1)) ;
		
		return $rs ;
	}

    /**
     * Voir une liste
     */
    public function afficheListe(Request $rq, Response $rs, array $args){
        try{
            $no = $args['no'];
            $liste=Liste::firstWhere('no',$no);
            $creator = $liste->user;
            if($liste->publique != 'x') Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS, $creator);
            $v = new VueParticipant($liste) ;
            // Si createur
            if($creator->userid == $_SESSION['profile']['userid']){
                $rs->write($v->render(19)) ;
            }
            // Si visiteur
            else{
                $rs->write($v->render(2));
            }
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->write($v->render(5));
        }
        return $rs ;
    }


    /**
	* Affiche un formulaire pour ajouter une liste
	*/
	public function formAddList(Request $rq, Response $rs, array $args){
        try{
            Authentification::checkAccessRights(Authentification::$CREATOR_RIGHTS);
            $v = new VueParticipant(null) ;
            $rs->getBody()->write($v->render(4)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->write($v->render(5));
        }

		return $rs ;
	}
	
	/**
	* Ajoute une liste
	*/
	public function addList(Request $rq, Response $rs, array $args){
        try{
            Authentification::checkAccessRights(Authentification::$CREATOR_RIGHTS);
            $liste=new Liste();
            $param=$rq->getParsedBody();
            $userid = $_SESSION['profile']['userid'];
            if(isset($param['publique'])){
                $publique = true;
            }
            else{
                $publique = false;
            }
            $liste->createList($param['des'],$param['exp'],$param['titre'],$userid,$publique);
            $v = new VueParticipant($liste);
            $rs->getBody()->write($v->render(5)) ;
        }
        catch(AuthException $e1){
            $v = new VueAccount();
            $rs->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Formulaire modification d'une liste
	*/
	public function formModifyList(Request $rq, Response $rs, array $args){
        $no = intval($args['no']);
        $liste=Liste::where('no',$no)->first();
        $creator = $liste->user;
        try{
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS,$creator);
            $v = new VueParticipant($liste) ;
            $rs->write($v->render(8)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Modification d'une liste
	*/
	public function modifyList(Request $rq, Response $rs, array $args){
		$param=$rq->getParsedBody();
		$liste=Liste::where('token','=',intval($args['token']))->first();
        $creator = $liste->user;
        try {
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS, $creator);
            $liste->modifyList($param['des'],$param['exp'],$param['titre']);
            $v = new VueParticipant($liste) ;
            $rs->getBody()->write($v->render(9)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Formulaire suppression d'une liste
	*/
	public function formDeleteList(Request $rq, Response $rs, array $args){
		$liste=Liste::where('token','=',intval($args['token']))->first();
        $creator = $liste->user;
        try {
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS, $creator);
            $v = new VueParticipant($liste);
            $rs->getBody()->write($v->render(10));
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Suppression d'une liste
	*/
	public function deleteList(Request $rq, Response $rs, array $args){
        $token = $args['token'];
        $liste=Liste::where('token','=',intval($token))->first();
        $creator = $liste->user;
        try{
            $v = new VueParticipant($liste) ;
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS, $creator);
            $liste->deleteList();
            $rs->getBody()->write($v->render(11)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Partage d'une liste
	*/
	public function shareList(Request $rq, Response $rs, array $args){
        try{
            $liste=Liste::where('token','=',intval($args['token']))->first();
            if(!isset($liste)) throw new AuthException("Liste inexistante");

            $creator = $liste->user;
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS, $creator);
            $liste->shareList();
            $v = new VueParticipant($liste) ;
            $rs->getBody()->write($v->render(18)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Formulaire accès liste
	*/
	public function formCheckList(Request $rq, Response $rs, array $args){
		$v = new VueParticipant() ;
		$rs->getBody()->write($v->render(17)) ;

		return $rs ;
	}

	/**
	* Voir une liste partagée
	*/
	public function afficheListePartagee(Request $rq, Response $rs, array $args){
        $tokenPartage = intval($rq->getQueryParam('sharedtoken'));
        $liste=Liste::where('token_partage',$tokenPartage)->first();
        $v = new VueParticipant($liste->items()) ;
        $rs->getBody()->write($v->render(19)) ;
		return $rs ;
	}
	
	/**
	* Rendre une liste publique
	*/
	public function putPublic(Request $rq, Response $rs, array $args){
		$liste=Liste::where('token','=',intval($args['token']))->first();
		$liste->putPublic();
		$v = new VueParticipant($liste) ;
		$rs->getBody()->write($v->render(23)) ;

		return $rs ;
	}
	
	/**
	* Listes persos
	*/
	public function myLists(Request $rq, Response $rs, array $args){
        try{
            Authentification::checkAccessRights(Authentification::$CREATOR_RIGHTS);
            $userid = $_SESSION['profile']['userid'];
            $v = new VueParticipant(Liste::where('user_id',$userid)->get()) ;
            $rs->write($v->render(24)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->write($v->render(5));
        }
		return $rs ;
	}
}










