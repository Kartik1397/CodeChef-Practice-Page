<?php

namespace App\Domain\Problem\Service;

use App\Domain\Problem\Repository\ProblemFindRepository;

final class ProblemFind
{
    private $repository;

    public function __construct(ProblemFindRepository $repository) {
        $this->repository = $repository;
    }

    public function findProblem(array $data, $uid): array {
        $data['tags'] = explode(",",$data['tags']);
        if (isset($data['custom_tags'])) {
            $data['custom_tags'] = explode(",",$data['custom_tags']);
        }
        
        $errors = $this->validate($data, $uid);
        if (count($errors)) {
            return array(
                'success' => false,
                'errors' => $errors
            );
        }
        $result = $this->repository->findProblem($data, $uid);
        foreach($result as &$problem) {
            $problem['tags'] = explode(",",$problem['tags']);
            unset($problem['tags'][count($problem['tags'])-1]);
        }
        if ($result) {
            return array(
                'success' => true,
                'problems' => $result
            );
        }
        return array(
            'success' => true,
            'problems' => []
        );
    }

    private function validate(array $data, $uid): array {
        $errors = [];
        if (!empty($data['difficulty'])) {
            if (!in_array($data['difficulty'], ['school', 'easy', 'medium', 'hard', 'challange'])) {
                $errors['difficulty'] = 'Invalid difficulty value';
            }
        }

        if (!empty($data['custom_tags'])) {
            if (!isset($uid)) {
                $errors['custom_tags'] = 'Authorization required for custom_tags';
            }
        }

        return $errors;
    }
}