<?php

require_once __DIR__ . '/vendor/autoload.php';
/*require_once __DIR__ . '/src/conf/Database.php';
require_once __DIR__ . '/src/models/Item.php';
require_once __DIR__ . '/src/models/Liste.php';*/
require_once __DIR__ . '/src/models/ItemController.php';

use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\models\ItemController;
use \Psr\Http\Message\src\ResponseInterface as Response;
use \Psr\Http\Message\src\RequestInterface as Request;

$config = ['settings' => ['displayErrorDetails' => true]];
$app=new \Slim\App($config);

/**
* Liste des listes
*/
$app->get('/liste[/]',function($rq,$rs,$args){
	$url=$this['router']->pathFor('liste');
	
	$c=new ItemController();
	return $c->listListe( $rq, $rs, $args );
})->setName('liste');

/**
* Liste des items d'une liste
*/
$app->get('/cadeaux/{id}[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->listItem( $rq, $rs, $args );
})->setName('cadeaux');

/**
* Un item en particulier
*/
$app->get('/item/{id}[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->getItem( $rq, $rs, $args );
})->setName('item');

/**
* Formulaire d'ajout de liste
*/
$app->get('/formulaire_liste[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->formAddList( $rq, $rs, $args );
})->setName('formulaire_liste');

/**
* Ajout de liste
*/
$app->post('/ajouter_liste[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->addList( $rq, $rs, $args );
})->setName('ajouter_liste');

/**
* Formulaire ajout d'un item a une liste
*/
$app->get('/formulaire_item/{token}[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->formAddItem( $rq, $rs, $args );
})->setName('formulaire_item');

/**
* Ajout d'item a une liste
*/
$app->post('/formulaire_item/ajouter_item/{token}[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->addItem( $rq, $rs, $args );
})->setName('ajouter_item');

$app->run();



























