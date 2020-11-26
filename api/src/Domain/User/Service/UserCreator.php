<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\HasUsernameRepository;
use App\Domain\User\Repository\HasEmailRepository;
use App\Domain\User\Repository\UserCreatorRepository;
use App\Exception\ValidationException;

final class UserCreator
{
    private $repository;
    private $hasUsernameRepository;
    private $hasEmailRepository;

    public function __construct(
        UserCreatorRepository $repository,
        HasUsernameRepository $hasUsernameRepository,
        HasEmailRepository $hasEmailRepository) {
        $this->repository = $repository;
        $this->hasUsernameRepository = $hasUsernameRepository;
        $this->hasEmailRepository = $hasEmailRepository;
    }

    public function createUser(array $data): array {
        $errors = $this->validateNewUser($data);

        if (count($errors)) {
            return array('success' => false, 'errors' => $errors);
        }

        $success = $this->repository->insertUser($data);
        if ($success) {
            return array('success' => true);
        }
        return array('success' => false);
    }

    private function validateNewUser(array $data): array {
        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = 'Input required';
        } else if (strlen($data['username']) > 20) {
            $errors['username'] = 'Username should containe 1 to 20 character';
        } elseif ($this->hasUsernameRepository->hasUsername($data['username'])) {
            $errors['username'] = 'Username already exists';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Input required';
        } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'Invalid email address';
        } elseif ($this->hasEmailRepository->hasEmail($data['email'])) {
            $errors['email'] = 'Email already exists';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Password required';
        } else if (strlen($data['password']) < 8) {
            $errors['password'] = 'Password must contain at least 8 character';
        } else if (!preg_match("/\d/", $data['password'])) {
            $errors['password'] = 'Password must contain at least 1 number';
        } else if (!preg_match("/[a-zA-Z]/", $data['password'])) {
            $errors['password'] = 'Password must contain at least 1 alphabet';
        }

        if (empty($data['first_name'])) {
            $errors['first_name'] = 'Firstname required';
        } else if (strlen($data['first_name']) > 50) {
            $errors['first_name'] = 'Firstname should contain 1 to 50 character';
        } else if (preg_match('/[^a-zA-Z]/', $data['first_name'])) {
            $errors['first_name'] = 'Firstname should contain only alphabet';
        }

        if (empty($data['last_name'])) {
            $errors['last_name'] = 'Lastname required';
        } else if (strlen($data['last_name']) > 50) {
            $errors['last_name'] = 'Lastname should containe 1 to 50 character';
        }

        return $errors;
    }
}