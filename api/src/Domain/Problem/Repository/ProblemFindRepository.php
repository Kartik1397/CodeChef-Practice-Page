<?php

namespace App\Domain\Problem\Repository;

use PDO;
use App\Domain\Tag\Repository\TagFindCustomTagRepository;

class ProblemFindRepository {
  private $connection;
  private $repository;

  public function __construct(PDO $connection, TagFindCustomTagRepository $repository) {
    $this->connection = $connection;
    $this->repository = $repository;
  }

  public function findProblem(array $filter, $uid) {
    if (!isset($uid) || (isset($uid) && $filter['custom_tags'][0] === "")) {
      $sql = "SELECT * FROM problems WHERE true AND ";

      $row = [];
  
      if (isset($filter['difficulty']) && !empty($filter['difficulty'])) {
        $row['difficulty'] = $filter['difficulty'];
        $sql .= "difficulty=:difficulty AND ";
      }

      if (isset($filter['author']) && !empty($filter['author'])) {
        $row['author'] = $filter['author'];
        $sql .= "author=:author AND ";
      }
  
      if (isset($filter['tags']) && $filter['tags'][0] !== "") {
        foreach($filter['tags'] as $tag) {
          $sql .= "tags LIKE '%$tag,%' AND ";
        }
      }

      $sql .= "true;";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute($row);
      $result = $stmt->fetchAll();
  
      return $result;  
    }

    $sql = "SELECT
              uid,
              pid,
              problems.id,
              problems.name,
              problems.tags,
              problems.difficulty,
              problems.submissions,
              problems.accuracy,
              problems.author,
              GROUP_CONCAT(tid SEPARATOR ',') AS custom_tags
            FROM uid_tid_pid
            INNER JOIN problems on uid_tid_pid.pid=problems.id
            WHERE uid=$uid AND ";
            
    $row = [];

    if (isset($filter['difficulty']) && !empty($filter['difficulty'])) {
      $row['difficulty'] = $filter['difficulty'];
      $sql .= "difficulty=:difficulty AND ";
    }

    if (isset($filter['author']) && !empty($filter['author'])) {
      $row['author'] = $filter['author'];
      $sql .= "author=:author AND ";
    }

    if (isset($filter['tags']) && $filter['tags'][0] !== "") {
      foreach($filter['tags'] as $tag) {
        $sql .= "tags LIKE '%$tag,%' AND ";
      }
    }
    $sql .= "true GROUP BY pid HAVING ";

    if (isset($filter['custom_tags']) && $filter['custom_tags'][0] !== "") {
      foreach($filter['custom_tags'] as $custom_tag) {
        $sql .= "custom_tags LIKE '%$custom_tag%' AND ";
      }
    }

    $sql .= 'true;';
    
    $stmt = $this->connection->prepare($sql);
    $stmt->execute($row);
    $result = $stmt->fetchAll();
  
    return $result;
  }
}
