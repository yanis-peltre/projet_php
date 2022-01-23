<?php declare(strict_types = 1);

namespace mywishlist\vue;
use mywishlist\vue\Vue;
use Slim\App;

class VueAccount extends Vue
{
    public function render($selecteur):String{
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

    /**
     * @return string La chaine html correspondant à un formulaire d'inscription
     */
    private function render_formulaireInscription():String{
        return "<section><h2>Inscription</h2>
            <form action=\"".$this->container->router->pathFor('inscription')."\" method=\"POST\" name=\"formInscr\" id=\"formInscr\">
				<p><label>Pseudo : </label><input type=\"text\" name=\"username\" size=40 required=\"true\"></p>
				<p><label>Adresse email : </label><input type=\"text\" name=\"email\" size=40 required=\"true\"></p>
				<p><label>Password : </label><input type=\"password\" name=\"password\" size=60 required=\"true\"></p>
				<input type=\"submit\" value=\"S'inscrire\">
			</form></section>";
    }

    /**
     * @return string La chaine html correspondant à un formulaire de connexion
     */
    private function render_formulaireConnexion():String{
        return "<section><h2>Connexion</h2>
            <form action=\"".$this->container->router->pathFor('connexion')."\" method=\"POST\" name=\"formConnex\" id=\"formConnex\">
				<p><label>Pseudo : </label><input type=\"text\" name=\"username\" size=40 required=\"true\"></p>
				<p><label>Password : </label><input type=\"password\" name=\"password\" size=60 required=\"true\"></p>
				<input type=\"submit\" value=\"Connexion\">
			</form></section>";
    }

    private function render_connexion():String{
        return "<a href =\"..\">Accueil</a> <script>window.alert(\"Vous êtes connecté\")</script>";
    }

    private function render_deconnexion():String{
        return "<a href =\"..\">Accueil</a> <script>window.alert(\"Vous êtes déconnecté\")</script>";
    }

    private function render_profile():String{
        $html = "<section><h2>Mon compte</h2>
        <form action='".$this->container->router->pathFor('formModifCompte')."'>
            <input type='submit' name='enter' value='Modifier mon compte'>
        </form>
        <form action='".$this->container->router->pathFor('supprimerCompte')." ' method='post'>
            <input type='submit' name='enter' value='Supprimer mon compte'>
        </form>
        <p><ul>
            <li>Mon nom : ". $this->objet->username."</li>    
            <li>Mon email : ".$this->objet->email ."</li>
        </ul></p></section>
        ";
        return $html;
    }

    private function render_accessDenied():String{
        return "Vous n'avez pas accès à cette page";
    }

    private function render_formModifCompte():String{
        $html = "<section><h2>Modifier mon compte</h2>
        <form action='".$this->container->router->pathFor('modifCompte')."' method='POST'>
        <ul>
            <li><input type='text' name='email' placeholder='email'></li>
            <li><input type='password' name='password' placeholder='password'></li>
            <li> <input type='submit' name='enter' value='Modifier mon compte'></li>
        </ul>    
        </form></section>";
        return $html;
    }

    private function render_modifCompte(){}
}