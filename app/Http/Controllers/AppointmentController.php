<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AppointmentRepository;

class AppointmentController extends Controller
{
    private $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function index(Request $request)
    {
        $params = [
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate
        ];
        return response()->json($this->appointmentRepository->index($params));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $result = $this->appointmentRepository->store($data);
        return response()->json($result, $result['status']);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $result = $this->appointmentRepository->update($data);
        return response()->json($result, $result['status']);
    }

    public function destroy($id)
    {
        $result = $this->appointmentRepository->destroy($id);
        return response()->json($result, $result['status']);
    }
}
