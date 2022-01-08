<?php

namespace mywishlist\controller;
require_once __DIR__ . '/../vue/VueParticipant.php';

use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vue\VueParticipant;
use Slim\Container;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

abstract class Controller{
	
	private $container;

    public function __construct(Container $c)
    {
        $this->container = $c;
    }
}












