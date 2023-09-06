<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Notifications\UserBookingStatusChangeNotification;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::orderBy("id","asc")
        ->with("business")
        ->whereHas("business", function ($query) {
            $query->where("user_id",user()->id);
        })
        ->get();
        return view('Backend.User.Booking.list', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function status_change(Request $request)
    {
        Booking::where("id",$request->id)->update(["status"=>$request->status]);

        $booking = Booking::with('business')->find($request->id);

        if($request->status == 1){

            $content=[
                'greeting'      => 'Hi '.$request->name,
                'content'       =>'Thank you for reaching out to us to book an appointment. We are confirming your booking request for '.date("d-m-Y",strtotime($booking->date)).'. Should you need to cancel or change the appointment, please give us 24 hours’ notice via email or phone.<br/><br/>Thank you!<br/>'.$booking->business->name ,
                'subject'       => $booking->business->name.' | Confirmation for Booking an appointment',
            ];

            Notification::route("mail",$booking->email)->notify(new UserBookingStatusChangeNotification($content));

        }elseif($request->status == 2){

            $content=[
                'greeting'      => 'Hi '.$request->name,
                'content'       =>'Thank you for reaching out to us to book an appointment. We are confirming your booking request for '.date("d-m-Y",strtotime($booking->date)).'. Should you need to cancel or change the appointment, please give us 24 hours’ notice via email or phone.<br/><br/>Thank you!<br/>'.$booking->business->name ,
                'subject'       => $booking->business->name.' | Appointment cancellation',
            ];

            Notification::route("mail",$booking->email)->notify(new UserBookingStatusChangeNotification($content));

        }
        return redirect(route('user.booking.index'))->with('success', 'Booking status updated successfully!');
    }
}
