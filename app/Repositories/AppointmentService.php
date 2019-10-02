<?php

namespace App\Http\Services;

use App\Http\Repositories\AppointmentRepository;
use App\Appointment;
use Carbon\Carbon;

class AppointmentService
{
    private $appointmentRepository;
    private $appointment;

    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function index()
    {
        return $this->appointmentRepository->index();
    }

    public function store(array $data)
    {
        $params = [
            'start_date' => $data['start_date'],
            'deadline' => $data['deadline'],
            'user' => $data['user']
        ];
        $checkDate = $this->appointmentRepository->validateStore($params);
        if ($checkDate) {
            return [
                'success' => false,
                'message' => 'The selected period already has an appointment for this user.',
                'status' => 200
            ];
        }

        $carbonDate = new Carbon($data['start_date']);
        if ($carbonDate->isWeekend()) {
            return [
                'success' => false,
                'message' => 'The selected date is on a weekend.',
                'status' => 200
            ];
        }
        
        $this->appointmentRepository->store($data);

        return [
            'success' => true,
            'message' => 'New appointment successfully created.',
            'status' => 201
        ];
    }

    public function update(array $data)
    {
        $this->appointmentRepository->update($data);

        return [
            'success' => true,
            'message' => 'Appointment successfully updated.'
        ];
    }

    public function destroy($id)
    {
        $params = [
            'id' => $id,
        ];
        $checkAppointment = $this->appointmentRepository->first($params);
        if (!$checkAppointment) {
            return [
                'success' => false,
                'message' => 'Appointment not found.',
                'status' => 404
            ];
        }

        $this->appointmentRepository->destroy($id);
        return [
            'success' => true,
            'message' => 'Appoinment deleted successfully.',
            'status' => 201
        ];
    }

    public function sort($fromDate, $toDate)
    {
        $sort = $this->appointmentRepository->sort($fromDate, $toDate);
        if (count($sort) == 0) {
            return [
                'success' => false,
                'message' => 'No appointments found for the selected period.',
                'status' => 404
            ];
        }

        return [
            'success' => true,
            'message' => count($sort) . ' appointment(s) found.',
            'status' => 200,
            'result' => $sort
        ];
    }
}
