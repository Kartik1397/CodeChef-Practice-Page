<?php

namespace App\Domain\Tag\Repository;

use PDO;

class MapTagProblemRepository {
  private $connection;

  public function __construct(PDO $connection) {
    $this->connection = $connection;
  }

  public function mapTagProblem(array $map, int $uid) {
    $row = [
      'uid' => $uid,
      'tid' => $map['tid'],
      'pid' => $map['pid']
    ];

    $sql = "INSERT INTO uid_tid_pid SET
            uid=:uid,
            tid=:tid,
            pid=:pid;";
    $result = $this->connection->prepare($sql)->execute($row);
    $sql = "UPDATE tags SET count=count+1 WHERE id=:id;";
    $result = $this->connection->prepare($sql)->execute(array('id'=>$map['tid']));
    return $result;
  }
}
