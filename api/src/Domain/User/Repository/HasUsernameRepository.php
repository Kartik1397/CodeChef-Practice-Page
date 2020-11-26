<?php

namespace App\Domain\User\Repository;

use PDO;

class HasUsernameRepository {
  private $connection;

  public function __construct(PDO $connection) {
    $this->connection = $connection;
  }

  public function hasUsername(string $username): bool {
    $row = [
      'username' => $username,
    ];

    $sql = "SELECT * FROM users WHERE username=:username";
    
    $stmt = $this->connection->prepare($sql);
    $stmt->execute($row);
    if ($stmt->fetch()) {
      return true;
    }
    return false;
  }
}
