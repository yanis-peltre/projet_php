<?php

require_once __DIR__ .'/vendor/autoload.php';
//$config = require_once __DIR__ . "/src/conf/settings.php";

use mywishlist\controleurs\ControleurItem;
use mywishlist\controleurs\ControleurUser;
use mywishlist\controleurs\ControleurListe;
use mywishlist\controleurs\ControleurAccueil;
use Illuminate\Database\Capsule\Manager as DB;


//$container = new Slim\Container($config);
$config = ['settings' => ['displayErrorDetails' => true]];
$app =new \Slim\App($config);

/*$db=new DB();
$config=parse_ini_file('./src/conf/conf.ini');
if($config) $db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();*/


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
    ControleurItem::class.':getItem')->setName("item");


/**
* Formulaire d'ajout de liste
*/

$app->get('/formulaire_liste[/]',
    ControleurListe::class.':formAddList')->setName("formAjouterListe");


/**
* Ajout de liste
*/

$app->post('/ajouter_liste[/]',
    ControleurListe::class.':addList')->setName("ajoutListe");


/**
* Formulaire ajout d'un item a une liste
*/

$app->get('/formulaire_item/{token}[/]',
    ControleurItem::class.':formAddItem')->setName("formAjouterItemAListe");


/**
* Ajout d'item a une liste
*/

$app->post('/formulaire_item/ajouter_item/{token}[/]',
    ControleurItem::class.':addItem')->setName("ajouterItemAListe");


/**
* Formulaire modification d'une liste
*/

$app->get('/formulaire_modif_liste/{token}[/]',
    ControleurListe::class.':formModifyList')->setName("formModifListe");


/**
* Modification d'une liste
*/

$app->post('/formulaire_modif_liste/modifier_liste/{token}[/]',
    ControleurListe::class.':modifyList')->setName("modifListe");


/**
* Formulaire suppression d'une liste
*/

$app->get('/formulaire_modif_liste/formulaire_supprimer_liste/{token}[/]',
    ControleurListe::class.':formDeleteList')->setName("formDeleteListe");


/**
* Suppression d'une liste
*/

$app->post('/formulaire_modif_liste/formulaire_supprimer_liste/supprimer_liste/{token}[/]',
    ControleurListe::class.':deleteList')->setName("supprimer_liste")->setName("deleteListe");


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
    ControleurItem::class.':formDeleteItem')->setName('formulaire_suppression_item');


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


$app->post('/formulaire_modif_liste/commentaire/{token}[/]',
    ControleurItem::class.':ajouterMessage')->setName('ajouter_message');

/**
 * Liste tous les users A SUPPRIMER
 */
$app->get('/users[/]',
    ControleurUser::class.':listerUsers')->setName('listUsers');

/**
 * Liste tous les roles A SUPPRIMER
 */
$app->get('/roles[/]',
    ControleurUser::class.':listerRoles')->setName('listRole');

/**
 * Formulaire inscription
 */
$app->get('/formulaireInscription[/]',
    ControleurUser::class.':formulaireInscription')->setName('formInscription');

/**
 * Inscription
 */
$app->post('/inscription[/]',
    ControleurUser::class.':inscription')->setName('inscription');

$app->run();
