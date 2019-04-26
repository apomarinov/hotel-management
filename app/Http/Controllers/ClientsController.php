<?php

namespace App\Http\Controllers;

use App\Client;

class ClientsController extends Controller
{
    public function index() {
        return view('clients.index');
    }

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

    public function destroy(Client $client)
    {
        $result = $client->delete();
        return response('', $result ? 200 : 404);
    }
}
