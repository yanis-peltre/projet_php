<?php

namespace mywishlist\controller;

require_once __DIR__ . '/Controller.php';

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use mywishlist\controller\Controller;
use mywishlist\vue\VueParticipant;/*3236*/
use mywishlist\models\Item;
use mywishlist\models\Liste;

class ControleurAccueil extends Controller
{
    public function __construct(Container $c)
    {
        parent::__construct($c);
    }

    function displayAccueil(Request $rq, Response $rs, array $args){
        $v = new VueParticipant(null) ;
		$rs->getBody()->write($v->render(16)) ;
		
		return $rs ;
    }

	function displayItemListe(Request $rq, Response $rs, array $args){
		$param=$rq->getParsedBody();
        $v = new VueParticipant(null) ;
		$rs->getBody()->write($v->render(17)) ;
		
		return $rs ;
    }
}





