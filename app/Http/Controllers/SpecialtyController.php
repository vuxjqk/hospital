<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $specialties = Specialty::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->paginate(10);
        return view('specialties.index', compact('specialties', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('specialties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|decimal:0,2',
        ]);

        Specialty::create($request->all());
        return redirect()->route('specialties.index')->with('success', 'Chuyên khoa đã được thêm.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialty $specialty)
    {
        return view('specialties.show', compact('specialty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialty $specialty)
    {
        return view('specialties.edit', compact('specialty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialty $specialty)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fee' => 'required|decimal:0,2',
        ]);

        $specialty->update($request->all());
        return redirect()->route('specialties.index')->with('success', 'Chuyên khoa đã được cập nhật.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty)
    {
        $specialty->delete();
        return redirect()->route('specialties.index')->with('success', 'Chuyên khoa đã được xóa.');
    }
}
