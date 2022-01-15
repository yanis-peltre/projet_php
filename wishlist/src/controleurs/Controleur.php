<?php

namespace mywishlist\controleurs;
require_once __DIR__ . '/../vue/VueParticipant.php';

use Slim\Container;

abstract class Controleur{
	
	private $container;

    public function __construct(Container $c)
    {
        $this->container = $c;
    }
}












