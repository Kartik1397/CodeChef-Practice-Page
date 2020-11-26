<?php

namespace App\Action\User;

use App\Domain\User\Service\UserUpdate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use PsrJwt\Helper\Request;

final class UserUpdateAction {
  private $userUpdate;

  public function __construct(UserUpdate $userUpdate) {
    $this->userUpdate = $userUpdate;
  }

  public function __invoke(
    ServerRequestInterface $request,
    ResponseInterface $response
  ): ResponseInterface {
    $data = (array)$request->getParsedBody();
    $helper = new Request();
    $payload = $helper->getTokenPayload($request, $_ENV['CCPP_JWT_TOKEN']);
    $uid = $payload['uid'];
    $success = $this->userUpdate->updateUser($data, $uid);

    // Transform the result into the JSON representation
    $result = [
        'success' => $success,
    ];

    // Build the HTTP response
    $response->getBody()->write((string)json_encode($result));

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(201); 
  }
}