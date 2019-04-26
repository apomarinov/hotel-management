<?php

namespace App\Http\Controllers;

use App\Reservation;

class ReservationsController extends Controller
{
    public function index()
    {
        $resultsPerPage = 4;

        if (request()->wantsJson()) {
            $reservations = Reservation::with(['status', 'hotel'])
                                        ->withCount(['clients', 'rooms'])
                                        ->paginate($resultsPerPage);
            return response($reservations, 201);
        }

        return view('reservations.index', compact('notesLimit', 'datesFormat'));
    }
}
