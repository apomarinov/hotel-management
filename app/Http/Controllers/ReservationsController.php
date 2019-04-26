<?php

namespace App\Http\Controllers;

use App\Reservation;

class ReservationsController extends Controller
{
    public function index()
    {
        $resultsPerPage = 4;
        $notesLimit = 190;
        $datesFormat = 'd.m.Y';

        $reservations = Reservation::with(['status', 'hotel'])
                                    ->withCount(['clients', 'rooms'])
                                    ->paginate($resultsPerPage);
        return view('reservations.index', compact('reservations', 'notesLimit', 'datesFormat'));
    }
}
