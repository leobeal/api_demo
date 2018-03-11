<?php
declare(strict_types=1);

namespace App\Exceptions;

class UserNotLoggedInException extends \Exception
{
    public function __construct(string $message = 'You need to be logged in at this point, please provide a X-AUTH-TOKEN header')
    {
        parent::__construct($message, 400);
    }
}
