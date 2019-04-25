<?php

namespace App\Http\Controllers;

class ReservationsController extends Controller
{
    public function index() {
        return view('reservations.index');
    }
}
