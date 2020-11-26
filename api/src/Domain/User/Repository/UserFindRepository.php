<?php

namespace App\Domain\User\Repository;

use PDO;

class UserFindRepository {
  private $connection;

  public function __construct(PDO $connection) {
    $this->connection = $connection;
  }

  public function findUser(array $user) {
    $pass = md5($user['password']);
    $row = [
      'username' => $user['username'],
      'password' => $pass
    ];

    $sql = "SELECT * FROM users WHERE
            username=:username AND password=:password;";
    
    $stmt = $this->connection->prepare($sql);
    $stmt->execute($row);
    $result = $stmt->fetch();

    return $result;
  }
}
