<?php

namespace App\Domain\Tag\Service;

use App\Domain\Tag\Repository\MapTagProblemRepository;

final class MapTagProblem
{
    private $repository;

    public function __construct(MapTagProblemRepository $repository) {
        $this->repository = $repository;
    }

    public function mapTagProblem(array $data, int $uid): array {
        $this->repository->mapTagProblem($data, $uid);
        return array(
            'success' => true,
        );
    }

}