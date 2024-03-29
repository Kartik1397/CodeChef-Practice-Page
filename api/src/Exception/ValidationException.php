<?php

namespace App\Exception;

use RuntimeException;
use Throwable;

final class ValidationException extends RuntimeException {
  private $errors;

  public function __construct(
    string $message,
    array $errors= [],
    int $code = 422,
    Throwable $previous = null
  ) {
    parent::__construct($message, $code, $previous);
    $this->errors = $errors;
  }

  public function getErros(): array {
    return $this->errors;
  }
}