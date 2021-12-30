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

/**
* Formulaire modification d'une liste
*/
$app->get('/formulaire_modif_liste/{token}[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->formModifyList( $rq, $rs, $args );
})->setName('formulaire_modif_liste');

/**
* Modification d'une liste
*/
$app->post('/formulaire_modif_liste/modifier_liste/{token}[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->modifyList( $rq, $rs, $args );
})->setName('formulaire_modif_liste');

/**
* Formulaire suppression d'une liste
*/
$app->get('/formulaire_modif_liste/formulaire_supprimer_liste/{token}[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->formDeleteList( $rq, $rs, $args );
})->setName('formulaire_supprimer_liste');

/**
* Suppression d'une liste
*/
$app->post('/formulaire_modif_liste/formulaire_supprimer_liste/supprimer_liste/{token}[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->deleteList( $rq, $rs, $args );
})->setName('supprimer_liste');

/**
* Formulaire de modification d'un item
*/
$app->get('/formulaire_modif_liste/formulaire_modification_item/{id}[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->formModifyItem( $rq, $rs, $args );
})->setName('formulaire_modification_item');

/**
* Modification d'un item
*/
$app->post('/formulaire_modif_liste/formulaire_modification_item/modifier_item/{id}[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->modifyItem( $rq, $rs, $args );
})->setName('modifier_item');

/**
* Formulaire de suppression d'un item
*/
$app->get('/formulaire_modif_liste/formulaire_suppression_item/{token}[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->formDeleteItem( $rq, $rs, $args );
})->setName('formulaire_suppression_item');

/**
* Suppression d'un item
*/
$app->post('/formulaire_modif_liste/formulaire_suppression_item/supprimer_item/{token}[/]',function($rq,$rs,$args){
	$c=new ItemController();
	return $c->deleteItem( $rq, $rs, $args );
})->setName('supprimer_item');

$app->run();



























