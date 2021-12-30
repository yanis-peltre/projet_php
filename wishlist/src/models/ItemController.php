<?php

namespace mywishlist\models;

//require_once __DIR__. "/../../vendor/autoload.php";
/*require_once 'src/conf/Database.php';
require_once 'src/models/Item.php';
require_once 'src/models/Liste.php';*/
require_once 'src/vue/VueParticipant.php';

use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vue\VueParticipant;

class ItemController{
	
	public function __construct(){

	}
	
	/**
	* Permet de lister les listes
	*/
	public function listListe( $rq, $rs, $args ) {
		$v = new VueParticipant(Liste::allListe()) ;
		$rs->getBody()->write($v->render(1)) ;
		
		return $rs ;
	} 
	
	/**
	* Permet de lister les items d'une liste
	*/
	public function listItem($rq, $rs, $args) {
		$liste = Liste::where('no','=',$args['id'])->first() ;
		$v = new VueParticipant( $liste) ;
		$rs->getBody()->write($v->render(2)) ;

		return $rs ;
	}

	/**
	* Permet d'afficher un item
	*/
	public function getItem( $rq, $rs, $args ) {
		$item = Item::where('id','=',$args['id'])->first() ;
		$v = new VueParticipant( $item ) ;
		$rs->getBody()->write($v->render(3)) ;

		return $rs ;
	} 
	
	/**
	* Affiche un formulaire pour ajouter une liste
	*/
	public function formAddList($rq, $rs, $args){
		$v = new VueParticipant(null) ;
		$rs->getBody()->write($v->render(4)) ;

		return $rs ;
	}
	
	/**
	* Ajoute une liste
	*/
	public function addList($rq, $rs, $args){
		$v = new VueParticipant(new Liste()) ;
		$rs->getBody()->write($v->render(5)) ;

		return $rs ;
	}
	
	/**
	* Affiche un formulaire pour ajouter un item a une liste
	*/
	public function formAddItem($rq, $rs, $args){
		$liste=Liste::where('token','=',$args['token'])->first();
		$v = new VueParticipant($liste) ;
		$rs->getBody()->write($v->render(6)) ;

		return $rs ;
	}
	
	/**
	* Ajoute un item a une liste
	*/
	public function addItem($rq, $rs, $args){
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
	public function formModifyList($rq, $rs, $args){
		$liste=Liste::where('token','=',$args['token'])->first();
		$v = new VueParticipant($liste) ;
		$rs->getBody()->write($v->render(8)) ;

		return $rs ;
	}
	
	/**
	* Modification d'une liste
	*/
	public function modifyList($rq, $rs, $args){
		$liste=Liste::where('token','=',$args['token'])->first();
		$v = new VueParticipant($liste) ;
		$rs->getBody()->write($v->render(9)) ;

		return $rs ;
	}
	
	/**
	* Formulaire suppression d'une liste
	*/
	public function formDeleteList($rq, $rs, $args){
		$liste=Liste::where('token','=',$args['token'])->first();
		$v = new VueParticipant($liste) ;
		$rs->getBody()->write($v->render(10)) ;

		return $rs ;
	}
	
	/**
	* Formulaire suppression d'une liste
	*/
	public function deleteList($rq, $rs, $args){
		$liste=Liste::where('token','=',$args['token'])->first();
		$v = new VueParticipant($liste) ;
		$rs->getBody()->write($v->render(11)) ;

		return $rs ;
	}
	
	/**
	* Modification d'un item d'une liste
	*/
	public function formModifyItem($rq, $rs, $args){
		$item=Item::where('id','=',$args['id'])->first();
		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(12)) ;

		return $rs ;
	}
	
	/**
	* Modification d'un item
	*/
	public function modifyItem($rq, $rs, $args){
		$item=Item::where('id','=',$args['id'])->first();
		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(13)) ;

		return $rs ;
	}
	
	/**
	* Modification d'un item d'une liste
	*/
	public function formDeleteItem($rq, $rs, $args){
		$item;
		
		foreach($args as $ob){
			$item[]=$ob;
		}
		
		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(14)) ;

		return $rs ;
	}
	
	/**
	* Suppression d'items
	*/
	public function deleteItem($rq, $rs, $args){
		$item;
		
		foreach($args as $ob){
			$item[]=$ob;
		}
		
		$v = new VueParticipant($item) ;
		$rs->getBody()->write($v->render(15)) ;

		return $rs ;
	}
}












