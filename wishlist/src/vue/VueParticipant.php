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
	
	public function __construct($ob){
		$this->objet=$ob;
	}

	private function render_listList() {
		$res=Liste::listListe($this->objet);
		
		return $res;
	}
	
	private function render_listItem() {
		$res=$this->objet->items();
		
		return $res;
	}
	
	private function render_getItem() {
		$res=$this->objet->getItem();
		
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
		$res=$this->objet->createList($_POST['des'],$_POST['exp'],$_POST['titre']);
		
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
		$res=$this->objet->addItem($_POST['des'],$_POST['prix'],$_POST['nom']);
		
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
			</form>";
			$liste_ob=$this->objet->hasMany('mywishlist\models\Item', 'liste_id')->get();
			if($liste_ob!=null){
				$res=$res.
				"<form action=\"formulaire_suppression_item/".$this->objet->token."\" name=\"formitems\" id=\"formitems\"> 
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
		}
		
		return $res;
	}
	
	private function render_modifyList() {
		$res=$this->objet->modifyList($_POST['des'],$_POST['exp'],$_POST['titre']);
		
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
		$res=$this->objet->deleteList();
		
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
			</form>";
		}
		
		return $res;
	}
	
	private function render_modifyItem() {
		$res=$this->objet->modifyItem($_POST['des'],$_POST['tarif'],$_POST['nom']);
		
		return $res;
	}
	
	private function render_formDeleteItem() {
		if($this->objet==null){
			$res="Pas d'item correspondant";		
		}
		else{
			$res="<ul>Vous êtes sur le point de supprimer les items suivant(s) :";
			foreach($this->ob as $ob){
				$res=$res."
				<li>
					<p> ".$ob->nom." de la liste ".$ob->liste_id."</p>
				</li>";
			}
			$res=$res."</ul>";
				
			$res=$res."
			<form action=\"supprimer_item\" method=\"POST\" name=\"supitem\" id=\"supitem\">
				<input type=\"submit\" value=\"Confirmer la suppression\">
			</form>
			<form action=\"../".$this->objet[1]->getToken()."\" method=\"GET\" name=\"formmlist\" id=\"formmlist\">
				<input type=\"submit\" value=\"Annuler et revenir à la liste\">
			</form>";
		}
		
		return $res;
	}
	
	private function render_deleteItem() {
		$res="";
		foreach($this->ob as $ob){
			$res=$ob->deleteItem();
		}
		
		return $res;
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
			default : {
				$content = "Pas de contenu<br>";
				break;
			}
		}
		$html = "
		<!DOCTYPE html>
		<html>
			<head>
				<script type=\"text/javascript\" src=\"./../../web/js/script.js\"></script>
				<title>sometext</title>
				<meta charset=\"utf-8\"/>
			</head>
			<body>
				<div class=\"content\">
					$content
				</div>
			</body>
		<html>";
		
		return $html;
	}
}