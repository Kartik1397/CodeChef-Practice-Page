<?php

namespace App\Domain\User\Repository;

use PDO;
use App\Domain\User\Repository\UserUpdateRepository;

class UserVerifyRepository {
  private $connection;
  private $repository;

  public function __construct(PDO $connection, UserUpdateRepository $repository) {
    $this->connection = $connection;
    $this->repository = $repository;
  }

  public function verifyUser(string $token): bool {
    $sql = "SELECT * FROM users WHERE token=:token AND active=:active";

    $stmt = $this->connection->prepare($sql);
    $stmt->execute(array('token' => $token, 'active' => 0));
    $result = $stmt->fetch();

    if ($result) {
      $data = array("active" => 1);
      $this->repository->updateUser($data, $result['id']);
      return true;
    }
    return false;
  }
}