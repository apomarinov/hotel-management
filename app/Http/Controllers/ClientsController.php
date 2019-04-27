<?php

namespace App\Http\Controllers;

use App\Client;

class ClientsController extends Controller
{
    /**
     * Clients index view
     * includes relationships
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $resultsPerPage = 10;

        if (request()->wantsJson()) {
            $clients = Client::with(['reservations'])->withCount('reservations')->orderBy('reservations_count', 'desc')->paginate($resultsPerPage);

            $data = $clients->makeHidden([
                'created_at',
                'updated_at'
            ]);
            $clients->data = $data;

            return response($clients);
        }

        return view('clients.index');
    }

    /**
     * Clients create view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('clients.form', ['client' => '[]']);
    }

    /**
     * Client show action
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Client $client)
    {
        $client = Client::with('reservations.hotel')->where('id', $client->id)->get()->first();

        if (request()->wantsJson()) {
            return response($client);
        }

        return view('clients.form', compact('client'));
    }

    /**
     * Create a client
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function store()
    {
        return $this->save();
    }

    /**
     * Update a client
     *
     * @param Client $client
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Client $client)
    {
        return $this->save($client);
    }

    /**
     * Save a client
     *
     * @param Client $client
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Client $client = null) {
        $data = $this->validate(request(), [
            'name' => 'required',
            "phone" => 'required'
        ]);

        try {
            if($client) {
                $client->update($data);
            } else {
                $client = Client::create(request(['name', 'phone', 'email']));
            }
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
