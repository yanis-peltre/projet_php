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

}