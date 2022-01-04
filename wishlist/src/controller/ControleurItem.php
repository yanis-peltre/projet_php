<?php

namespace mywishlist\controleurs;

use mywishlist\models\Item;
use mywishlist\vue\VueParticipant;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ControleurItem
{

    private $container; //conteneur de dépendances.

    public function __construct(Container $c)
    {
        $this->container = $c;
    }

    function displayItem(Request $rq, Response $rs, array $args){
        $idItem = $args['idItem'];
        $item = Item::where('id','=', $idItem)->first();

        $vue = new VueParticipant();
        $rs->getBody()->write($vue->render());
        return $rs;

        /**
        echo "id : ".$item['id']."</br>".
            "liste id : ".$item['liste_id']."</br>".
            "nom de la liste : ".$item->liste["titre"] ."</br>".
            "nom : ".$item['nom']."</br>".
            "description : ".$item['descr']."</br>".
            "<img src=\" mywishlist/img/".$item['img']."\" alt=\"img\"'></br>".
            "url : ".$item['url']."</br>".
            "tarif : ".$item['tarif']."</br></br>";*/
    }

}