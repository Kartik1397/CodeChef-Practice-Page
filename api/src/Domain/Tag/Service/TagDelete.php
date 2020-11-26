<?php

namespace App\Domain\Tag\Service;

use App\Domain\Tag\Repository\TagDeleteRepository;

final class TagDelete
{
    private $repository;

    public function __construct(TagDeleteRepository $repository) {
        $this->repository = $repository;
    }

    public function deleteTag(array $data, int $uid): array {
        $this->repository->deleteTag($data, $uid);
        return array(
            'success' => true,
        );
    }

    private function validate(array $data, int $uid): bool {
      
    }
}