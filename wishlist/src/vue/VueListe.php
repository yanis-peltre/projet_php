<?php declare(strict_types = 1);

namespace mywishlist\vue;
use mywishlist\vue\Vue;
use Slim\Container;

class VueListe extends Vue
{
	/**
	* Liste des listes publiques
	*/
	private function render_listList():String{
		if($this->objet!==null){
			$res="<section><ol>Toutes les listes publiques :";
			foreach($this->objet as $l){
                if(isset($l->user)){
                    $creator = $l->user->username;
                }else{
                    $creator = "";
                }
				if($l->publique=='x' && $l->valide=='x' && $l->expiration>=date('Y-m-d', time())){
					$res.="<li>$creator - <a href=". $this->container->router->pathFor('liste',['no'=>$l->no]).">".$l->titre."</a></li>";
				}
			}
			$res=$res."</ol></section>";
		}
		else{
			$res="<section><p>Il n'y a actuellement aucune liste publique.</p></section>";
		}

		return $res;
	}
	
	/**
	* Affichage d'une liste personnelle
	*/
	private function render_displayListePerso():String{
        $no = $this->objet->no;
		if($this->objet->expiration>=date('Y-m-d', time())){
			$res ="<section><form action=\"".
            $this->container->router->pathFor('formModifyList',['no'=> $no])."
            \" method=\"GET\">
			   <input type=\"submit\" name=\"modifListe\" value=\"Modifier la liste\">
			</form> 
			<form action='".$this->container->router->pathFor('formAddItemList',['no'=>$this->objet->no])."'>
				<input type='submit' name='ajouterItem' value='Ajouter un item'>
			</form>";
		}
        else{
			$res="<section><p>Liste expirée</p><form action=\"".
            $this->container->router->pathFor('formModifyList',['no'=> $no])."
            \" method=\"GET\">
			   <input type=\"submit\" name=\"reserve\" value=\"Consulter les réservations\">
			</form>";
		}

		$items = $this->objet->items;
        
		if(count($items) != 0){
			$titre = $this->objet->titre;
			$desc = $this->objet->description;
			$creator = $this->objet->user->username;
			$res=$res."<h2>Liste : $titre</h2>Createur : $creator</br>Description : $desc<ol>Les items de la liste :";
			
            foreach($items as $i){
                $res=$res."
				<li> <p>$i->nom - $i->tarif euros <br>$i->descr</p>";
				if($i->reserve!==null){
					$res=$res."<label> Reservé</label></li>";
				}
				else{
					$res=$res."</li>";
				}
				
				$res = $res . "<img src=\"";
				if(substr($i->img,0,4)=="http"){
					$res = $res . $i->img . "width=100 height=100>";
				}else {
					$path = getcwd();
					$path = str_replace("\\", "/", $path);
	
					$res = $res . $path . "/web/img/" . $i->img ."\" width=100 height=100>";
				}
            }
            $res=$res."</ol></section>";
		}
		else{
			$res=$res."<p>Il n'y a actuellement aucun objet dans cette liste.</p></section>";
		}

		return $res;
	}
	
	/**
	* Formulaire d'ajout de liste
	*/
	private function render_formAddList():String {
		$res="
		<section><form action=\"".$this->container->router->pathFor("ajoutListe") ."\" method=\"POST\" name=\"formlist\" id=\"formlist\">
			<p><label>Titre : </label><input type=\"text\" name=\"titre\" size=40 required=\"true\"></p>
			<p><label>Description : </label><input type=\"text\" name=\"des\" size=60></p>
			<p><label>Date d'expiration : </label><input type=\"date\" name=\"exp\" required=\"true\"></p>
			<p><label>Rendre publique : </label><input type=\"checkbox\" name=\"publique\" \"></p>
			<input type=\"submit\" value=\"Ajouter la liste\">
		</form></section>";

		return $res;
	}
	
	/**
	* Liste ajoutée
	*/
	private function render_addList() :String{
		if($this->objet!==null){
			$res="<section><p>".$this->objet->no." : ".$this->objet->titre." token : ".$this->objet->token."
			<a href=\"".
			$this->container->router->pathFor('listesPersos')."\">Retourner à mes listes</a></p></section>";
		}
		else{
			$res="<p>Cette liste n'existe pas.</p></section>";
		}

		return $res;
	}
	
