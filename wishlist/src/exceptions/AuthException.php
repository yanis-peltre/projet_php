<?php

namespace mywishlist\exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class AuthException extends Exception
{

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
        parent::__construct($string);
    }

}