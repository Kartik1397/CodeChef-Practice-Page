<?php

namespace App\Domain\Tag\Repository;

use PDO;

class TagFindCustomTagRepository {
  private $connection;

  public function __construct(PDO $connection) {
    $this->connection = $connection;
  }

  public function findCustomTag(int $uid, int $pid) {
    $sql = "SELECT tags.name FROM uid_tid_pid INNER JOIN tags ON uid_tid_pid.tid=tags.id WHERE uid_tid_pid.uid=:uid AND uid_tid_pid.pid=:pid";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute(array('uid' => $uid, 'pid' => $pid));
    $result = $stmt->fetchAll();
    return $result;
  }
}
