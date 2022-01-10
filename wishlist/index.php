<?php

require_once __DIR__.'./vendor/autoload.php';
$config = require_once __DIR__ . "/src/conf/settings.php";


use mywishlist\models\ItemController;
use mywishlist\models\UserController;
use Illuminate\Database\Capsule\Manager as DB;


$container = new Slim\Container($config);
$app =new \Slim\App($config);

$db=new DB();
$config=parse_ini_file('./src/conf/conf.ini');
if($config) $db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();


/**
 * Page d'accueil
 */
$app->get('/',
    ItemController::class.":accueil")->setName("accueil");

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
    ItemController::class.':getItem')->setName("item");

/**
* Formulaire d'ajout de liste
*/
$app->get('/formulaire_liste[/]',
    ItemController::class.':formAddList')->setName("formAjouterListe");

/**
* Ajout de liste
*/
$app->post('/ajouter_liste[/]',
    ItemController::class.':addList')->setName("ajoutListe");

/**
* Formulaire ajout d'un item a une liste
*/
$app->get('/formulaire_item/{token}[/]',
    ItemController::class.':formAddItem')->setName("formAjouterItemAListe");



/**
* Ajout d'item a une liste
*/
$app->post('/formulaire_item/ajouter_item/{token}[/]',
    ItemController::class.':addItem')->setName("ajouterItemAListe");


/**
* Formulaire modification d'une liste
*/
$app->get('/formulaire_modif_liste/{token}[/]',
    ItemController::class.':formModifyList')->setName("formModifListe");


/**
* Modification d'une liste
*/
$app->post('/formulaire_modif_liste/modifier_liste/{token}[/]',
    ItemController::class.':modifyList')->setName("modifListe");


/**
* Formulaire suppression d'une liste
*/
$app->get('/formulaire_modif_liste/formulaire_supprimer_liste/{token}[/]',
    ItemController::class.':formDeleteList')->setName("formDeleteListe");


/**
* Suppression d'une liste
*/
$app->post('/formulaire_modif_liste/formulaire_supprimer_liste/supprimer_liste/{token}[/]',
    ItemController::class.':deleteList')->setName("deleteListe");


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

/**
 * Liste tous les users A SUPPRIMER
 */
$app->get('/users[/]',
    UserController::class.':listerUsers')->setName('listUsers');

/**
 * Liste tous les roles A SUPPRIMER
 */
$app->get('/roles[/]',
    UserController::class.':listerRoles')->setName('listRole');

/**
 * Formulaire inscription
 */
$app->get('/formulaireInscription[/]',
    UserController::class.':formulaireInscription')->setName('formInscription');

/**
 * Inscription
 */
$app->post('/inscription[/]',
    UserController::class.':inscription')->setName('inscription');

$app->run();



























