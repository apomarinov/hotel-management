<?php

namespace App\Http\Controllers;

use App\AmenityPackage;

class AmenityPackagesController extends Controller
{
    /**
     * AmenityPackage index action
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        if (request()->wantsJson()) {
            $hotels = AmenityPackage::all();
            return response($hotels);
        }

        return view('attributes.index');
    }
}
