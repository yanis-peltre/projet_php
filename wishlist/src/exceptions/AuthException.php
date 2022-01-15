<?php

namespace mywishlist\exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class AuthException extends Exception
{

    /**
     * @param string $string
     */
    #[Pure] public function __construct(string $string)
    {
        parent::__construct($string);
    }

}