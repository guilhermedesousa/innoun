<?php

namespace exceptions;
use Exception;

class ValidationException extends Exception {
    private $errors = [];

    public function __construct($errors = [], $message = "Erro em campos do formulário", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function get($att) {
        return $this->errors[$att];
    }
}