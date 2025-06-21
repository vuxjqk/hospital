<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Specialty;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $specialties = Specialty::all();

        $search = $request->input('search');
        $medical_records = MedicalRecord::when($search, function ($query, $search) {
            return $query->where('patient_id', 'like', "%{$search}%");
        })->paginate(10);
        return view('medical_records.index', compact('medical_records', 'search', 'specialties'));
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
            'type' => 'nullable|string|max:255',
        ]);

        MedicalRecord::create([
            'patient_id' => $request->patient_id,
            'type' => $request->type,
            'record_date' => now(),
            'has_insurance' => $request->has('has_insurance'),
        ]);

        return redirect()->route('patients.index')->with('success', 'Hồ sơ bệnh án đã được thêm.');
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
