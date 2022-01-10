<?php

namespace mywishlist\models;


use Slim\Container;

class UserController
{

    private $container;

    public function __construct(Container $c){
        $this->container = $c;
    }

    public function listerUsers($rq, $rs, $args ){
        $users = User::all();
        foreach ($users as $user){
            $rs->getBody()->write($user . $user->role);
        }
        return $rs;
    }

    public function listerRoles($rq, $rs, $args ){
        $roles = Role::all();
        foreach ($roles as $role){
            $rs->getBody()->write($role);
            $users = $role->users;
            foreach ($users as $user){
                $rs->getBody()->write($user);
            }
        }
        return $rs;
    }

    public function formulaireInscription($rq, $rs, $args ){
        $rs->write("<form action=\"inscription/"."\" method=\"POST\" name=\"formInscr\" id=\"formInscr\">
				<p><label>Pseudo : </label><input type=\"text\" name=\"username\" size=40 required=\"true\"></p>
				<p><label>Password : </label><input type=\"text\" name=\"password\" size=60 required=\"true\"></p>
				<input type=\"submit\" value=\"S'inscrire\">
			</form>");
        return $rs;
    }

    public function inscription($rq, $rs, $args ){
        $user = new User();
        $user->inscription($rq->getParsedBody()['username'],$rq->getParsedBody()['password']);

    }

}