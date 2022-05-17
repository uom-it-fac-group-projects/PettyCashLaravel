<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imprest;


class ImprestController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        Imprest::create($input);

        return redirect('/')->with('status', 'Imprest amount added successfully');
    }
}
