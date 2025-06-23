<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequestDetail;
use App\Models\ServiceResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceRequestDetails = ServiceRequestDetail::with(['service', 'service_request', 'service_result'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('service_request_details.index', compact('serviceRequestDetails'));
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
            'service_request_details_id' => 'required|exists:service_request_details,id',
            'result' => 'nullable|string',
            'result_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'result_date' => 'required|date',
        ]);

        $serviceResult = new ServiceResult();
        $serviceResult->service_request_details_id = $request->service_request_details_id;
        $serviceResult->created_by = Auth::id();
        $serviceResult->result = $request->result;
        $serviceResult->result_date = $request->result_date;

        // Xử lý upload file nếu có
        if ($request->hasFile('result_file')) {
            $file = $request->file('result_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('service_results', $fileName, 'public');
            $serviceResult->result_file = $filePath;
        }

        $serviceResult->save();

        return response()->json([
            'success' => true,
            'message' => 'Kết quả dịch vụ đã được lưu thành công!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $serviceRequestDetail = ServiceRequestDetail::with(['service', 'serviceRequest', 'serviceResults.createdBy'])
            ->findOrFail($id);

        return view('service_request_details.show', compact('serviceRequestDetail'));
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