	/**
	* Formulaire modification de liste
	*/
	private function render_formModifyList():String {
		if($this->objet==null){
			$res="<section><p>Pas de liste correspondante</p></section>";
		}
		else{
            $no = $this->objet->no;
			$res="<section>
			<form action='". $this->container->router->pathFor('modifListe',['no'=>$no])."' method=\"POST\" name=\"formmlist\" id=\"formmlist\">
				<p><label>Titre : ".$this->objet->titre." </label><input type=\"text\" name=\"titre\" size=40 required=\"true\"></p>
				<p><label>Description : ".$this->objet->description." </label><input type=\"text\" name=\"des\" size=60></p>
				<p><label>Expiration : ".$this->objet->expiration." </label><input type=\"date\" name=\"exp\" size=11 required=\"true\"></p>
				<input type=\"submit\" value=\"Modifier la liste\">

			</form>";

			$liste_ob=$this->objet->hasMany('mywishlist\models\Item', 'liste_id')->get();
			if($liste_ob!=null){
				$res=$res.
				"<form action=\"".$this->container->router->pathFor('deleteItem',['no'=>$no])."\" method=\"POST\" name=\"formitems\" id=\"formitems\">
					<ol>Les items de la liste :";
			}
			foreach($liste_ob as $ob){

				$res=$res."
				<li>
					<input type=\"checkbox\" id=\"".$ob->id."\" name=\"".$ob->id."\">";

					$res=$res."<a href=\"formulaire_modification_item/".$ob->id."\">
						<img src=\"";

				$nomImg = substr($ob->img,0,4);

				if($nomImg == "http") {
					$res =  $res . $ob->img . "\"width=100 height=100 alt=\"".$ob->nom."\">
					</a>";
				}
				else{
					$path = getcwd();
					$path = str_replace("\\", "/", $path);
					
					$res = $res . $path . "/web/img" . $ob->img . "\"width=100 height=100 alt=\"".$ob->nom."\">
					</a>";
				}
				if($ob->reserve!==null){
					$res = $res ."<label>Reservé</label>";
				}
				$res = $res ."</li>";
			}
			if($liste_ob!=null){
				$res=$res.
				"	</ol>
					<input type=\"submit\" value=\"Supprimer les items sélectionnés\" id=\"envoi\">
				</form>";
			}
			
			$res=$res."<form action=\"".$this->container->router->pathFor('ajouterMessageListe',['no'=>$this->objet->no])."\" method=\"POST\" id='messagesubmit' name=\"messagesubmit\">
            <p>
                <label> Message </label>
            </p>
            <p>
                <textarea maxlength='300' cols='50' rows='6' name='Message' placeholder='tapez votre message ici'></textarea>
            </p>
                <input type=\"submit\" value=\"Ajouter Message\">
            </form></section>";

			$res=$res."<aside>";
			if($this->objet->message!==null){
				$res=$res."<p>".$this->objet->message."</p>";
			}
			$res=$res."<form action=\"".$this->container->router->pathFor('formDeleteList',['no'=>$no])."\" method=\"GET\" name=\"formsuplist\" id=\"formsuplist\">
				<input type=\"submit\" value=\"Supprimer la liste\">
			</form>";
			if($this->objet->valide!==null){
				$res=$res."<form action=\"".$this->container->router->pathFor('shareList',['no'=>$no])."\" method=\"GET\" name=\"formsendlist\" id=\"formsendlist\">
				<input type=\"submit\" value=\"Partager la liste\">
				</form>";
			}
			if($this->objet->publique==null){
				$res=$res."<form action=\"publique/".$this->objet->token."\" method=\"POST\" name=\"pub\" id=\"pub\">
					<p><label>La liste n'est pas publique </label></p>
					<input type=\"submit\" value=\"Rendre la liste publique\">
				</form>";
			}
			else{
				$res=$res."<form action=\"publique/".$this->objet->token."\" method=\"POST\" name=\"pub\" id=\"pub\">
					<p><label>La liste est publique </label></p>
					<input type=\"submit\" value=\"Rendre la liste privée\">
				</form>";
			}
			if($this->objet->valide==null){
				$res=$res."<form action=\"valide/".$this->objet->token."\" method=\"POST\" name=\"pub\" id=\"pub\">
					<p>
						<input type=\"submit\" value=\"Valider la liste\">
					</p>
				</form>";
			}
			$res=$res."<p><a href=\"".
			$this->container->router->pathFor('listesPersos')."\">Retourner à mes listes</a></p>";

			$res=$res."</aside>";
		}
		return $res;
	}
	
