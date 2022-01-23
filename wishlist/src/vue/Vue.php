<?php declare(strict_types = 1);

namespace mywishlist\vue;
use Slim\Container;

class Vue
{
	protected $objet;
    protected $container;

	public function __construct(Container $c, $ob=null){
        $this->container = $c;
		$this->objet=$ob;
	}
}