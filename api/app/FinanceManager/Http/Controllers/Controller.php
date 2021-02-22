<?php declare(strict_types=1);

namespace App\FinanceManager\Http\Controllers;

use App\FinanceManager\CQRS\Resolver;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index(Request $request, Resolver $resolver) {
        $dispatchable = $request->get('content');
        $unserializedEntity = unserialize($dispatchable);
        $handler = $resolver->resolve($unserializedEntity);
        $result = $handler->handle($unserializedEntity);
        return new Response($result->getData());
    }

//    public function ping()
//    {
//        $client = new Client();
//        //dd(env('USERS_URL'));
//        $response = $client->get(env('USERS_URL') . '/pong');
//
//        return $response->getBody();
//
//        //dd($response);
//    }

//    public function pong(Request $request)
//    {
//        return 2;
//    }
}
