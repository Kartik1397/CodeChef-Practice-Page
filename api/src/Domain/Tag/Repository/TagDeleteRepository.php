<?php

namespace App\Domain\Tag\Repository;

use PDO;

class TagDeleteRepository {
  private $connection;

  public function __construct(PDO $connection) {
    $this->connection = $connection;
  }

  public function deleteTag(array $tag, int $uid) {
    $tid = $tag['id'];

    $row = [
      'uid' => $uid,
      'tid' => $tid,
    ];

    $sql = "DELETE FROM uid_tid_pid WHERE
            uid=:uid AND
            tid=:tid";
    
    $result = $this->connection->prepare($sql)->execute($row);

    $sql = "DELETE FROM tags WHERE id=:id;";
    
    $result = $this->connection->prepare($sql)->execute(array('id'=>$tid));

    return $result;
  }
}
