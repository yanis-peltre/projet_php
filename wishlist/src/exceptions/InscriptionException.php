<?php

namespace mywishlist\exceptions;


use Exception;
use JetBrains\PhpStorm\Pure;

class InscriptionException extends Exception
{

    /**
     * @param string $string
     */
    #[Pure] public function __construct(string $string)
    {
        parent::__construct($string);
    }
}