	/**
	* Liste modifiée
	*/
	private function render_modifyList():String {
		if($this->objet!==null){
			$res="<section><p>Liste modifiée en ".$this->objet->titre." .<a href=\"".
			$this->container->router->pathFor('formModifyList',['no'=>$this->objet->no])."\">Retourner à ma liste</a></p></section>";
		}
		else{
			$res="<section><p>Pas de liste correspondante.</p></section>";
		}

		return $res;
	}
	
	/**
	* Formulaire de suppression d'une liste
	*/
	private function render_formDeleteList():String {
		if($this->objet==null){
			$res="Pas de liste correspondante";
		}
		else{
			$res="<section>Voulez vous vraiment supprimer la liste ? </br>
			<form action=\"".$this->container->router->pathFor('deleteList',['no'=>$this->objet->no])."\" method=\"POST\" name=\"suplist\" id=\"suplist\">
				<input type=\"submit\" value=\"Oui\">
			</form>
			<form action=\"".$this->container->router->pathFor('formModifyList',['no'=>$this->objet->no])."\" method=\"GET\" name=\"suplist\" id=\"suplist\">
				<input type=\"submit\" value=\"Non\">
			</form></section>";
		}
		return $res;
	}
	
	/**
	* Liste supprimée
	*/
	private function render_deleteList():String {
		if($this->objet!==null){
			$res="<section><p>Liste ".$this->objet->titre." supprimée. <a href=\"".
			$this->container->router->pathFor('listesPersos')."\">Retourner à mes listes</a></p></section>
			";
		}
		else{
			$res="<p>Pas de liste correspondante.</p>";
		}

		return $res;
	}
	
	/**
	* url et token de partage
	*/
	private function render_displayPartageUrl():String{

		return "
			<section><p>Votre token de partage pour la liste ".$this->objet->no." est ".$this->objet->token_partage.".
			L'url de partage est : ".$this->container->router->pathFor('formCheckList').
            " <a href=\"".
			$this->container->router->pathFor('formModifyList',['no'=>$this->objet->no])."\">Retourner à ma liste</a></p></section>
		";
	}
	
	/**
	* Formulaire d'accès à une liste partagée
	*/
	private function render_formShareList():String{
        $res = "<section><form action='". $this->container->router->pathFor('checkList')."' method='GET'>
            <input type='text' name='sharedToken' placeholder='Rentrez le token de partage' size='25px'>
            <input type='submit'>
        </form></section>";
        return $res;
    }
	
	/**
	* Liste passée en publique ou privée
	*/
	public function render_putPublique():String{
		if($this->objet->publique=='x'){
			$res="<section><p>Votre liste est maintenant publique. Elle sera visible par tous les utilisateurs.<a href=\"".
			$this->container->router->pathFor('formModifyList',['no'=>$this->objet->no])."\">Retourner à ma liste</a></p></section>";
		}
		else{
			$res="<section><p>Votre liste est maintenant privée. Elle ne sera visible plus par les utilisateurs.<a href=\"".
			$this->container->router->pathFor('formModifyList',['no'=>$this->objet->no])."\">Retourner à ma liste</a></p></section>";
		}
		return $res;
	}
	
	/**
	* Vue des listes personnelles
	*/
	private function render_myLists():String{
        $res =  "<section><form action = \"".$this->container->router->pathFor('formAjouterListe')." \"method='GET'>
                    <input type='submit' value=\"Creer une liste\">
                </form>";
		if(count($this->objet) != 0){
        $res.="<ol>Mes listes :";
        
            foreach($this->objet as $l){

                $res.="<li><a href=\"".$this->container->router->pathFor('liste',['no'=>$l->no])."\">".$l->no . " : ".$l->titre."</a></li>";
				if($l->token_partage!=0){
					$res=$res." Partagée</p></li>";
				}
				else{
					$res=$res."</p></li>";
				}
			}
            $res.="</ol></section>";

        }
        else{
            $res.="<p>Vous n'avez pas encore créé de liste.</p></section>";
        }
        return $res;
    }
	
