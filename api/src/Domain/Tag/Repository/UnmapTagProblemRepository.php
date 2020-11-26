<?php

namespace App\Domain\Tag\Repository;

use PDO;

class UnmapTagProblemRepository {
  private $connection;

  public function __construct(PDO $connection) {
    $this->connection = $connection;
  }

  public function unmapTagProblem(array $map, int $uid) {
    $row = [
      'uid' => $uid,
      'tid' => $map['tid'],
      'pid' => $map['pid']
    ];

    $sql = "DELETE FROM uid_tid_pid WHERE
            uid=:uid AND
            tid=:tid AND
            pid=:pid;";
    $result = $this->connection->prepare($sql)->execute($row);
    $sql = "UPDATE tags SET count=count-1 WHERE id=:id;";
    $result = $this->connection->prepare($sql)->execute(array('id'=>$map['tid']));
    return $result;
  }
}
