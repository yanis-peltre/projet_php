<?php declare(strict_types = 1);

namespace mywishlist\vue;
use Slim\Container;

class VueItem
{
	protected $objet;
    protected $container;

	public function __construct(Container $c, $ob=null){
        $this->container = $c;
		$this->objet=$ob;
	}
	
	private function render_displayItemListe():String {
		return "
			<section><form action=\"acces_partage/voir_liste_partagee/\" method=\"GET\">
				<p><label>Consulter les items d'une liste</label><input type=\"text\" name=\"id\" size=3 required=\"true\"></p>
				<input type=\"submit\" value=\"Valider\">
			</form></section>
		";
	}
	
	private function render_listItem():String {
        $titre = $this->objet->titre;
        $desc = $this->objet->description;
        $creator = $this->objet->user->username;
        $res="<h2>Liste : $titre</h2><section>Createur : $creator</br>Description : $desc<ol>Les items de la liste :";
        $items = $this->objet->items;
		if(count($items) != 0){
            foreach($items as $i){
                $res=$res."<li>$i->nom - $i->tarif euros <br>$i->descr";
				$res=$res."
						<img src=\"";

				$nomImg = substr($i->img,0,4);

				if($nomImg == "http") {
					$res =  $res . $i->url . "\"width=100 height=100 alt=\"".$i->nom."\">
					";
				}
				else{
					$res = $res . "../../web/img/" . $i->img . "\"width=100 height=100 alt=\"".$i->nom."\">
					";
				}
				if($i->reserve!==null){
					$res=$res."<br><label> Reservé</label></li>";
				}
				else{
					$res=$res."</li>";
				}
            }
            $res=$res."</ol></section>";
		}
		else{
			$res=$res."<section><p>Il n'y a actuellement aucun objet dans cette liste.</p></section>";
		}

		return $res;
	}
	
	private function render_getItem() :String{
		if($this->objet!=null){
            $item = $this->objet;
			$res="<section><h2> Item : $item->nom </h2><p>Prix : $item->tarif</p>    
            <p>Description : $item->descr</p>";
            if(isset($item->img)) $res.="<img src ='$item->img' alt='Image'>";
            if(isset($item->url)) $res.="<p>Plus de détails : <a href='$item->url'>Cliquez ici</a></p>";

			if($this->objet->reserve==null){
				$res=$res."<form action=\"".$this->container->router->pathFor('reserver',['id'=>$this->objet->id])."\" method=\"POST\" name=\"res\" id=\"res\">
					<p><label>Entrer un nom pour réserver l'item : </label>
					<input type=\"text\" name=\"name\" size=40 required=\"true\" ";
					if(isset($_SESSION['profile']['username'])){
						$res=$res."value=\"".$_SESSION['profile']['username']."\"";
					}
					$res=$res."></p>
					<p><label>Ajouter un message parce que c'est sympa : 
					</label><input type=\"textarea\" name=\"mes\" size=100></p>
					<input type=\"submit\" value=\"Réserver\">
				</form>";
			}
			else{
				$res=$res."<p>Objet reservé</p>";
			}

			if($this->objet->cagnotte!==null && $this->objet->cagnotte<$this->objet->tarif){
				$res=$res."<form action=\"".$this->container->router->pathFor('donner_cagnotte',['id'=>$this->objet->id])."\" method=\"POST\" name=\"formcag\" id=\"formcag\">
					<p><label>Entrer un montant pour la cagnotte : </label>
					<input type=\"text\" name=\"cag\" size=40 required=\"true\"></p>
					<input type=\"submit\" value=\"Participer\">
				</form>
				<br><p>Montant actuel : ".$this->objet->cagnotte." euros</p>";
			}
			$res=$res."</section>";
		}
		else{
			$res="<p>Cet objet n'existe pas.</p>";
		}

		return $res;
	}
	
	private function render_formAddItem() :String{
		if($this->objet==null){
			$res="Pas de liste correspondante";
		}
		else{ 
			$res="
			<section><form action=\"".$this->container->router->pathFor('AddItemList',['no'=>$this->objet->no])."\" method=\"POST\" name=\"formitem\" id=\"formitem\">
				<p><label>Nom : </label><input type=\"text\" name=\"nom\" size=40 required=\"true\"></p>
				<p><label>Description : </label><input type=\"text\" name=\"des\" size=60></p>
				<p><label>Prix : </label><input type=\"text\" name=\"prix\" size=11 required=\"true\"></p>
				<p>
				<label>Image : 
				<input list=\"img\" name=\"img\" /></label>
				<datalist id=\"img\">";
				 

				$path = getcwd();
				$path = str_replace("\\", "/", $path);
				$path = $path . "/web/img";
				$array = scandir($path);

				foreach ($array as $value) {

					if (!in_array($value,array(".",".."))){
						$res = $res . "
						<option value=\"" . $value . "\">";
					}
				}

				$res = $res . "
			</datalist> </p>
				<input type=\"submit\" value=\"Ajouter l'item\">
			</form></section>";
		}

		return $res;
	}
	
	private function render_addItem():String {
		if($this->objet!==null){
			$res="<section><p>".$this->objet->nom." ajouté à la liste ".$this->objet->liste_id."
			<a href=\"".
			$this->container->router->pathFor('liste',['no'=>$this->objet->liste_id])."\">Retourner à ma liste</a></p></section>";
		}
		else{
			$res="<section><p>Impossible d'ajouter cet item.</p></section>";
		}

		return $res;
	}
	
