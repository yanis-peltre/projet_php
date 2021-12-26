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
			</form>";/*5704*/
		}
		
		return $res;
	}
	
	private function render_addItem() {
		$res=$this->objet->addItem($_POST['des'],$_POST['prix'],$_POST['nom']);
		
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
			default : {
				$content = "Pas de contenu<br>";
				break;
			}
		}
		$html = "
		<!DOCTYPE html>
		<html>
			<body>
				<div class=\"content\">
					$content
				</div>
			</body>
		<html>";
		
		return $html;
	}
}