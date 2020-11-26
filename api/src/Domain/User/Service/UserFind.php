<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserFindRepository;
use App\Exception\ValidationException;

final class UserFind
{
    private $repository;

    public function __construct(UserFindRepository $repository) {
        $this->repository = $repository;
    }

    public function findUser(array $data): array {
        $errors = $this->validateNewUser($data);
        if (count($errors)) {
            return array(
                'success' => false,
                'error' => $errors
            );
        }
        $result = $this->repository->findUser($data);

        if ($result && $result['active']) {
            unset($result['active']);
            unset($result['token']);
            unset($result['password']);
            return array(
                'success' => true,
                'user' => $result
            );
        }
        return array(
            'success' => false,
            'error' => array(
                'signin' => 'Invalid Username or Password'
            )
        );
    }

    private function validateNewUser(array $data): array {
        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = 'Input required';
        }

        return $errors;
    }
}