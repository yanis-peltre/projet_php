<?php

namespace mywishlist\controleurs;
require_once __DIR__ . '/../vue/VueParticipant.php';

use Slim\Container;

abstract class Controleur{
	
	protected $container;

    public function __construct(Container $c)
    {
        $this->container = $c;
    }
}












