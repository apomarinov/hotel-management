<?php

namespace App\Http\Controllers;

use App\Client;

class ClientsController extends Controller
{
    /**
     * Clients index view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('clients.index');
    }

    /**
     * Create a new client
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store() {
        $this->validate(request(), [
            'name' => 'required',
            "phone" => 'required'
        ]);

        try {
            $client = Client::create(request(['name', 'phone', 'email']));
        }catch (\Exception $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return response()->json(['errors' => ['duplicate' => ['Phone or email exist.']]], 400);
            }
        }

        return $client;
    }

    /**
     * Deletes a client
     *
     * @param Client $client
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Client $client)
    {
        $result = $client->delete();
        return response('', $result ? 200 : 404);
    }
}
