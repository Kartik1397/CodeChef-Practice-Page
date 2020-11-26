<?php

namespace APP\Domain\User\Service;

use App\Domain\User\Repository\UserUpdateRepository;
use App\Exception\ValidationException;

final class UserUpdate {
  private $repository;

  public function __construct(UserUpdateRepository $repository) {
    $this->repository = $repository;
  }

  public function updateUser(array $data, int $uid): bool {
    $this->validatePatch($data);
    $result = $this->repository->updateUser($data, $uid);
    return $result;
  }

  private function validatePatch(array $data): void {
    if (!empty($data['email'])) {
      if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Invalid email address';
      }
    }

    if ($errors) {
      throw new ValidationException('Please check your input', $errors);
    }
  }
}