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

    //public function pong(Request $request)
    //{
    //    //return dd(app('db'));
    //    /** @var DatabaseManager $databaseManager */
    //    $databaseManager = app('db');
    //    $m = app('db')->select("SELECT * FROM users");
    //    return $m;
    //}
}
