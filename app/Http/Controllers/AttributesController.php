<?php

namespace App\Http\Controllers;

use App\Attribute;

class AttributesController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            $hotels = Attribute::all();
            return response($hotels, 201);
        }

        return view('attributes.index');
    }
}
