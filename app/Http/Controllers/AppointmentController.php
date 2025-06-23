<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $services = Service::all();

        $search = $request->input('search');
        $appointments = Appointment::when($search, function ($query, $search) {
            return $query->where('patient_id', 'like', "%{$search}%");
        })->paginate(10);
        return view('appointments.index', compact('appointments', 'search', 'services'));
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
    public function store(Request $request)
    {
        $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'patient_id' => 'required|exists:patients,id',
            'specialty_id' => 'required|exists:specialties,id',
        ]);

        $today = Carbon::today();

        $queueNumber = Appointment::where('specialty_id', $request->specialty_id)
            ->whereDate('created_at', $today)
            ->count() + 1;

        Appointment::create([
            'medical_record_id' => $request->medical_record_id,
            'patient_id' => $request->patient_id,
            'specialty_id' => $request->specialty_id,
            'queue_number' => $queueNumber,
        ]);

        return redirect()->route('patients.index')->with('success', 'Lịch khám đã được thêm.');
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
    public function update(Request $request, string $appointment_id)
    {
        $request->validate([
            'symptoms' => 'required|string|max:255',
            'diagnosis' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',
        ]);

        $appointment = Appointment::findOrFail($appointment_id);

        $appointment->update([
            'symptoms' => $request->symptoms,
            'diagnosis' => $request->diagnosis,
            'note' => $request->note,
            'appointment_date' => now(),
            'status' => 'completed',
        ]);

        return redirect()->route('appointments.index')->with('success', 'Lịch khám đã được cập nhật.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
