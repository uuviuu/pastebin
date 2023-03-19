<?php

namespace App\Exceptions;


class UserNotFoundException extends CustomException
{
    protected $messageKey = 'UserNotFoundException';
}