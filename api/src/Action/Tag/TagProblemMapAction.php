<?php

namespace App\Action\Tag;

use App\Domain\Tag\Service\TagProblemMap;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use PsrJwt\Helper\Request;

final class TagProblemMapAction
{
    private $tagProblemMap;
    public function __construct(TagProblemMap $tagProblemMap)
    {
      $this->tagProblemMap = $tagProblemMap;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {
        $uid = null;
        if ($request->hasHeader('Authorization')) {
            $helper = new Request();
            $payload = $helper->getTokenPayload($request, $_ENV['CCPP_JWT_TOKEN']);
            $uid = $payload['uid'];
            if ($uid != null) {
                $result = $this->tagProblemMap->getTagProblemMap($uid);
            } else {
                $result = [
                    'success' => false
                ];
            }
        }

        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}