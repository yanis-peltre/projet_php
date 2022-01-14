<?php

namespace mywishlist\vue;

//require_once __DIR__. "/../../vendor/autoload.php";
require_once 'src/conf/Database.php';
require_once 'src/models/Item.php';
require_once 'src/models/Liste.php';

use mywishlist\models\Item;
use mywishlist\models\Liste;

class VueParticipant{
	protected $objet;
	
	public function __construct($ob=null){
		$this->objet=$ob;
	}

	private function render_listList() {
		if($this->objet!==null){
			$res="<ul>Toutes les listes :";
			foreach($this->objet as $l){
				$res=$res."<li>".$l->no . ' : '.$l->titre.'</li>';
			}
			$res=$res."</ul>";
		}
		else{
			$res="<p>Il n'y a actuellement aucune liste.</p>";
		}
		
		return $res;
	}
	
	private function render_listItem() {
		if($this->objet!==null){
			$res="<ul>Les item de la liste :";
			foreach($this->objet as $i){
				$res=$res."<li>".$i->id . ' : '.$i->nom.'</li>';
			}
			$res=$res."</ul>";
		}
		else{
			$res="<p>Il n'y a actuellement aucun objet dans cette liste.</p>";
		}
		
		return $res;
	}
	
	private function render_getItem() {
		if($this->objet!=null){
			$res="<p>".$this->objet->id." : ".$this->objet->nom."</p>";
			if($this->objet->cagnotte!==null){
				$res=$res."<form action=\"participer_cagnotte/".$this->objet->id."\" method=\"POST\" name=\"formcag\" id=\"formcag\">
					<p><label>Entrer un montant pour la cagnotte : </label>
					<input type=\"text\" name=\"cag\" size=40 required=\"true\"></p>
					<input type=\"submit\" value=\"Participer\">
				</form>";
			}
		}
		else{
			$res="<p>Cet objet n'existe pas.</p>";
		}

		return $res;
	}
	
	private function render_formAddList() {
		$res="
		<form action=\"ajouter_liste\" method=\"POST\" name=\"formlist\" id=\"formlist\">
			<p><label>Titre : </label><input type=\"text\" name=\"titre\" size=40 required=\"true\"></p>
			<p><label>Description : </label><input type=\"text\" name=\"des\" size=60></p>
			<p><label>Date d'expiration : </label><input type=\"text\" name=\"exp\" size=11 required=\"true\"></p>
			<input type=\"submit\" value=\"Ajouter la liste\">
		</form>";
		
		return $res;
	}
	
	private function render_addList() {
		if($this->objet!==null){
			$res="<p>".$this->objet->no." : ".$this->objet->titre." token : ".$this->objet->token."</p>";
		}
		else{
			$res="<p>Cette liste n'existe pas.</p>";
		}
		
		return $res;
	}
	
	private function render_formAddItem() {
		if($this->objet==null){
			$res="Pas de liste correspondante";		
		}
		else{
			$res="
			<form action=\"ajouter_item/".$this->objet->token."\" method=\"POST\" name=\"formitem\" id=\"formitem\">
				<p><label>Nom : </label><input type=\"text\" name=\"nom\" size=40 required=\"true\"></p>
				<p><label>Description : </label><input type=\"text\" name=\"des\" size=60></p>
				<p><label>Prix : </label><input type=\"text\" name=\"prix\" size=11 required=\"true\"></p>
				<input type=\"submit\" value=\"Ajouter l'item\">
			</form>";/*3026*/
		}
		
		return $res;
	}
	
	private function render_addItem() {
		if($this->objet!==null){
			$res="<p>".$this->objet->nom." ajouté à la liste ".$this->objet->liste_id."</p>";
		}
		else{
			$res="<p>Impossible d'ajouter cet item.</p>";
		}
		
		return $res;
	}
	
