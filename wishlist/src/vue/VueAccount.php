<?php

namespace mywishlist\vue;

class VueAccount
{
    protected $object;

    public function __construct($ob=null){
        $this->object=$ob;
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
				<h1>Site de fou furieux</h1>
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
        return "<form action=\"inscription/"."\" method=\"POST\" name=\"formInscr\" id=\"formInscr\">
				<p><label>Pseudo : </label><input type=\"text\" name=\"username\" size=40 required=\"true\"></p>
				<p><label>Password : </label><input type=\"text\" name=\"password\" size=60 required=\"true\"></p>
				<input type=\"submit\" value=\"S'inscrire\">
			</form>";
    }

    /**
     * @return string La chaine html correspondant à un formulaire de connexion
     */
    private function render_formulaireConnexion(){
        return "<form action=\"connexion/"."\" method=\"POST\" name=\"formConnex\" id=\"formConnex\">
				<p><label>Pseudo : </label><input type=\"text\" name=\"username\" size=40 required=\"true\"></p>
				<p><label>Password : </label><input type=\"text\" name=\"password\" size=60 required=\"true\"></p>
				<input type=\"submit\" value=\"Connexion\">
			</form>";
    }

    private function render_connexion(){
        return "<a href =\"..\">Accueil</a> <script>window.alert(\"Vous êtes connecté\")</script>";
    }

    private function render_deconnexion(){
        return "<a href =\"..\">Accueil</a> <script>window.alert(\"Vous êtes déconnecté\")</script>";
    }
}