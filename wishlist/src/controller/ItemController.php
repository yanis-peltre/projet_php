<?php

namespace mywishlist\controller;
require_once __DIR__ . '/../vue/VueParticipant.php';

use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vue\VueParticipant;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

class ItemController{
	
	public function __construct(){

	}
	
	/**
	* Permet de lister les listes
	*/
	public function listListe(Request $rq, Response $rs, array $args) {
		$v = new VueParticipant(Liste::allListe());
		$rs->getBody()->write($v->render(1)) ;
		
		return $rs ;
	} 
	
	/**
	* Permet de lister les items d'une liste
	*/
	public function listItem(Request $rq, Response $rs, array $args) {
		$liste = Liste::where('no','=',$args['id'])->first() ;
		$v = new VueParticipant( $liste) ;
		$rs->getBody()->write($v->render(2)) ;

		return $rs ;
	}

	/**
	* Permet d'afficher un item
	*/
	public function getItem(Request $rq, Response $rs, array $args) {
		$item = Item::where('id','=',$args['id'])->first() ;
		$v = new VueParticipant( $item ) ;
		$rs->getBody()->write($v->render(3)) ;

		return $rs ;
	} 
	
	/**
	* Affiche un formulaire pour ajouter une liste
	*/
	public function formAddList(Request $rq, Response $rs, array $args){
		$v = new VueParticipant(null) ;
		$rs->getBody()->write($v->render(4)) ;

		return $rs ;
	}
	
	/**
	* Ajoute une liste
	*/
	public function addList(Request $rq, Response $rs, array $args){
		$v = new VueParticipant(new Liste()) ;
		$rs->getBody()->write($v->render(5)) ;

		return $rs ;
	}
	
	/**
	* Affiche un formulaire pour ajouter un item a une liste
	*/
	public function formAddItem(Request $rq, Response $rs, array $args){
		$liste=Liste::where('token','=',$args['token'])->first();
		$v = new VueParticipant($liste) ;
		$rs->getBody()->write($v->render(6)) ;

		return $rs ;
	}
	
	/**
	* Ajoute un item a une liste
	*/
	public function addItem(Request $rq, Response $rs, array $args){
		$liste=Liste::where('token','=',$args['token'])->first();
		$item=new Item();
		$item->liste_id=$liste->no;
		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(7)) ;

		return $rs ;
	}
	
	/**
	* Formulaire modification d'une liste
	*/
	public function formModifyList(Request $rq, Response $rs, array $args){
		$liste=Liste::where('token','=',$args['token'])->first();
		$v = new VueParticipant($liste) ;
		$rs->getBody()->write($v->render(8)) ;

		return $rs ;
	}
	
	/**
	* Modification d'une liste
	*/
	public function modifyList(Request $rq, Response $rs, array $args){
		$liste=Liste::where('token','=',$args['token'])->first();
		$v = new VueParticipant($liste) ;
		$rs->getBody()->write($v->render(9)) ;

		return $rs ;
	}
	
	/**
	* Formulaire suppression d'une liste
	*/
	public function formDeleteList(Request $rq, Response $rs, array $args){
		$liste=Liste::where('token','=',$args['token'])->first();
		$v = new VueParticipant($liste) ;
		$rs->getBody()->write($v->render(10)) ;

		return $rs ;
	}
	
	/**
	* Formulaire suppression d'une liste
	*/
	public function deleteList(Request $rq, Response $rs, array $args){
		$liste=Liste::where('token','=',$args['token'])->first();
		$v = new VueParticipant($liste) ;
		$rs->getBody()->write($v->render(11)) ;

		return $rs ;
	}
	
	/**
	* Modification d'un item d'une liste
	*/
	public function formModifyItem(Request $rq, Response $rs, array $args){
		$item=Item::where('id','=',$args['id'])->first();
		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(12)) ;

		return $rs ;
	}
	
	/**
	* Modification d'un item
	*/
	public function modifyItem(Request $rq, Response $rs, array $args){
		$item=Item::where('id','=',$args['id'])->first();
		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(13)) ;

		return $rs ;
	}
	
	/**
	* Modification d'un item d'une liste
	*/
	public function formDeleteItem(Request $rq, Response $rs, array $args){
		$item=new Item();
		
		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(14)) ;

		return $rs ;
	}
	
	/**
	* Suppression d'items
	*/
	public function deleteItem(Request $rq, Response $rs, array $args){
		$item;
		
		foreach(explode('&',$_SERVER['QUERY_STRING']) as $cle=>$val){
			$item[]=Item::where('id','=',$cle)->first();
		}
		
		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(15)) ;

		return $rs ;
	}
}












