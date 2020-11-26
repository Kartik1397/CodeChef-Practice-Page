<?php

namespace App\Domain\Tag\Service;

use App\Domain\Tag\Repository\TagFindRepository;

final class TagFind
{
    private $repository;

    public function __construct(TagFindRepository $repository) {
        $this->repository = $repository;
    }

    public function findTag(array $data, $uid): array {
        $result = $this->repository->findTag($data, $uid);
        return array(
            'success' => true,
            'tags' => $result
        );
    }
}