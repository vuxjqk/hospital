<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Specialty;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $patients = Patient::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('national_id', 'like', "%{$search}%")
                ->orWhere('insurance_number', 'like', "%{$search}%");
        })->paginate(5);

        $specialties = Specialty::all();
        $medical_records = MedicalRecord::all();

        return view('medical_records.index', compact('medical_records', 'search', 'specialties', 'patients'));
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
            'patient_id' => 'required|exists:patients,id',
            'specialty_id' => 'nullable|exists:specialties,id',
        ]);

        $data = [
            'patient_id' => $request->patient_id,
            'record_date' => now(),
            'has_insurance' => $request->has('has_insurance'),
        ];

        if ($request->filled('type')) {
            $data['type'] = $request->input('type');
        }

        $record = MedicalRecord::create($data);

        if ($request->input('type') != "inpatient") {
            $today = today();

            $queueNumber = Appointment::where('specialty_id', $request->specialty_id)
                ->whereDate('created_at', $today)
                ->count() + 1;

            Appointment::create([
                'medical_record_id' => $record->id,
                'patient_id' => $request->patient_id,
                'specialty_id' => $request->specialty_id,
                'queue_number' => $queueNumber,
            ]);
        }

        return redirect()->route('medical_records.index')->with('success', 'Hồ sơ bệnh án đã được thêm.');
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
