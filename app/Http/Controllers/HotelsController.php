<?php

namespace App\Http\Controllers;

use App\Hotel;

class HotelsController extends Controller
{
    /**
     * Hotels index action
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        if (request()->wantsJson()) {
            $hotels = Hotel::all();
            return response($hotels);
        }

        return view('hotels.index');
    }
}
