<?php

namespace App\Action\User;

use App\Domain\User\Service\UserVerify;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class UserVerifyAction {
  private $userVerify;

  public function __construct(UserVerify $userVerify)
  {
      $this->userVerify = $userVerify;
  }

  public function __invoke(Request $request, Response $response) : Response {
    $data = $request->getQueryParams();
    $result = $this->userVerify->verifyUser($data['token']);

    if ($result === true) {
      $response->getBody()->write("
        <html>
          <head>
            <title>CodeChef Practice</title>
          </head>
          <body>
            <h1><center>Account Verified</center></h1>
            <a href=\"". $_ENV['CCPP_URL'] ."\"><center>Go back and Sign in</center></a>
          </body>
        </html>
      ");

      return $response
      ->withHeader('Access-Control-Allow-Origin', '*')
      ->withStatus(200);
    } else {
      $response->getBody()->write("
        <html>
          <head>
            <title>CodeChef Practice</title>
          </head>
          <body>
            <h1><center>Invalid token or Already activated</center></h1>
          </body>
        </html>
      ");
      return $response
      ->withHeader('Access-Control-Allow-Origin', '*')
      ->withStatus(200);
    }
  }
}
