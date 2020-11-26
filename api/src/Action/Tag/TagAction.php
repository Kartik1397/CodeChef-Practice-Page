<?php

namespace App\Action\Tag;

use App\Domain\Tag\Service\TagFind;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use PsrJwt\Helper\Request;

final class TagAction
{
    private $tagFind;
    public function __construct(TagFind $tagFind)
    {
      $this->tagFind = $tagFind;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        $data = $request->getQueryParams();
    
        $uid = null;
        if ($request->hasHeader('Authorization')) {
            $helper = new Request();
            $payload = $helper->getTokenPayload($request, $_ENV['CCPP_JWT_TOKEN']);
            $uid = $payload['uid'];   
        }
        
        $result = $this->tagFind->findTag($data, $uid);
    
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}