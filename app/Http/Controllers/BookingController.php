<?php

namespace App\Http\Controllers;

use App\Enums\DaysOfWeek;
use App\Events\BookingConfirmed;
use App\Events\BookingSet;
use App\Http\Requests\PatchBookingStatus;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Anonym;
use App\Models\Booking;
use App\Models\Phone;
use App\Models\Province;
use App\Models\Specialist;
use App\Supports\FindBookings\FindBookings;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use App\Supports\DayClerk\DayClerk;

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
        $specialist=Auth::user()->specialist;
        $bookings=$specialist->bookings()->with(['user','anonym'])->get();
        // foreach($bookings as $booking)
        //     {
        //         $booking->user;
        //     }
        return Inertia::render('Specialist/SetMeetings/SetMeetings',['bookings'=>$bookings,'provinces'=>Province::all(),'addresses'=>$specialist->addresses()->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request, Specialist $specialist) : RedirectResponse
    {
        $user = $request->user();

        $address=null;
        if(isset($request->address))
        {
            $address = $specialist->addresses()->findOrFail($request->address);
        }
        if ($user->can('update', $specialist)) {
            
            $dateClerk = null;
            // Check if there is at least one Booking model can be created. If not send error message.
            try{
                $findBooking = new FindBookings($specialist);
                $dateClerk = new DayClerk($request->selectedDate['start'],$request->selectedDate['end'],$findBooking);
            }catch(Exception $e)
            {
                return redirect()->back()->with(
                    'message',
                    [
                        'text' => 'Pomiędzy początkową, a końcową godziną musi być przynajmniej 30 minut.',
                        'status' => 'error'
                    ]
                );
              
            }
            $dates = new Collection();
            if(isset($request->day))
            {
                $day=DaysOfWeek::from($request->day);
                $dates=$dateClerk->getByDayOfWeek($day);
            }else{
               $dates=$dateClerk->getAllDates(); 
            }
            
            foreach($dates as [$startDate, $endDate])
            {
                $booking = new Booking();
                $booking->start_date = $startDate;
                $booking->end_date = $endDate;
                $booking->address()->associate($address);
                $specialist->bookings()->save($booking);
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

    public function showSpecialistReservationPageForAnonym(Specialist $specialist) : Response
    {
        $today=new DateTime();
        $formattedToday=$today->format('Y-m-d H:i:s');
        return Inertia::render('Guest/ReserveMeeting',['specialist'=>$specialist,'bookings'=>$specialist->bookings()->where('status','created')
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

    public function reserveBookingForAnonym(Request $request, Booking $booking) : RedirectResponse
    {
        
        if($booking->status === 'created')
        {
            $phone = new Phone();
            $phone->number=$request->number;
            
            $anonym = Anonym::create(['full_name'=>$request->full_name,'email'=>$request->email,'booking_id'=>$booking->id]);
            $anonym->phone()->save($phone);
            $booking->status = 'pending';
            $booking->save();
            
            BookingSet::dispatch($booking);

            return  redirect()->back()->with('message', ['text' => 'Zarezerwowano spotkanie.', 'status' => 'success','anonym'=>$anonym]);

        }else{
            return  redirect()->back()->with('message', ['text' => 'Coś poszło nie tak.', 'status' => 'error']);
        }
    }
}
