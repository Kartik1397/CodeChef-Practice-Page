<?php

namespace App\Domain\Tag\Repository;

use PDO;

class TagFindRepository {
  private $connection;

  public function __construct(PDO $connection) {
    $this->connection = $connection;
  }

  public function findTag(array $data, $uid) {
    $sql = "SELECT * FROM tags WHERE type='author' OR type='actual_tag'";
    if (isset($uid)) {
      $sql .= " OR uid=:uid";
    }
    $sql .= ";";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute(array('uid' => $uid));
    $result = $stmt->fetchAll();
    return $result;
  }
}