	private function render_formModifyList() {
		if($this->objet==null){
			$res="Pas de liste correspondante";		
		}
		else{
			$res="
			<form action=\"modifier_liste/".$this->objet->token."\" method=\"POST\" name=\"formmlist\" id=\"formmlist\">
				<p><label>Titre : ".$this->objet->titre." </label><input type=\"text\" name=\"titre\" size=40 required=\"true\"></p>
				<p><label>Description : ".$this->objet->description." </label><input type=\"text\" name=\"des\" size=60></p>
				<p><label>Expiration : ".$this->objet->expiration." </label><input type=\"text\" name=\"exp\" size=11 required=\"true\"></p>
				<input type=\"submit\" value=\"Modifier la liste\">
			</form>
			
			<form action=\"formulaire_supprimer_liste/".$this->objet->token."\" method=\"GET\" name=\"formsuplist\" id=\"formsuplist\">
				<input type=\"submit\" value=\"Supprimer la liste\">
			</form>
			<form action=\"partager_liste/".$this->objet->token."\" method=\"GET\" name=\"formsendlist\" id=\"formsendlist\">
				<input type=\"submit\" value=\"Partager la liste\">
			</form>";
			$liste_ob=$this->objet->hasMany('mywishlist\models\Item', 'liste_id')->get();
			if($liste_ob!=null){
				$res=$res.
				"<form action=\"supprimer_item/".$this->objet->token."\" method=\"POST\" name=\"formitems\" id=\"formitems\"> 
					<ol>Les items de la liste :";
			}
			foreach($liste_ob as $ob){
				$res=$res."
				<li>
					<input type=\"checkbox\" id=\"".$ob->id."\" name=\"".$ob->id."\">
					<a href=\"formulaire_modification_item/".$ob->id."\"> 
						<img src=\"./../../web/img/".$ob->img."\" width=100 height=100 alt=\"".$ob->nom."\">
					</a>
				</li>";
			}
			if($liste_ob!=null){
				$res=$res.
				"	</ol>
					<input type=\"submit\" value=\"Supprimer les items sélectionnés\" id=\"envoi\">
				</form>";
			}

			$res=$res."<form action=\"commentaire/".$this->objet->token."\" method=\"POST\" id='messagesubmit' name=\"formmess\" id=\"formmlist\">
            <p>
                <label> Message </label>
            </p>
            <p>
                <textarea maxlength='300' cols='50' rows='6' name='Message' form='messagesubmit'>tapez votre message ici</textarea>
            </p>
                <input type=\"submit\" value=\"Ajouter Message\">
            </form>";
		}
		
		return $res;
	}
	
	private function render_modifyList() {
		if($this->objet!==null){
			$res="<p>Liste modifiée en ".$this->objet->titre." .</p>";
		}
		else{
			$res="<p>Pas de liste correspondante.</p>";
		}
		
		return $res;
	}
	
	private function render_formDeleteList() {
		if($this->objet==null){
			$res="Pas de liste correspondante";		
		}
		else{
			$res="
			<form action=\"supprimer_liste/".$this->objet->token."\" method=\"POST\" name=\"suplist\" id=\"suplist\">
				<input type=\"submit\" value=\"Oui\">
			</form>
			<form action=\"../".$this->objet->token."\" method=\"GET\" name=\"suplist\" id=\"suplist\">
				<input type=\"submit\" value=\"Non\">
			</form>";
		}
		
		return $res;
	}
	
	private function render_deleteList() {
		if($this->objet!==null){
			$res="<p>Liste ".$this->objet->titre." supprimée.</p>";
		}
		else{
			$res="<p>Pas de liste correspondante.</p>";
		}
		
		return $res;
	}
	
	private function render_formModifyItem() {
		if($this->objet==null){
			$res="Pas d'item correspondant";		
		}
		else{
			$res="
			<form action=\"modifier_item/".$this->objet->id."\" method=\"POST\" name=\"formmitem\" id=\"formmitem\">
				<p><label>Nom : ".$this->objet->nom." </label><input type=\"text\" name=\"nom\" size=40 required=\"true\"></p>
				<p><label>Description : ".$this->objet->descr." </label><input type=\"text\" name=\"des\" size=60></p>
				<p><label>Tarif : ".$this->objet->tarif." </label><input type=\"text\" name=\"tarif\" size=11 required=\"true\"></p>
				<input type=\"submit\" value=\"Modifier l'item\">
			</form>
			<form action=\"../".$this->objet->getToken()."\" method=\"GET\" name=\"formmlist\" id=\"formmlist\">
				<input type=\"submit\" value=\"Retour à la liste\">
			</form>
			<form action=\"ajout_cagnotte/".$this->objet->id."\" method=\"POST\" name=\"ajcag\" id=\"ajcag\">
				<input type=\"submit\" value=\"Ouvrir une cagnotte pour cet item\">
			</form>";
		}
		
		return $res;
	}

	private function render_ajouterMessage(){
        $res=$this->objet->addItem($_POST['Message']);

        return $res;
    }
	
	private function render_modifyItem() {
		if($this->objet!==null){
			$res="<p>Item ".$this->objet->nom." modifiée.</p>";
		}
		else{
			$res="<p>Pas d'item correspondant.</p>";
		}
		
		return $res;
	}
	
