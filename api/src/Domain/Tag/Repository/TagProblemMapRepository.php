<?php

namespace App\Domain\Tag\Repository;

use PDO;

class TagProblemMapRepository {
  private $connection;

  public function __construct(PDO $connection) {
    $this->connection = $connection;
  }

  public function getTagProblemMap($uid) {
    $sql = "SELECT * FROM uid_tid_pid WHERE uid=:uid";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute(array('uid' => $uid));
    $result = $stmt->fetchAll();
    return $result;
  }
}
