<?php

namespace App\Domain\User\Repository;

use PDO;

class UserUpdateRepository {
  private $connection;

  public function __construct(PDO $connection) {
    $this->connection = $connection;
  }

  public function updateUser(array $userPatch, int $uid): bool {
    $cnt = count($userPatch);
    $keys = [];
    foreach ($userPatch as $attr => $val) {
      array_push($keys, $attr);
    }

    if (array_key_exists("password", $userPatch)) {
      $userPatch['password'] = md5($userPatch['password']);
    }
    
    $sql = "UPDATE users SET ";
    for ($i = 0; $i < $cnt; $i+=1) {
      if ($i != 0) {
        $sql .= ', ';
      }
      $sql .= $keys[$i] . '=:' . $keys[$i];
    }
    $sql .= " WHERE id=:id;";
    
    $result = $this->connection->prepare($sql)
                   ->execute(array_merge($userPatch, array("id" => $uid)));
    
    return $result;
  }
}