	private function render_formDeleteItem() {
		if(count($_GET)==0){
			$res="Aucun item sélectionné.";		
		}
		else{
			$res="<ul>Vous êtes sur le point de supprimer les items suivant(s) :";
			$token=0;
			foreach($_GET as $cle=>$val){
				$ob=Item::where('id','=',$cle)->first();
				if($token==0){
					$token=$ob->getToken();
				}
				$res=$res."
				<li>
					<p> ".$ob->nom." de la liste ".$ob->liste_id."</p>
				</li>";
			}
			$res=$res."</ul>";
				
			$res=$res."
			<form action=\"supprimer_item/".$token."\" method=\"POST\" name=\"supitem\" id=\"supitem\">
				<input type=\"submit\" value=\"Confirmer la suppression\">
			</form>
			<form action=\"../".$token."\" method=\"GET\" name=\"formmlist\" id=\"formmlist\">
				<input type=\"submit\" value=\"Annuler et revenir à la liste\">
			</form>";
		}
		
		return $res;
	}
	
	private function render_deleteItem() {
		return "<p>Les items ont été supprimés.</p>";
	}
	
	private function render_displayAccueil() {
		return 
		"<h2>Que voulez-vous faire ?</h2>
			<form action=\"liste\" method=\"GET\">
				<input type=\"submit\" value=\"Consulter les listes\">
			</form>
			<form action=\"cadeaux\" method=\"GET\">
				<input type=\"submit\" value=\"Consulter les items d'une liste\">
			</form>
		";
	}
	
	private function render_displayCadeaux() {
		return "
			<form action=\"cadeaux/afficheCadeaux/\" method=\"GET\">
				<p><label>Consulter les items d'une liste</label><input type=\"text\" name=\"id\" size=3 required=\"true\"></p>
				<input type=\"submit\" value=\"Valider\">
			</form>
		";
	}
	
	private function render_displayPartageUrl(){
		
		return "
			<p>Votre token de partage pour la liste ".$this->objet->no." est ".$this->objet->token_partage.".
			L'url de partage est /voir_liste_partager/{token}</p>
		";
	}
	
	private function render_displayPartageListe(){
		$res="<ul>Les items de la liste :";
		foreach($this->objet as $i){
				$res=$res."<li><a href=\"../item/".$i->id."\">".$i->id . ' : '.$i->nom."</a></li>";
			}
		$res=$res."</ul>";
		
		return $res;
	}
	
	public function render_displayAjoutCagnotte(){
		return "<p>Cagnotte ouverte pour l'item ".$this->objet->id." .</p>";
	}
	
	public function render_giveCagnotte(){
		return "<p>Vous venez de donner ".$this->objet[1]." euros pour la cagnotte de l'item "
		.$this->objet[0]->nom.". Merci !</p>";
	}
	
	public function render($selecteur) {
		switch ($selecteur) {
			case 1 : {
				$content = $this->render_listList();
				break;
			}
			case 2 : {
				$content = $this->render_listItem();
				break;
			}
			case 3 : {
				$content = $this->render_getItem();
				break;
			}
			case 4 : {
				$content = $this->render_formAddList();
				break;
			}
			case 5 : {
				$content = $this->render_addList();
				break;
			}
			case 6 : {
				$content = $this->render_formAddItem();
				break;
			}
			case 7 : {
				$content = $this->render_addItem();
				break;
			}
			case 8 : {
				$content = $this->render_formModifyList();
				break;
			}
			case 9 : {
				$content = $this->render_modifyList();
				break;
			}
			case 10 : {
				$content = $this->render_formDeleteList();
				break;
			}
			case 11 : {
				$content = $this->render_deleteList();
				break;
			}
			case 12 : {
				$content = $this->render_formModifyItem();
				break;
			}
			case 13 : {
				$content = $this->render_modifyItem();
				break;
			}
			case 14 : {
				$content = $this->render_formDeleteItem();
				break;
			}
			case 15 : {
				$content = $this->render_deleteItem();
				break;
			}
			case 16 : {
				$content = $this->render_displayAccueil();
				break;
			}
			case 17 : {
				$content = $this->render_displayCadeaux();
				break;
			}
			case 18 : {
				$content = $this->render_displayPartageUrl();
				break;
			}
			case 19 : {
				$content = $this->render_displayPartageListe();
				break;
			}
			case 20 : {
				$content = $this->render_displayAjoutCagnotte();
				break;
			}
            case 21 : {
                $content = $this->render_ajouterMessage();
                break;
            }
			case 22 : {
                $content = $this->render_giveCagnotte();
                break;
            }
			default : {
				$content = "Pas de contenu<br>";
				break;
			}
		}
		/*echo <<<END
		code
		END;*/
		$html = "
		<!DOCTYPE html>
		<html>
			<head>
				<link rel=\"stylesheet\" media=\"screen\" type=\"text/css\" href=\"web/css/style.css\"/>
				<script type=\"text/javascript\" src=\"./../../web/js/script.js\"></script>
				<title>sometext</title>
				<meta charset=\"utf-8\"/>
			</head>
			<body>
				<h1>Site de fou furieux</h1>
				<div class=\"content\">
					$content
				</div>
			</body>
		<html>";
		
		return $html;
	}
}