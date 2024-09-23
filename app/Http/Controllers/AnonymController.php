<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnonymRequest;
use App\Models\Anonym;
use Illuminate\Http\Request;

class AnonymController extends Controller
{
    public function store(StoreAnonymRequest $request)
    {
        $anonym = Anonym::create($request->validated()->all());
        return back()->with('message',['text'=>'Udało się','status'=>'success']);
    }
}
