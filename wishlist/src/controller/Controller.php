<?php

namespace mywishlist\controller;
require_once __DIR__ . '/../vue/VueParticipant.php';

use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vue\VueParticipant;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

class abstract Controller{
	
	private $container;

    public function __construct(Container $c)
    {
        $this->container = $c;
    }
}












