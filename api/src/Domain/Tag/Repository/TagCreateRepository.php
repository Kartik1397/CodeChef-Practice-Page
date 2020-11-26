<?php

namespace App\Domain\Tag\Repository;

use PDO;

class TagCreateRepository {
  private $connection;

  public function __construct(PDO $connection) {
    $this->connection = $connection;
  }

  public function createTag(array $tag, int $uid) {
    $row = [
      'name' => $tag['name'],
      'count' => 0,
      'type' => 'custom_tag',
      'uid' => $uid
    ];

    $sql = "INSERT INTO tags SET
            name=:name,
            count=:count,
            type=:type,
            uid=:uid;";
    
    $result = $this->connection->prepare($sql)->execute($row);
    $tid = $this->connection->lastInsertId();

    $row = [
      'uid' => $uid,
      'tid' => $tid,
      'pid' => null
    ];

    $sql = "INSERT INTO uid_tid_pid SET
            uid=:uid,
            tid=:tid,
            pid=:pid;";
    $result = $this->connection->prepare($sql)->execute($row);
    return $result;
  }
}
