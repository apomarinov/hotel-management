<?php

namespace App\Http\Controllers;

use App\AmenityPackage;
use Illuminate\Http\Request;

class AmenityPackagesController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            $hotels = AmenityPackage::all();
            return response($hotels, 201);
        }

        return view('attributes.index');
    }
}
