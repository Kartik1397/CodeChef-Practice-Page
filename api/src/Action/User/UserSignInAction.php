<?php

namespace App\Action\User;

use App\Domain\User\Service\UserFind;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserSignInAction
{
    private $userFind;

    public function __construct(UserFind $userFind)
    {
        $this->userFind = $userFind;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $result = $this->userFind->findUser($data);

        if ($result['success']) {
            $factory = new \PsrJwt\Factory\Jwt();
            $builder = $factory->builder();
            $token = $builder->setSecret($_ENV['CCPP_JWT_TOKEN'])
              ->setPayloadClaim('uid', $result['user']['id'])
              ->setPayloadClaim('user', $result['user'])
              ->build();
            // Transform the result into the JSON representation
            $result['token'] = $token->getToken();
        }

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}