<?php

namespace mywishlist\controleurs;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ControleurAccueil
{

    private $container; //conteneur de dépendances.

    public function __construct(Container $c)
    {
        $this->container = $c;
    }

    function displayAccueil(Request $rq, Response $rs, array $args){
        $urlListe = $this->container->router->pathFor('displayAllLists');
        $html = "<h1>Accueil</h1></br>";
        $html .= "<a href=\"$urlListe\">Voir toutes les listes</a>";

        $rs->getBody()->write($html);
    }

}