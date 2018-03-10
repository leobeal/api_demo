<?php

declare(strict_types=1);

namespace App\Exceptions;

class InvalidParametersException extends \Exception
{
    public function __construct(string $message = 'Wrong parameters')
    {
        parent::__construct($message, 400);
    }
}
