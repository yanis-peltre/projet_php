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
 * Page d'accueil
 */
$app->get('/',
    ItemController::class.":accueil")->setName("accueil")->setName("accueil");

/**
* Liste des listes
*/
$app->get('/liste[/]',
    ItemController::class.":listListe")->setName("liste");

/**
* Liste des items d'une liste
*/
$app->get('/cadeaux/{id}[/]',
    ItemController::class.":listItem")->setName("cadeaux");

/**
* Un item en particulier
*/
$app->get('/item/{id}[/]',
    ItemController::class.':getItem');

/**
* Formulaire d'ajout de liste
*/
$app->get('/formulaire_liste[/]',
    ItemController::class.':formAddList');

/**
* Ajout de liste
*/
$app->post('/ajouter_liste[/]',
    ItemController::class.':addList');

/**
* Formulaire ajout d'un item a une liste
*/
$app->get('/formulaire_item/{token}[/]',
    ItemController::class.':formAddItem');



/**
* Ajout d'item a une liste
*/
$app->post('/formulaire_item/ajouter_item/{token}[/]',
    ItemController::class.':addItem');


/**
* Formulaire modification d'une liste
*/
$app->get('/formulaire_modif_liste/{token}[/]',
    ItemController::class.':formModifyList');


/**
* Modification d'une liste
*/
$app->post('/formulaire_modif_liste/modifier_liste/{token}[/]',
    ItemController::class.':modifyList');


/**
* Formulaire suppression d'une liste
*/
$app->get('/formulaire_modif_liste/formulaire_supprimer_liste/{token}[/]',
    ItemController::class.':formDeleteList');


/**
* Suppression d'une liste
*/
$app->post('/formulaire_modif_liste/formulaire_supprimer_liste/supprimer_liste/{token}[/]',
    ItemController::class.':deleteList')->setName("supprimer_liste");


/**
* Formulaire de modification d'un item
*/
$app->post('/formulaire_modif_liste/formulaire_modification_item/{id}[/]',
    ItemController::class.':addList')->setName('formulaire_modification_item');


/**
* Modification d'un item
*/
$app->post('/formulaire_modif_liste/formulaire_modification_item/modifier_item/{id}[/]',
    ItemController::class.':modifyItem')->setName('modifier_item');


/**
* Formulaire de suppression d'un item
*/
$app->get('/formulaire_modif_liste/formulaire_suppression_item/{token}[/]',
    ItemController::class.':formDeleteItem')->setName('formulaire_suppression_item');


/**
* Suppression d'un item
*/
$app->post('/formulaire_modif_liste/formulaire_suppression_item/supprimer_item/{token}[/]',
    ItemController::class.':deleteItem')->setName('supprimer_item');


$app->run();



























