<?php

namespace APP\Domain\User\Service;

use App\Domain\User\Repository\UserVerifyRepository;

final class UserVerify {
  private $repository;

  public function __construct(UserVerifyRepository $repository) {
    $this->repository = $repository;
  }

  public function verifyUser(string $token): bool {
    $result = $this->repository->verifyUser($token);
    return $result;
  }
}