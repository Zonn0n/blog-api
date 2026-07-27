<?php

namespace App\Exceptions;

use Exception;

final class InvalidCredentialsException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid credentials', 401);
    }

    public function render() 
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
