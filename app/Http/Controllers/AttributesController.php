<?php

namespace App\Http\Controllers;

use App\Attribute;

class AttributesController extends Controller
{
    /**
     * Attributes index action
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        if (request()->wantsJson()) {
            $hotels = Attribute::all();
            return response($hotels);
        }

        return view('attributes.index');
    }
}
