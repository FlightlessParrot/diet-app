<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Specialist;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CourseController extends Controller
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
        $courses = Auth::user()->specialist->courses()->orderByDesc('start_date')->get();
        return Inertia::render('Specialist/ManageCourses',['courses'=>$courses, 'documents'=>Auth::user()->specialist->documents()->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Specialist $specialist, CourseRequest $request)
    {
        $user = $request->user();

        if($user->can('update', $specialist) && $user->can('create', Course::class))
        {
            $start_date = new DateTime($request->selectedDate['start']);
            $end_date = new DateTime($request->selectedDate['end']);
            $course = new Course();
            $course->start_date=$start_date->format('Y-m-d H:i:s');
            $course->end_date=$end_date->format('Y-m-d H:i:s');
            $course->name=$request->name;
            $user->specialist->courses()->save($course);
            return redirect()->back()->with('message', ['text' => 'Dodano szkolenie.', 'status' => 'success']);
        } else {
            return redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {
        $user = Auth::user();
        if($user->can('update', $course))
        {
            $start_date = new DateTime($request->selectedDate['start']);
            $end_date = new DateTime($request->selectedDate['end']);
            $course->start_date=$start_date->format('Y-m-d H:i:s');
            $course->end_date=$end_date->format('Y-m-d H:i:s');
            $course->name=$request->name;
            $course->save();
            return redirect()->back()->with('message', ['text' => 'Zaktualizowano szkolenie.', 'status' => 'success']);
        } else {
            return redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $user = Auth::user();
        if($user->can('delete', $course))
        {
            $course->delete();
            return redirect()->back()->with('message', ['text' => 'Usunięto szkolenie.', 'status' => 'success']);
        } else {
            return redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }
}
