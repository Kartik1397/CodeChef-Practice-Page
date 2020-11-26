<?php

namespace App\Action\Tag;

use App\Domain\Tag\Service\TagCreate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use PsrJwt\Helper\Request;

final class TagCreateAction
{
    private $tagCreate;
    public function __construct(TagCreate $tagCreate)
    {
        $this->tagCreate = $tagCreate;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        $data = (array)$request->getParsedBody();
        $helper = new Request();
        $payload = $helper->getTokenPayload($request, $_ENV['CCPP_JWT_TOKEN']);
        $uid = $payload['uid'];

        $result = [
            'success' => false
        ];

        if ($uid !== null) {
            $success = $this->tagCreate->createTag($data, $uid);
            if ($success) {
                $result['success'] = true;
            }
        }
    
        $response->getBody()->write((string)json_encode($result));
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}