<?php

namespace App\Http\Controllers;

use App\Events\BookingConfirmed;
use App\Events\BookingSet;
use App\Http\Requests\PatchBookingStatus;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Specialist;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {
        $bookings = Auth::user()->bookings()->orderBy('start_date','desc')->paginate(40);
            foreach($bookings as $booking)
            {
                $booking->specialist;
            }
        
       return Inertia::render('User/YourBookings',['bookings'=>$bookings]);
    }

    /**users
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        $bookings=Auth::user()->specialist->bookings()->get();
        foreach($bookings as $booking)
            {
                $booking->user;
            }
        return Inertia::render('Specialist/SetMeetings',['bookings'=>$bookings]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request, Specialist $specialist) : RedirectResponse
    {
        $user = $request->user();
        if ($user->can('update', $specialist)) {
            $start = strtotime($request->selectedDate['start']);
            $end = strtotime($request->selectedDate['end']);
            $diff = $end - $start;
            $diffInDays = abs(floor($diff / 86400));

            $endTime = $end % 86400;
            $startTime = $start % 86400;

            $startDay = floor($start / 86400) * 86400;
            $endDay= floor($end / 86400) * 86400;
            $diffStartEndTime = $endTime - $startTime;

            $duration = (30 * 60);
            // Check if there is at least one Booking model can be created. If not send error message.
            if ($diffStartEndTime < (30 * 60)) {
                return redirect()->back()->with(
                    'message',
                    [
                        'text' => 'Pomięczy początkową, a końcową godziną musi być przynajmniej 30 minut.',
                        'status' => 'error'
                    ]
                );
            }

            //For every 30 minutes create model.
            for ($i = 0; $i <= $diffInDays; $i++) {
                // For every day create time var which is set every 30 min since start time
                $controlTime = $startTime;
                while($controlTime+$duration <= $endTime) {
                    // How long is the meeting duration?
                    

                    //Var for model creation.
                    $startDateTimestamp = $startDay + (86400 * $i) + $controlTime;
                    $startDate = date('Y-m-d H:i:s', $startDateTimestamp);
                    $endDateTimestamp = $startDateTimestamp + $duration;
                    $endDate = date('Y-m-d H:i:s', $endDateTimestamp);
                    //Find booking in conflict with creating model.
                    $conflicts = $specialist->bookings()->where(function (Builder $query)  use ($startDate, $endDate) {
                        $query->where('start_date', '>=', $startDate)->where('start_date', '<', $endDate);
                    })
                        ->orWhere(function (Builder $query) use ($startDate, $endDate) {
                            $query->where('end_date', '>', $startDate)->where('end_date', '<=', $endDate);
                        })->orWhere(function (Builder $query) use ($startDate, $endDate) {
                            $query->where('start_date', '<=', $startDate)->where('end_date', '>=', $endDate);
                        })->get();


                    // If there are no conflicts, create booking model
                    if (count($conflicts)===0) {
                        $booking = new Booking();
                        $booking->start_date = $startDate;
                        $booking->end_date = $endDate;
                        $specialist->bookings()->save($booking);
                    }


                    $controlTime = $controlTime + $duration;
                } 
            }
            return redirect()->back()->with('message', ['text' => 'Udało się', 'status' => 'success']);
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
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    public function showSpecialistReservationPage(Specialist $specialist) : Response
    {
        $today=new DateTime();
        $formattedToday=$today->format('Y-m-d H:i:s');
        return Inertia::render('User/ReserveMeeting',['specialist'=>$specialist,'bookings'=>$specialist->bookings()->where('status','created')
        ->where('start_date','>',$formattedToday)->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialist $specialist,Booking $booking)
    {
        if(Auth::user()->can('delete',$booking))
        {
            $booking->delete();
            return  redirect()->back()->with('message', ['text' => 'Utworzono opis.', 'status' => 'success']);
            

        }else{
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }

    public function changeStatus(PatchBookingStatus $request, Booking $booking) : RedirectResponse
    {
        $user=Auth::user();
        if($user->can('update',$booking) && $booking->status === 'pending')
        {
            $booking->status = $request->status;
            $booking->save();

            if($booking->status==='confirmed')
            {
                BookingConfirmed::dispatch($booking);
            }

            return  redirect()->back()->with('message', ['text' => 'Zmieniono status spotkania.', 'status' => 'success','r'=>$booking->status]);

        }else{
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }

    public function reserveBooking(Request $request, Booking $booking) : RedirectResponse
    {
        $user=Auth::user();
        if($booking->status === 'created')
        {
            $booking->status = 'pending';
            $booking->user_id=$user->id;
            $booking->save();
            
            BookingSet::dispatch($booking);

            return  redirect()->back()->with('message', ['text' => 'Zarezerwowano spotkanie.', 'status' => 'success']);

        }else{
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }
}
