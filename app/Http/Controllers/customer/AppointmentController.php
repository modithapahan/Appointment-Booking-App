<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::all();
        return view('admin.appointment_manage', compact('appointments'));
    }

    public function approve(Request $request, $id) {
        $appointment = Appointment::findOrfail($id);
        $appointment->approved = true;
        $appointment->save();

        /* Decline other appointments for the same day*/
        $appointmentDate = Carbon::parse($appointment->date)->format('Y-m-d');
        Appointment::where('date', $appointmentDate)
                   ->where('id', '!=', $appointment->id)
                   ->update(['approved' => false]);

        return redirect()->back();
    }

    public function decline(Request $request, $id) {
        $appointment = Appointment::findOrFail($id);
        $appointment->approved = false;
        $appointment->save();

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user()->id;
        return view('customer.appointment', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
        ]);

        $user = User::findOrFail($request->user_id);
        $appointmentDate = Carbon::parse($request->date)->format('Y-m-d');

        // Check if the customer already has an appointment for the given date
        $existingAppointment = $user->appointments()->whereDate('date', $appointmentDate)->first();

        if ($existingAppointment) { 
            return redirect()->back()->withErrors(['appointment_date' => 'You already have an appointment for this date.']);
        }

        // Check if there's an approved appointment for the same date
        $existingApprovedAppointment = Appointment::where('date', $appointmentDate)->where('approved', true)->first();

        if ($existingApprovedAppointment) {
            return redirect()->back()->withErrors(['date' => 'There is already an approved appointment for this date.']);
        }

        // Create the appointment
        $appointment = new Appointment([
            'date' => $appointmentDate,
            'approved' => false,
        ]);

        $user->appointments()->save($appointment);

        return redirect(route('customer.home'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
