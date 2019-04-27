<?php

namespace App\Http\Controllers;

use App\ReservationStatus;

class ReservationStatusController extends Controller
{
    /**
     * ReservationStatuses index view
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        if (request()->wantsJson()) {
            if(request()->has('on_create')) {
                $hotels = ReservationStatus::where('on_create', 1)->orderBy('id')->get();
            } else {
                $hotels = ReservationStatus::orderBy('id')->get();
            }
            return response($hotels, 201);
        }

        return view('reservation-status.index');
    }
}
