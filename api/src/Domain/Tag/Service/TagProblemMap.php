<?php

namespace App\Domain\Tag\Service;

use App\Domain\Tag\Repository\TagProblemMapRepository;

final class TagProblemMap
{
    private $repository;

    public function __construct(TagProblemMapRepository $repository) {
        $this->repository = $repository;
    }

    public function getTagProblemMap($uid): array {
        $result = $this->repository->getTagProblemMap($uid);
        return array(
            'success' => true,
            'map' => $result
        );
    }
}