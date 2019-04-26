<?php

namespace App\Http\Controllers;

use App\Hotel;
use Illuminate\Http\Request;

class HotelsController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            $hotels = Hotel::all();
            return response($hotels, 201);
        }

        return view('hotels.index');
    }
}
