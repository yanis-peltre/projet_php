<?php

namespace mywishlist\controleurs;

require_once __DIR__ . '/Controleur.php';

use mywishlist\exceptions\AuthException;
use mywishlist\models\Item;
use mywishlist\vue\VueAccount;
use mywishlist\vue\VueItem;
use mywishlist\controleurs\Controleur;
use mywishlist\models\Liste;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ControleurItem extends Controleur
{
	public function __construct(Container $c)
    {
        parent::__construct($c);
    }

	function displayItemListe(Request $rq, Response $rs, array $args){
		$param=$rq->getParsedBody();
        $v = new VueItem($this->container) ;
		$rs->getBody()->write($v->render(1)) ;
		
		return $rs ;
    }

	/**
	* Permet de lister les items d'une liste
	*/
	public function listItem(Request $rq, Response $rs, array $args) {
		$liste = Liste::where('no','=',$rq->getQueryParam('id'))->first() ;
		$v = new VueItem($this->container, $liste->items()) ;
		$rs->getBody()->write($v->render(2)) ;

		return $rs ;
	}
	
	/**
	* Permet d'afficher un item
	*/
	public function getItem(Request $rq, Response $rs, array $args) {
            $item = Item::where('id','=',intval($args['id']))->first() ;
            $creator = $item->liste->user;
            $v = new VueItem($this->container, $item->getItem('id')) ;
            $rs->getBody()->write($v->render(3)) ;
		return $rs ;
	}
	
	/**
	* Affiche un formulaire pour ajouter un item a une liste
	*/
	public function formAddItem(Request $rq, Response $rs, array $args){
        $no = $args['no'];
		$liste=Liste::where('no',$no)->first();
        $creator = $liste->user;
        try {
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS, $creator);
            $v = new VueItem($this->container,$liste) ;
            $rs->getBody()->write($v->render(4)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->getBody()->write($v->render(5));
        }


		return $rs ;
	}
	
	/**
	* Ajoute un item a une liste
	*/
	public function addItem(Request $rq, Response $rs, array $args){
		$item=new Item();
        $param=$rq->getParsedBody();
        $liste = Liste::firstWhere('no',$args['no']);
        $creator = $liste->user;
        try{
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS,$creator);

            if(!isset($args['img'])) $args['img'] = '';
            $item->addItem($param['des'],$param['prix'],$param['nom'],$args['no'],$args['img']);
            $v = new VueItem($this->container, $item) ;
            $rs->getBody()->write($v->render(5)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->getBody()->write($v->render(5));
        }
		return $rs ;
	}

	/**
	* Modification d'un item d'une liste
	*/
	public function formModifyItem(Request $rq, Response $rs, array $args){
        try{
            $item=Item::where('id','=',intval($args['id']))->first();
            $creator = $item->liste->user;
            Authentification::checkAccessRights(Authentification::$ADMIN_RIGHTS, $creator);
            $v = new VueItem($this->container, $item) ;
            $rs->getBody()->write($v->render(6)) ;
        }
        catch (AuthException $e1){
            $v = new VueAccount();
            $rs->getBody()->write($v->render(5));
        }
		return $rs ;
	}
	
	/**
	* Modification d'un item
	*/
	public function modifyItem(Request $rq, Response $rs, array $args){
		$param=$rq->getParsedBody();
		$item=Item::where('id','=',intval($args['id']))->first();
		$item->modifyItem($param['des'],$param['tarif'],$param['nom']);
		$v = new VueItem($this->container, $item) ;
		$rs->getBody()->write($v->render(7)) ;

		return $rs ;
	}
	
	/**
	* Modification d'un item d'une liste
	*/
	public function formDeleteItem(Request $rq, Response $rs, array $args){
		$item=[];
		$param=$rq->getParsedBody();
		
		foreach($param as $cle=>$value){
			$item[]=Item::where('id','=',$cle)-first();
		}
		
		$v = new VueItem($this->container, $item) ;
		$rs->getBody()->write($v->render(8)) ;

		return $rs ;
	}
	
	/**
	* Suppression d'items
	*/
	public function deleteItem(Request $rq, Response $rs, array $args){
		$param=$rq->getParsedBody();
		
		foreach($param as $cle=>$value){
			$item=Item::where('id','=',$cle)->first();
			$id=$item->liste_id;
			$item->deleteItem();
		}
		
		$v = new VueItem($this->container,$id) ;
		$rs->getBody()->write($v->render(9)) ;
		
		return $rs ;
	}
	
	/**
	* Ajout d'une cagnotte
	*/
	public function addCagnotte(Request $rq, Response $rs, array $args):Response{
		$item=Item::where('id','=',intval($args['id']))->first();
		$item->addCagnotte();
		$v=new VueItem($this->container,$item);
		$rs->getBody()->write($v->render(10));
		return $rs;
	}
	
	/**
	* Donner de l'argent pour une cagnotte
	*/
	public function giveCagnotte(Request $rq, Response $rs, array $args):Response{
		$item=Item::where('id','=',intval($args['id']))->first();
		$param=$rq->getParsedBody();
		$item->giveCagnotte($param['cag']);
		$obj=[];
		$obj[]=$item;
		$obj[]=$param['cag'];
		$v=new VueItem($this->container,$obj);
		$rs->getBody()->write($v->render(11));
		return $rs;
	}
	
	/**
	* Donner de l'argent pour une cagnotte
	*/
	public function reservItem(Request $rq, Response $rs, array $args):Response{
		$item=Item::where('id','=',intval($args['id']))->first();
		$param=$rq->getParsedBody();
		$item->reservItem($param['name'],$param['mes']);
		$v=new VueItem($this->container,$item);
		$rs->getBody()->write($v->render(12));
		return $rs;
	}

    /**
     * Ajoute un message
     */
    public function ajouterMessage(Request $rq, Response $rs, array $args) : Response{
        $token = $args['token'];
        $item = Item::firstWhere('token',$token);

        return $rs;
    }
}






