<?php

namespace mywishlist\vue;

use Slim\App;

class VueAccount
{
    protected $object;
    protected $container;

    public function __construct($c, $ob=null){
        $this->object=$ob;
        $this->container = $c;
    }

    public function render($selecteur){
        switch ($selecteur){
            case 1:
                $content = $this->render_formulaireInscription();
                break;
            case 2:
                $content = $this->render_formulaireConnexion();
                break;
            case 3 :
                $content = $this->render_connexion();
                break;
            case 4 :
                $content = $this->render_profile();
                break;
            case 5 :
                $content = $this->render_accessDenied();
                break;
            case 6 :
                $content = $this->render_formModifCompte();
                break;
            default:
                $content = "Pas de contenu disponible";
        }
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
				<h1><a href =".$this->container->router->pathFor("accueil").">Site de fou furieux</a></h1>
                <div class=\"content\">
					$content
				</div>
			</body>
		<html>";
        return $html;
    }

    /**
     * @return string La chaine html correspondant à un formulaire d'inscription
     */
    private function render_formulaireInscription(){
        return "<h2>Inscription</h2>
            <form action=\"".$this->container->router->pathFor('inscription')."\" method=\"POST\" name=\"formInscr\" id=\"formInscr\">
				<p><label>Pseudo : </label><input type=\"text\" name=\"username\" size=40 required=\"true\"></p>
				<p><label>Adresse email : </label><input type=\"text\" name=\"email\" size=40 required=\"true\"></p>
				<p><label>Password : </label><input type=\"password\" name=\"password\" size=60 required=\"true\"></p>
				<input type=\"submit\" value=\"S'inscrire\">
			</form>";
    }

    /**
     * @return string La chaine html correspondant à un formulaire de connexion
     */
    private function render_formulaireConnexion(){
        return "<h2>Connexion</h2>
            <form action=\"".$this->container->router->pathFor('connexion')."\" method=\"POST\" name=\"formConnex\" id=\"formConnex\">
				<p><label>Pseudo : </label><input type=\"text\" name=\"username\" size=40 required=\"true\"></p>
				<p><label>Password : </label><input type=\"password\" name=\"password\" size=60 required=\"true\"></p>
				<input type=\"submit\" value=\"Connexion\">
			</form>";
    }

    private function render_connexion(){
        return "<a href =\"..\">Accueil</a> <script>window.alert(\"Vous êtes connecté\")</script>";
    }

    private function render_deconnexion(){
        return "<a href =\"..\">Accueil</a> <script>window.alert(\"Vous êtes déconnecté\")</script>";
    }

    private function render_profile(){
        $html = "<h2>Mon compte</h2>
        <form action='".$this->container->router->pathFor('formModifCompte')."'>
            <input type='submit' name='enter' value='Modifier mon compte'>
        </form>
        <form action='".$this->container->router->pathFor('supprimerCompte')." ' method='post'>
            <input type='submit' name='enter' value='Supprimer mon compte'>
        </form>
        <p><ul>
            <li>Mon nom : ". $this->object->username."</li>    
            <li>Mon email : ".$this->object->email ."</li>
        </ul></p>
        ";
        return $html;
    }

    private function render_accessDenied(){
        return "Vous n'avez pas accès à cette page";
    }

    private function render_formModifCompte(){
        $html = "<h2>Modifier mon compte</h2>
        <form action='".$this->container->router->pathFor('modifCompte')."' method='POST'>
        <ul>
            <li><input type='text' name='email' placeholder='email'></li>
            <li><input type='password' name='password' placeholder='password'></li>
            <li> <input type='submit' name='enter' value='Modifier mon compte'></li>
        </ul>    
        </form>";
        return $html;
    }

    private function render_modifCompte(){}
}