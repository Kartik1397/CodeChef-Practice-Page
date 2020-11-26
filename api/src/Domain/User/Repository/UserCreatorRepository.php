<?php

namespace App\Domain\User\Repository;

use PDO;

class UserCreatorRepository {
  private $connection;

  public function __construct(PDO $connection) {
    $this->connection = $connection;
  }

  public function insertUser(array $user): int {
    $pass = md5($user['password']);
    $row = [
      'username' => $user['username'],
      'first_name' => $user['first_name'],
      'last_name' => $user['last_name'],
      'email' => $user['email'],
      'active' => 0,
      'token' => $user['token'],
      'password' => $pass
    ];

    $sql = "INSERT INTO users SET
            username=:username,
            first_name=:first_name,
            last_name=:last_name,
            email=:email,
            active=:active,
            token=:token,
            password=:password;";
    
    $result = $this->connection->prepare($sql)->execute($row);

    return $result;
  }
}
