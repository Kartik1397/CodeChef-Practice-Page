<?php

namespace App\Domain\User\Repository;

use PDO;

class HasEmailRepository {
  private $connection;

  public function __construct(PDO $connection) {
    $this->connection = $connection;
  }

  public function hasEmail(string $email): bool {
    $row = [
      'email' => $email,
    ];

    $sql = "SELECT * FROM users WHERE email=:email";
    
    $stmt = $this->connection->prepare($sql);
    $stmt->execute($row);
    if ($stmt->fetch()) {
      return true;
    }
    return false;
  }
}
