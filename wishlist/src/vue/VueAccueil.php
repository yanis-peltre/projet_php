<?php

namespace mywishlist\vue;
use Slim\Container;

class VueAccueil
{
	protected $objet;
    protected $container;

	public function __construct(Container $c, $ob=null){
        $this->container = $c;
		$this->objet=$ob;
	}
	
	private function render_displayAccueil() {
		$html = "<h2>Que voulez-vous faire ?</h2>
			<form action='".$this->container->router->pathFor('listesPubliques')."' method='GET'>
				<input type='submit' value='Consulter les listes publiques'>
			</form>

			<form action='".$this->container->router->pathFor('formCheckList'). "' method ='GET'>
			    <input type='submit' value='Voir une liste partagée'>

			</form>";
        // Si l'utilisateur n'est pas connecté :
        if(!isset($_SESSION['profile'])) {
            $html .= "<form action = \"".$this->container->router->pathFor('formInscription')."\" method='GET'>
			    <input type='submit' value=\"S'inscrire\">
            </form>
            <form action=\"".$this->container->router->pathFor('formConnexion')."\" method='GET'>
			    <input type='submit' value=\"Se connecter\">
            </form>
		";
        }
        // Si il est connecté
        else{
            $html .= "
                <form action =". $this->container->router->pathFor('listesPersos')." method='GET'>
                    <input type='submit' value='Voir mes listes'>
                </form>
                <form action = '".$this->container->router->pathFor('voirProfil')."' method='GET'>
			        <input type='submit' value='Voir mon profil'>
                </form>
                <form action = '".$this->container->router->pathFor('deconnexion')."' method='GET'>
			        <input type='submit' value='Se déconnecter'>
                </form>";

        }
        return $html;
	}
	
	public function render($selecteur) {
		switch ($selecteur) {
			case 1 : {
				$content = $this->render_displayAccueil();
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

		return 
		"<!DOCTYPE html>

		<html lang='fr'>
			<head>
				<meta charset=\"utf-8\"/>
				<link rel=\"stylesheet\" media=\"screen\" type=\"text/css\" href=\"./../../web/css/style.css\"/>
				<script type=\"text/javascript\" src=\"./../../web/css/script.js\"></script>
				<title>sometext</title>
			</head>
			<body>
				<header>
					<nav>
						<h1><a href =".$this->container->router->pathFor("accueil").">Site de fou furieux</a></h1>
					</nav>
				</header>
				
                <div class=\"content\">
					$content
				</div>
				<footer>
					<ul>
						<li><a href=\"#\">Retourner en haut</a></li>
					</ul>
				</footer>
			</body>
		<html>";
	}
}