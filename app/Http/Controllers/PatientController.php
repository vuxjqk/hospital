<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
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
        })->paginate(10);
        return view('medical_records.index', compact('patients', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'national_id' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other',
            'address' => 'nullable|string|max:255',
            'insurance_number' => 'nullable|string|max:20',
            'insurance_expiry_date' => 'nullable|date',
        ]);

        Patient::create($request->all());
        return redirect()->route('medical_records.index')->with('success', 'Bệnh nhân đã được thêm.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'national_id' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other',
            'address' => 'nullable|string|max:255',
            'insurance_number' => 'nullable|string|max:20',
            'insurance_expiry_date' => 'nullable|date',
        ]);

        $patient->update($request->all());
        return redirect()->route('patients.index')->with('success', 'Bệnh nhân đã được cập nhật.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Bệnh nhân đã được xóa.');
    }
}