	/**
	* Message ajouté à une liste
	*/
	private function render_addMessage():String{
		if($this->objet->message!==null){
			$res="<section><p>Message ajouté à la liste ".$this->objet->titre.".<a href=\"".
			$this->container->router->pathFor('formModifyList',['no'=>$this->objet->no])."\">Retourner à ma liste</a></p></section>";
		}
        else{
			$res="<section><p>Aucun message ajouté.</p></section>";
		}
		return $res;
    }
	
	/**
	* Vue d'une liste partagée
	*/
	private function render_displayListePartage():String{
		if($this->objet!==null){
			$liste = $this->objet;
			$creator = $liste->user->username;
			$res = "<section><h2>Nom de la liste : $liste->titre</h2>";
			$res.= "Createur : $creator</br>Description : $liste->description";
			$res.="<ul>Les items de la liste :";
			$items = $liste->items;
			foreach($items as $i){
				$res=$res."<li><p><a href=\"". $this->container->router->pathFor('item',['id'=>$i->id])."\">".$i->id . ' : '.$i->nom."</a>";
				if($i->reserve!==null){
					$res=$res." Reservé</p></li>";
				}
				else{
					$res=$res."</p></li>";
				}
			}
			$res=$res."</ul></section>";
		}
        else{
			$res="<section><p>Aucune liste correspondante</p></section>";
		}

        return $res;
    }
	
	/**
	* Liste validée
	*/
	private function render_valider():String{
		return "<section><p>Vous vener de valider la liste ".$this->objet->titre.". Elle pourra être visible
		par les autres utilisateurs si vous la rendez publique.<a href=\"javascript:history.go(-1)\">Retourner à ma liste</a>
			</p></section>";
    }
	
	/**
	* Vue d'une liste expirée
	*/
	private function render_listeExpiree():String {
		$res="<section><p>Liste expirée</p>";
		
		if(count($this->objet)==0){
			$res=$res."<p>Aucune réservation</p>";
		}
		else{
			$res=$res."<ul>Liste des réservations : ";
			foreach($this->objet as $ob){
				if($ob->reserve!==null){
					$res=$res."<li>".$ob->nom." : ".$ob->reserve." : ";
					if($ob->message==""){
						$res=$res."Pas de message";
					}
					else{
						$res=$res."".$ob->message;
					}
				}
				$res=$res."</li>";
			}
			$res=$res."</ul>";
		}
		
		$res=$res."<p><a href=\"".
		$this->container->router->pathFor('listesPersos')."\">Retourner à mes listes</a></p></section>";

		return $res;
	}
	
	public function render($selecteur) :String{
		switch ($selecteur) {
			case 1 : {
				$content = $this->render_listList();
				break;
			}
			case 2 : {
				$content = $this->render_displayListePerso();
				break;
			}
			case 3 : {
				$content = $this->render_formAddList();
				break;
			}
			case 4 : {
				$content = $this->render_addList();
				break;
			}
			case 5 : {
				$content = $this->render_formModifyList();
				break;
			}
			case 6 : {
				$content = $this->render_modifyList();
				break;
			}
			case 7 : {
				$content = $this->render_formDeleteList();
				break;
			}
			case 8 : {
				$content = $this->render_deleteList();
				break;
			}
			case 9 : {
				$content = $this->render_displayPartageUrl();
				break;
			}
			case 10 : {
				$content = $this->render_formShareList();
				break;
			}
			case 11 : {
				$content = $this->render_putPublique();
				break;
			}
			case 12 : {
				$content = $this->render_myLists();
				break;
			}
			case 13 : {
				$content = $this->render_addMessage();
				break;
			}
			case 14 : {
				$content = $this->render_displayListePartage();
				break;
			}
			case 15 : {
				$content = $this->render_valider();
				break;
			}
			case 16 : {
				$content = $this->render_listeExpiree();
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