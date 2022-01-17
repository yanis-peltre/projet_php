<?php

//TODO Améliorer interface
// Modification et suppression des comptes
// Afficher la liste des créateurs au lieu des listes publiques


require_once __DIR__ .'/vendor/autoload.php';
$config = require_once __DIR__ . "/src/conf/settings.php";

use mywishlist\controleurs\ControleurItem;
use mywishlist\controleurs\ControleurUser;
use mywishlist\controleurs\ControleurListe;
use mywishlist\controleurs\ControleurAccueil;
use Illuminate\Database\Capsule\Manager as DB;

session_start();



$container = new Slim\Container($config);
//$config = ['settings' => ['displayErrorDetails' => true]];
$app =new \Slim\App($config);

$db=new DB();
$config=parse_ini_file('./src/conf/conf.ini');
if($config) $db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();


// ACCUEIL -----------------------------
/**
 * Page d'accueil
 */
$app->get('/',
    ControleurAccueil::class.":displayAccueil")->setName("accueil");


// LISTE -----------------------------
/**
* Voir toutes les listes publiques
*/
$app->get('/listePubliques[/]',
    ControleurListe::class.":publicLists")->setName("affichageListes");

/**
 * Voir les listes personnelles créées
 */

$app->get('/listes_persos[/]',
    ControleurListe::class.':myLists');

/**
 * Affiche une liste
 */
$app->get('/liste/{no}[/]',
    ControleurListe::class.":afficheListe")->setName("liste");

/**
 * Affiche une liste partagée
 */

$app->get('/listePartagee/{sharedToken}[/]',
    ControleurListe::class.":afficheListePartagee")->setName("sharedListe");

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
 * Formulaire modification d'une liste
 */

$app->get('/liste/formulaire_modif_liste/{no}[/]',
    ControleurListe::class.':formModifyList')->setName("formModifListe");


/**
 * Modification d'une liste
 */

$app->post('/liste/formulaire_modif_liste/modifier_liste/{no}[/]',
    ControleurListe::class.':modifyList')->setName("modifListe");


/**
 * Formulaire suppression d'une liste
 */

$app->get('/liste/formulaire_modif_liste/formulaire_supprimer_liste/{no}[/]',
    ControleurListe::class.':formDeleteList')->setName("formDeleteListe");


/**
 * Suppression d'une liste
 */

$app->post('/liste/formulaire_modif_liste/formulaire_supprimer_liste/supprimer_liste/{no}[/]',
    ControleurListe::class.':deleteList')->setName("supprimer_liste")->setName("deleteListe");

/**
 * Partager une liste 7524
 */

$app->get('/liste/formulaire_modif_liste/partager_liste/{no}[/]',
    ControleurListe::class.':shareList');

/**
 * Formulaire accès liste partagée
 */

$app->get('/acces_partage[/]',
    ControleurListe::class.':formCheckList');

/**
 * Voir une liste partagée
 */

$app->get('/acces_partagee/voir_liste_partagee[/]',
    ControleurListe::class.':checkList');




// ITEMS ----------------------------------------------

/**
* Formulaire des items d'une liste
*/

$app->get('/cadeaux[/]',
    ControleurAccueil::class.":displayItemListe")->setName("cadeaux");

/**
* Un item en particulier
*/

$app->get('/item/{id}[/]',
    ControleurItem::class.':getItem')->setName("item");

/**
* Réservation d'item
*/

$app->post('/item/reserver/{id}[/]',
    ControleurItem::class.':reservItem')->setName("reserver");





/**
 * Formulaire ajout d'un item a une liste
 */

$app->get('/liste/{no}/formulaireAjoutItem[/]',
    ControleurItem::class.':formAddItem')->setName("formAjouterItemAListe");

/**
* Ajout d'item a une liste
*/

$app->post('/liste/{no}/ajouter_item[/]',
    ControleurItem::class.':addItem')->setName("ajouterItemAListe");





/**
* Formulaire de modification d'un item
*/

$app->get('/liste/formulaire_modif_liste/formulaire_modification_item/{id}[/]',
    ControleurItem::class.':formModifyItem')->setName('formulaire_modification_item');


/**
* Modification d'un item
*/

$app->post('/liste/formulaire_modif_liste/formulaire_modification_item/modifier_item/{id}[/]',
    ControleurItem::class.':modifyItem')->setName('modifier_item');


/**
* Formulaire de suppression d'un item
*/

$app->get('/liste/formulaire_modif_liste/formulaire_suppression_item/{token}[/]',
    ControleurItem::class.':formDeleteItem')->setName('formulaire_suppression_item');


/**
* Suppression d'un item
*/
$app->post('/liste/formulaire_modif_liste/supprimer_item/{no}[/]',
    ControleurItem::class.':deleteItem')->setName('supprimer_item');
	

	
/**
* Ajouter une cagnotte
*/
$app->post('/formulaire_modif_liste/formulaire_modification_item/ajout_cagnotte/{id}[/]',
	ControleurItem::class.':addCagnotte')->setName('cagnotte');
	
/**
* Donner de l'argent pour une cagnotte
*/
$app->post('/item/participer_cagnotte/{id}[/]',
	ControleurItem::class.':giveCagnotte')->setName('donner_cagnotte');

/**
* Ajouter un message à une liste
*/
$app->post('/formulaire_modif_liste/commentaire/{token}[/]',
    ControleurItem::class.':ajouterMessage')->setName('ajouter_message');

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
	
/**
 * Rendre une liste publique
 */
$app->post('/liste/formulaire_modif_liste/publique/{no}[/]',
    ControleurListe::class.':putPublic')->setName('publique');

/**
 * Formulaire connexion
 */
$app->get('/formulaireConnexion[/]',
    ControleurUser::class.':formulaireConnexion')->setName('formConnexion');

/**
 * Connexion
 */
$app->post('/connexion[/]',
    ControleurUser::class.':connexion')->setName('connexion');

/**
 * Deconnexion
 */
$app->get('/deconnexion[/]',
    ControleurUser::class.':deconnexion')->setName('deconnexion');

/**
 * Modification de compte
 */
$app->get('/monCompte[/]',
ControleurUser::class.':voirCompte')->setName('modifCompte');

$app->run();