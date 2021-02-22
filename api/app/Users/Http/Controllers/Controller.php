<?php declare(strict_types=1);

namespace App\Users\Http\Controllers;

use App\Users\CQRS\Resolver;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index(Request $request, Resolver $resolver): Response {
        $dispatchable = $request->get('content');
        $unserializedEntity = unserialize($dispatchable);
        $handler = $resolver->resolve($unserializedEntity);
        $result = $handler->handle($unserializedEntity);
        return new Response($result->getData());
    }
}
