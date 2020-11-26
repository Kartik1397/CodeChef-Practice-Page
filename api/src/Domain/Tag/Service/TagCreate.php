<?php

namespace App\Domain\Tag\Service;

use App\Domain\Tag\Repository\TagCreateRepository;

final class TagCreate
{
    private $repository;

    public function __construct(TagCreateRepository $repository) {
        $this->repository = $repository;
    }

    public function createTag(array $data, int $uid): array {
        $this->repository->createTag($data, $uid);
        return array(
            'success' => true,
        );
    }

}