	private function render_formModifyItem():String {
		if($this->objet==null){
			$res="Pas d'item correspondant";
		}
		else{
			$res="
			<section><form action=\"{$this->container->router->pathFor('modifItem',['id'=>$this->objet->id])}\" method=\"POST\" name=\"formmitem\" id=\"formmitem\">
				<p><label>Nom : {$this->objet->nom} </label><input type=\"text\" name=\"nom\" size=40 required=\"true\"></p>
				<p><label>Description : {$this->objet->descr} </label><input type=\"text\" name=\"des\" size=60></p>
				<p><label>Tarif : {$this->objet->tarif} </label><input type=\"text\" name=\"tarif\" size=11 required=\"true\"></p>
				<p>
				<label>Image : {$this->objet->img} 
				<input list=\"img\" name=\"img\" /></label>
				<datalist id=\"img\">";
				 

				$path = getcwd();
				$path = str_replace("\\", "/", $path);
				$path = $path . "/web/img";
				$array = scandir($path);

				foreach ($array as $value) {

					if (!in_array($value,array(".",".."))){
						$res = $res . "
						<option value=\"{$value}\">";
					}
				}
				
				$res = $res . "
				</datalist> </p>
				<input type=\"submit\" value=\"Modifier l'item\">
			</form>
			<form action=\"{$this->container->router->pathFor('formModifyList',['no'=>$this->objet->liste->no])}\" method=\"GET\" name=\"formmlist\" id=\"formmlist\">
				<input type=\"submit\" value=\"Retour à la liste\">
			</form>";
			if($this->objet->cagnotte==null && $this->objet->cagnotte!==0){
				$res=$res."<form action=\"{$this->container->router->pathFor('cagnotte',['id'=>$this->objet->id])}\" method=\"POST\" name=\"ajcag\" id=\"ajcag\">
					<input type=\"submit\" value=\"Ouvrir une cagnotte pour cet item\">
				</form></section>";
			}
			else{
				$res=$res."<p>Montant dans la cagnotte : {$this->objet->cagnotte} euros</p></section>";
			}
		}

		return $res;
	}
	
	private function render_modifyItem():String {
		if($this->objet!==null){
			$res="<section><p>Item ".$this->objet->nom." modifiée.<a href=\"".
			$this->container->router->pathFor('formModifyList',['no'=>$this->objet->liste_id])."\">Retourner à ma liste</a></p></section>";
		}
		else{
			$res="<section><p>Pas d'item correspondant.</p></section>";
		}

		return $res;
	}
	
	private function render_deleteItem():String {
		if($this->objet!==null){
			return "<section><p>Les items ont été supprimés.<a href=\"".
			$this->container->router->pathFor('formModifyList',['no'=>$this->objet])."\">Retourner à ma liste</a></p></section>";
		}
		else{
			return "<section><p>Aucun item selectionnés.<a href=\"javascript:history.go(-1)\">Retourner à ma liste</a></p></section>";
		}
	}
	
	public function render_displayAjoutCagnotte():String{
		return "<section><p>Cagnotte ouverte pour l'item ".$this->objet->id." .</p><a href=\"javascript:history.go(-1)\">Retourner à l'objet</a></section>";
	}
	
	public function render_giveCagnotte():String{
		return "<section><p>Vous venez de donner ".$this->objet[1]." euros pour la cagnotte de l'item "
		.$this->objet[0]->nom.". Merci !<a href=\"javascript:history.go(-2)\">Retourner aux objets</a></p></section>";
	}
	
	public function render_reservItem():String{	
		$res="<section><p>Vous venez de réserver l'item ".$this->objet->nom." sous le nom ".$this->objet->reserve." .<a href=\"javascript:history.go(-2)\">
		Retourner aux objets</a></p></section>";
		
		return $res;
	}
	
	public function render($selecteur) :String{
		switch ($selecteur) {
			case 1 : {
				$content = $this->render_displayItemListe();
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
				$content = $this->render_formAddItem();
				break;
			}
			case 5 : {
				$content = $this->render_addItem();
				break;
			}
			case 6 : {
				$content = $this->render_formModifyItem();
				break;
			}
			case 7 : {
				$content = $this->render_modifyItem();
				break;
			}
			case 9 : {
				$content = $this->render_deleteItem();
				break;
			}
			case 10 : {
				$content = $this->render_displayAjoutCagnotte();
				break;
			}
			case 11 : {
				$content = $this->render_giveCagnotte();
				break;
			}
			case 12 : {
				$content = $this->render_reservItem();
				break;
			}
			default : {
				$content = "Pas de contenu<br>";
				break;
			}
		}

		return 
		"<!DOCTYPE html>

		<html lang='fr'>
			<head>
				<meta charset=\"utf-8\"/>
				<link rel=\"stylesheet\" media=\"screen\" type=\"text/css\" href=\"web/css/style.css\"/>
				<title>sometext</title>
			</head>
			<body>
				<header>
					<nav>
						<h1><a href =".$this->container->router->pathFor("accueil").">The Wishlist</a></h1>
					</nav>
				</header>
				
                <div class=\"content\">
					$content
				</div>
				<footer>

				</footer>
			</body>
		<html>";
	}
}