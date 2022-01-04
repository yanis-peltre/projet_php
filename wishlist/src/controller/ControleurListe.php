<?php

namespace mywishlist\controleurs;

use mywishlist\models\Liste;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ControleurListe
{

    private $container; //conteneur de dépendances.

    public function __construct(Container $c)
    {
        $this->container = $c;
    }

    function displayAllLists(Request $rq, Response $rs, array $args){
        $rs->getBody()->write("Liste des listes : </br></br>");
        $listes = Liste::all();
        foreach ($listes as $liste){
            $rs->getBody()->write("number : ".$liste['no']."</br>".
                "user_id : ".$liste['user_id']."</br>".
                "titre :".$liste['titre']."</br>".
                "description : ".$liste['description']."</br>".
                "expiration : ".$liste['expiration']."</br>".
                "token : ".$liste['token']."</br></br>");
        }
        $rs->getBody()->write('------------------------------------------</br>');
        return $rs;
    }

    function displayList(Request $rq, Response $rs, array $args){
        $num = $args['idListe'];
        $rs->getBody()->write("Liste numero $num : </br></br>");
        $liste = Liste::where('no','=',$num)->get()->first();
        $rs->getBody()->write("user_id :".$liste['user_id']."</br>".
                                "titre : ".$liste['titre']."</br>".
                                "description : ".$liste['description']."</br>".
                                "expiration : ".$liste['expiration']."</br>".
                                "token : ".$liste['token']."</br></br>");
        return $rs;
    }
}