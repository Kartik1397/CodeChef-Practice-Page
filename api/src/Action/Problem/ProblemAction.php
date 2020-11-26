<?php

namespace App\Action\Problem;

use App\Domain\Problem\Service\ProblemFind;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use PsrJwt\Helper\Request;

final class ProblemAction
{
    private $problemFind;
    public function __construct(ProblemFind $problemFind)
    {
      $this->problemFind = $problemFind;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        $data = $request->getQueryParams();
        // tag, difficulty, customTag
        $uid = null;
        if (isset($data['custom_tags'])) {
            $helper = new Request();
            $payload = $helper->getTokenPayload($request, $_ENV['CCPP_JWT_TOKEN']);
            $uid = $payload['uid'];   
        }
    
        $result = $this->problemFind->findProblem($data, $uid);
        
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}