<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/controller/ControleurAccueil.php';
require_once __DIR__ . '/src/controller/ControleurItem.php';
require_once __DIR__ . '/src/controller/ControleurListe.php';

use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\controller\ControleurAccueil;
use mywishlist\controller\ControleurItem;
use mywishlist\controller\ControleurListe;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$config = ['settings' => ['displayErrorDetails' => true]];
$app=new \Slim\App($config);


/**
 * Page d'accueil
 */
$app->get('/',
    ControleurAccueil::class.":displayAccueil")->setName("accueil");

/**
* Liste des listes
*/

$app->get('/liste[/]',
    ControleurListe::class.":listListe")->setName("liste");

/**
* Formulaire des items d'une liste
*/

$app->get('/cadeaux[/]',
    ControleurAccueil::class.":displayItemListe")->setName("cadeaux");

/**
* Liste des items d'une liste
*/

$app->get('/cadeaux/afficheCadeaux[/]',
    ControleurItem::class.":listItem")->setName("cadeaux");


/**
* Un item en particulier
*/

$app->get('/item/{id}[/]',
    ControleurItem::class.':getItem');


/**
* Formulaire d'ajout de liste
*/

$app->get('/formulaire_liste[/]',
    ControleurListe::class.':formAddList');


/**
* Ajout de liste
*/

$app->post('/ajouter_liste[/]',
    ControleurListe::class.':addList');


/**
* Formulaire ajout d'un item a une liste
*/

$app->get('/formulaire_item/{token}[/]',
    ControleurItem::class.':formAddItem');


/**
* Ajout d'item a une liste
*/

$app->post('/formulaire_item/ajouter_item/{token}[/]',
    ControleurItem::class.':addItem');


/**
* Formulaire modification d'une liste
*/

$app->get('/formulaire_modif_liste/{token}[/]',
    ControleurListe::class.':formModifyList');


/**
* Modification d'une liste
*/

$app->post('/formulaire_modif_liste/modifier_liste/{token}[/]',
    ControleurListe::class.':modifyList');


/**
* Formulaire suppression d'une liste
*/

$app->get('/formulaire_modif_liste/formulaire_supprimer_liste/{token}[/]',
    ControleurListe::class.':formDeleteList');


/**
* Suppression d'une liste
*/

$app->post('/formulaire_modif_liste/formulaire_supprimer_liste/supprimer_liste/{token}[/]',
    ControleurListe::class.':deleteList')->setName("supprimer_liste");


/**
* Formulaire de modification d'un item
*/

$app->get('/formulaire_modif_liste/formulaire_modification_item/{id}[/]',
    ControleurItem::class.':formModifyItem')->setName('formulaire_modification_item');


/**
* Modification d'un item
*/

$app->post('/formulaire_modif_liste/formulaire_modification_item/modifier_item/{id}[/]',
    ControleurItem::class.':modifyItem')->setName('modifier_item');


/**
* Formulaire de suppression d'un item
*/

$app->get('/formulaire_modif_liste/formulaire_suppression_item/{token}[/]',
    ItemController::class.':formDeleteItem')->setName('formulaire_suppression_item');


/**
* Suppression d'un item
*/
$app->post('/formulaire_modif_liste/supprimer_item/{token}[/]',
    ControleurItem::class.':deleteItem')->setName('supprimer_item');
	
/**
* Partager une liste 7524
*/

$app->get('/formulaire_modif_liste/partager_liste/{token}[/]',
    ControleurListe::class.':shareList');
	
/**
* Voir une liste partagée
*/

$app->get('/voir_liste_partager/{token}[/]',
    ControleurListe::class.':checkList');
	
/**
* Ajouter une cagnotte
*/

$app->post('/formulaire_modif_liste/formulaire_modification_item/ajout_cagnotte/{id}[/]',
	ControleurItem::class.':addCagnotte')->setName('cagnotte');

$app->run();



























