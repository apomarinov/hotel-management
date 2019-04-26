<?php

namespace App\Http\Controllers;

use App\Client;
use App\Reservation;

class ReservationsController extends Controller
{
    public function index()
    {
        $resultsPerPage = 4;

        if (request()->wantsJson()) {
            // move to model
            $reservations = Reservation::with(['status', 'hotel'])
                                        ->withCount(['clients', 'rooms'])
                                        ->paginate($resultsPerPage);

            $data = $reservations->makeHidden([
                'reservation_status_id',
                'created_at',
                'updated_at',
                'hotel_id'
            ]);
            $reservations->data = $data;

            return response($reservations, 201);
        }

        return view('reservations.index');
    }

    public function create()
    {
        return view('reservations.create');
    }

    public function deleteClient(Reservation $reservation, Client $client)
    {
        $result = $reservation->clients()->detach($client->id);

        return response('', $result ? 200 : 404);
    }
}
