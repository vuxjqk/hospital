<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDetail;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
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
    public function create(int $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        $services = Service::all();
        return view('service_requests.create', compact('appointment_id', 'appointment', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'description' => 'nullable|string|max:255',
            'service_id' => 'required|array',
            'service_id.*' => 'exists:services,id',
            'note' => 'nullable|array',
            'note.*' => 'nullable|string|max:255',
        ]);

        $record = ServiceRequest::create([
            'appointment_id' => $request->appointment_id,
            'description' => $request->description,
            'request_date' => now(),
        ]);

        foreach ($request->service_id as $index => $serviceId) {
            ServiceRequestDetail::create([
                'service_request_id' => $record->id,
                'service_id' => $serviceId,
                'note' => $request->note[$index] ?? null,
            ]);
        }

        return redirect()->route('appointments.index')->with('success', 'Yêu cầu dịch vụ đã được thêm.');
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
