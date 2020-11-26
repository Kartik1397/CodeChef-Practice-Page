<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return function (App $app) {
  $app->get('/', \App\Action\HomeAction::class)->setName('home');
  $app->post('/user/signup', \App\Action\User\UserCreateAction::class);
  $app->post('/user/signin', \App\Action\User\UserSignInAction::class);
  $app->patch('/user/update', \App\Action\User\UserUpdateAction::class);
  $app->get('/user/verify', \App\Action\User\UserVerifyAction::class);
  $app->get('/problems', \App\Action\Problem\ProblemAction::class);
  $app->get('/tags', \App\Action\Tag\TagAction::class);
  $app->post('/tags', \App\Action\Tag\TagCreateAction::class);
  $app->post('/tags/delete', \App\Action\Tag\TagDeleteAction::class);
  $app->get('/tags/map', \App\Action\Tag\TagProblemMapAction::class);
  $app->post('/tags/map', \App\Action\Tag\MapTagProblemAction::class);
  $app->post('/tags/unmap', \App\Action\Tag\UnmapTagProblemAction::class);
  $app->options('/{routes:.+}', function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
    return $response
      ->withHeader('Access-Control-Allow-Origin', '*')
      ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
      ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
  });
};
