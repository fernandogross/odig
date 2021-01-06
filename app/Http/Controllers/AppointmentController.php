<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\AppointmentService;

class AppointmentController extends Controller
{
    private $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function index()
    {
        return response()->json($this->appointmentService->index());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $result = $this->appointmentService->store($data);
        return response()->json($result, $result['status']);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        return $this->appointmentService->update($data);
    }

    public function destroy($id)
    {
        $result = $this->appointmentService->destroy($id);
        return response()->json($result, $result['status']);
    }

    public function sort(Request $request)
    {
        $result = $this->appointmentService->sort($request->fromDate, $request->toDate);
        return response()->json($result, $result['status']);
    }
}
