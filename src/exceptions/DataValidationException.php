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

    public function __construct(array $errors, $code = 400, Exception $previous = null)
    {
        $this->errors = $errors;
        $this->code = $code;
        parent::__construct(json_encode($errors), $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
