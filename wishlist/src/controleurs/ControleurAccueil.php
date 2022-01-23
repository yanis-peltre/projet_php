<?php

namespace mywishlist\controleurs;

require_once __DIR__ . '/Controleur.php';

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use mywishlist\controleurs\Controleur;
use mywishlist\vue\VueAccueil;/*3236*/
use mywishlist\models\Item;
use mywishlist\models\Liste;

class ControleurAccueil extends Controleur
{
    public function __construct(Container $c)
    {
        parent::__construct($c);
    }

    function displayAccueil(Request $rq, Response $rs, array $args){
        $v = new VueAccueil($this->container) ;
		$rs->getBody()->write($v->render(1)) ;
		return $rs ;
    }
}





