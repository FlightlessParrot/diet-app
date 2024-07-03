<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Specialist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRequest $request, Specialist $specialist) : RedirectResponse
    {
        $user = Auth::user();
        if($user->cant('update',$specialist) && Review::where('specialist_id',$specialist->id)->where('user_id',$user->id)->first()===null)
        {
            $review=new Review();
            $review->user_id=$user->id;
            $review->text=$request->text;
            $review->grade = $request->grade;
            $specialist->reviews()->save($review);
            return redirect()->back()->with('message', ['text' => 'Udało się dodać komentarz.', 'status' => 'success']);
        } else {
            return redirect()->back()->with(
                'message',
                [
                    'text' => 'Coś poszło nie tak',
                    'status' => 'error'
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewRequest $request, Review $review) : RedirectResponse
    {
        $user = Auth::user();
        if($user->can('update',$review))
        {
            $review->text=$request->text;
            $review->grade = $request->grade;
            $review->save();
            return redirect()->back()->with('message', ['text' => 'Udało się.', 'status' => 'success']);
        } else {
            return redirect()->back()->with(
                'message',
                [
                    'text' => 'Coś poszło nie tak.',
                    'status' => 'error'
                ]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review) : RedirectResponse
    {
        $user = Auth::user();
        if($user->can('delete',$review))
        {
            $review->delete();
            return redirect()->back()->with('message', ['text' => 'Udało się usunąć opinię.', 'status' => 'success']);
        } else {
            return redirect()->back()->with(
                'message',
                [
                    'text' => 'Coś poszło nie tak.',
                    'status' => 'error'
                ]
            );
        }
    }
}
