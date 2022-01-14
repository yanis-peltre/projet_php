<?php

namespace mywishlist\controller;

require_once __DIR__ . '/Controller.php';

use mywishlist\models\Item;
use mywishlist\vue\VueParticipant;
use mywishlist\controller\Controller;
use mywishlist\models\Liste;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ControleurItem extends Controller
{
	public function __construct(Container $c)
    {
        parent::__construct($c);
    }

	/**
	* Permet de lister les items d'une liste
	*/
	public function listItem(Request $rq, Response $rs, array $args) {
		$liste = Liste::where('no','=',$rq->getQueryParam('id'))->first() ;
		$v = new VueParticipant($liste->items()) ;
		$rs->getBody()->write($v->render(2)) ;

		return $rs ;
	}
	
	/**
	* Permet d'afficher un item
	*/
	public function getItem(Request $rq, Response $rs, array $args) {
		$item = Item::where('id','=',intval($args['id']))->first() ;
		$v = new VueParticipant( $item->getItem('id')) ;
		$rs->getBody()->write($v->render(3)) ;

		return $rs ;
	}
	
	/**
	* Affiche un formulaire pour ajouter un item a une liste
	*/
	public function formAddItem(Request $rq, Response $rs, array $args){
		$liste=Liste::where('token','=',intval($args['token']))->first();
		$v = new VueParticipant($liste) ;
		$rs->getBody()->write($v->render(6)) ;

		return $rs ;
	}
	
	/**
	* Ajoute un item a une liste
	*/
	public function addItem(Request $rq, Response $rs, array $args){
		$item=new Item();
		$param=$rq->getParsedBody();
		$item->addItem($param['des'],$param['prix'],$param['nom'],$args['token']);

		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(7)) ;

		return $rs ;
	}

	/**
	* Modification d'un item d'une liste
	*/
	public function formModifyItem(Request $rq, Response $rs, array $args){
		$item=Item::where('id','=',intval($args['id']))->first();
		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(12)) ;

		return $rs ;
	}
	
	/**
	* Modification d'un item
	*/
	public function modifyItem(Request $rq, Response $rs, array $args){
		$param=$rq->getParsedBody();
		$item=Item::where('id','=',intval($args['id']))->first();
		$item->modifyItem($param['des'],$param['tarif'],$param['nom']);
		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(13)) ;

		return $rs ;
	}
	
	/**
	* Modification d'un item d'une liste
	*/
	public function formDeleteItem(Request $rq, Response $rs, array $args){
		$item=[];
		$param=$rq->getParsedBody();
		
		foreach($param as $cle->$value){
			$item[]=Item::where('id','=',$cle)-first();
		}
		
		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(14)) ;

		return $rs ;
	}
	
	/**
	* Suppression d'items
	*/
	public function deleteItem(Request $rq, Response $rs, array $args){
		$param=$rq->getParsedBody();
		
		foreach($param as $cle=>$value){
			$item=Item::where('id','=',$cle)->first();
			$item->deleteItem();
		}
		
		$v = new VueParticipant(null) ;
		$rs->getBody()->write($v->render(15)) ;
		
		return $rs ;
	}
	
	/**
	* Ajout d'une cagnotte
	*/
	public function addCagnotte(Request $rq, Response $rs, array $args):Response{
		$item=Item::where('id','=',intval($args['id']))->first();
		$item->addCagnotte();
		$v=new VueParticipant($item);
		$rs->getBody()->write($v->render(20));
		return $rs;
	}
}