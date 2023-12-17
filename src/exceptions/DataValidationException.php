<?php

namespace App\exceptions;

use Exception;

/**
 * Class DataValidationException
 *
 * An exception that is thrown when there are validation errors in data.
 */
class DataValidationException extends Exception
{
    private array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
        $message = json_encode($errors);
        $code = 400;
        $previous = null;
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
