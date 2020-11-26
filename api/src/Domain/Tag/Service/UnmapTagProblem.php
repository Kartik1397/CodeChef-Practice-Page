<?php

namespace App\Domain\Tag\Service;

use App\Domain\Tag\Repository\UnmapTagProblemRepository;

final class UnmapTagProblem
{
    private $repository;

    public function __construct(UnmapTagProblemRepository $repository) {
        $this->repository = $repository;
    }

    public function unmapTagProblem(array $data, int $uid): array {
        $this->repository->unmapTagProblem($data, $uid);
        return array(
            'success' => true,
        );
    }
}