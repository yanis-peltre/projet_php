<?php declare(strict_types = 1);

namespace mywishlist\controleurs;

use Illuminate\Support\Facades\Auth;
use mywishlist\exceptions\AuthException;
use mywishlist\models\User;
use mywishlist\vue\VueAccount;
use mywishlist\vue\VueListe;
use mywishlist\vue\VueItem;
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
	public function publicLists(Request $rq, Response $rs, array $args) :Response{
		$container = $this->container ;
		
		$v = new VueListe($this->container,Liste::orderBy('expiration')->get());
		$rs->getBody()->write($v->render(1)) ;
		
		return $rs ;
	}

    /**
     * Voir une liste
     */
    public function afficheListe(Request $rq, Response $rs, array $args):Response{
        try{
            $no = intval($args['no']);
            $liste=Liste::firstWhere('no',$no);
            $creator = $liste->user;
            if($liste->publique != 'x') Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS, $creator);
            
            // Si createur
            if(isset($_SESSION['profile']) && $creator->userid == $_SESSION['profile']['userid']){
				$v = new VueListe($this->container,$liste) ;
                $rs->getBody()->write($v->render(2)) ;
            }
            // Si visiteur
            else{
				$v = new VueItem($this->container,$liste) ;
                $rs->getBody()->write($v->render(2));
            }
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->getBody()->write($v->render(5));
        }
        return $rs ;
    }

    /**
	* Affiche un formulaire pour ajouter une liste
	*/
	public function formAddList(Request $rq, Response $rs, array $args):Response{
        try{
            Authentification::checkAccessRights(Authentification::$CREATOR_RIGHTS);
            $v = new VueListe($this->container) ;
            $rs->getBody()->write($v->render(3)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->getBody()->write($v->render(5));
        }

		return $rs ;
	}
	
	/**
	* Ajoute une liste
	*/
	public function addList(Request $rq, Response $rs, array $args):Response{
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
            $v = new VueListe($this->container,$liste);
            $rs->getBody()->write($v->render(4)) ;
        }
        catch(AuthException $e1){
            $v = new VueAccount();
            $rs->getBody()->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Formulaire modification d'une liste
	*/
	public function formModifyList(Request $rq, Response $rs, array $args):Response{
        $no = intval($args['no']);
        $liste=Liste::where('no',$no)->first();
        $creator = $liste->user;
        try{
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS,$creator);
			if($liste->expiration>=date('Y-m-d', time())){
				$v = new VueListe($this->container,$liste) ;
				$rs->getBody()->write($v->render(5)) ;
			}
            else{
				$v = new VueListe($this->container,Item::where('liste_id','=',$liste->no)->get()) ;
				$rs->getBody()->write($v->render(16)) ;
			}
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->getBody()->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Modification d'une liste
	*/
	public function modifyList(Request $rq, Response $rs, array $args):Response{
		$param=$rq->getParsedBody();
        $no = intval($args['no']);
		$liste=Liste::where('no',$no)->first();
        $creator = $liste->user;
        try {
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS, $creator);
            $liste->modifyList($param['des'],$param['exp'],$param['titre']);
            $v = new VueListe($this->container,$liste) ;
            $rs->getBody()->write($v->render(6)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->getBody()->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Formulaire suppression d'une liste
	*/
	public function formDeleteList(Request $rq, Response $rs, array $args):Response{
        $no = intval($args['no']);
		$liste=Liste::where('no',$no)->first();
        $creator = $liste->user;
        try {
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS, $creator);
            $v = new VueListe($this->container,$liste);
            $rs->getBody()->write($v->render(7));
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->getBody()->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Suppression d'une liste
	*/
	public function deleteList(Request $rq, Response $rs, array $args):Response{
        $no = $args['no'];
        $liste=Liste::where('no',intval($no))->first();
        $creator = $liste->user;
        try{
            $v = new VueListe($this->container,$liste) ;
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS, $creator);
            $liste->deleteList();
            $rs->getBody()->write($v->render(8)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->getBody()->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Partage d'une liste
	*/
	public function shareList(Request $rq, Response $rs, array $args):Response{
        try{
            $no = intval($args['no']);
            $liste=Liste::where('no',$no)->first();
            if(!isset($liste)) throw new AuthException("Liste inexistante");

            $creator = $liste->user;
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS, $creator);
            $liste->shareList();
            $v = new VueListe($this->container,$liste) ;
            $rs->getBody()->write($v->render(9)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->getBody()->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Formulaire accès liste partagée
	*/
	public function formCheckList(Request $rq, Response $rs, array $args):Response{
        $v = new VueListe($this->container) ;
		$rs->getBody()->write($v->render(10)) ;
		return $rs ;
	}
	
	/**
	* Rendre une liste publique
	*/
	public function putPublic(Request $rq, Response $rs, array $args):Response{
        $no = intval($args['no']);
		$liste=Liste::where('no',$no)->first();
		$liste->putPublic();
		$v = new VueListe($this->container,$liste) ;
		$rs->getBody()->write($v->render(11)) ;

		return $rs ;
	}
	
	/**
	* Listes persos
	*/
	public function myLists(Request $rq, Response $rs, array $args):Response{
        try{
            Authentification::checkAccessRights(Authentification::$CREATOR_RIGHTS);
            $userid = $_SESSION['profile']['userid'];
            $v = new VueListe($this->container,Liste::where('user_id',$userid)->get()) ;
            $rs->getBody()->write($v->render(12)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->getBody()->write($v->render(5));
        }
		return $rs ;
	}

	/**
	* Permet d'ajouter un message à une liste
	*/
    public function ajouterMessage(Request $rq, Response $rs, array $args) : Response{
        $no = intval($args['no']);
        $message = $rq->getParsedBody();
        $liste = Liste::firstWhere('no',$no);
        $liste->ajouterMessage($message['Message']);
		
		$v = new VueListe($this->container,$liste) ;
		$rs->getBody()->write($v->render(13));
        return $rs;
    }

	/**
	* Permet d'accéder à une liste partagée
	*/
    public function checkList(Request $rq, Response $rs, array $args) : Response{
        $liste=Liste::firstWhere('token_partage',$rq->getQueryParam('sharedToken'));
        $v = new VueListe($this->container,$liste) ;
        $rs->getBody()->write($v->render(14));

        return $rs;
    }

	/**
	* Permet de valider une liste
	*/
	public function valider(Request $rq, Response $rs, array $args) : Response{
        $liste=Liste::where('no','=',intval($args['no']))->first();
		$liste->valider();
        $v = new VueListe($this->container,$liste) ;
        $rs->getBody()->write($v->render(15));

        return $rs;
    }
}










