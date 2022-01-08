<?php

namespace mywishlist\controller;

require_once __DIR__ . '/Controller.php';

use mywishlist\vue\VueParticipant;
use mywishlist\models\Liste;
use mywishlist\controller\Controller;
use mywishlist\models\Item;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ControleurListe extends Controller
{
    public function __construct(Container $c)
    {
        parent::__construct($c);
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
		$liste=new Liste();
		$param=$rq->getParsedBody();
		$liste->createList($param['des'],$param['exp'],$param['titre']);
		$v = new VueParticipant($liste);
		$rs->getBody()->write($v->render(5)) ;

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
		$param=$rq->getParsedBody();
		$liste=Liste::where('token','=',$args['token'])->first();
		$liste->modifyList($param['des'],$param['exp'],$param['titre']);
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
		$liste->deleteList();
		$rs->getBody()->write($v->render(11)) ;

		return $rs ;
	}
}