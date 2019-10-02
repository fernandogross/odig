<?php

namespace App\Repositories;

use App\Appointment;
use Carbon\Carbon;

class AppointmentRepository
{
    private $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function index($params = null)
    {
        if ($params) {
            info($params);
            return $this->appointment
                ->whereBetween('start_date', $params)
                ->whereBetween('deadline', $params)
                ->get();
        }

        return $this->appointment->get();
    }

    public function store(array $data)
    {
        $params = [
            'start_date' => $data['start_date'],
            'deadline' => $data['deadline'],
            'user' => $data['user']
        ];
        $checkDate = $this->validateStore($params);
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

        $this->appointment->fill($data)->save();

        return [
            'success' => true,
            'message' => 'New appointment successfully created.',
            'status' => 201
        ];
    }

    public function update(array $data)
    {
        $appointment = $this->appointment->where('id', $data['id'])->update($data);;

        if (!$appointment) {
            return [
                'success' => false,
                'message' => 'Appointment not found.',
                'status' => 404
            ];
        }

        return [
            'success' => true,
            'message' => 'Appointment successfully updated.',
            'status' => 200
        ];
    }

    public function destroy($id)
    {

        $checkAppointment = $this->appointment->find($id);
        if (!$checkAppointment) {
            return [
                'success' => false,
                'message' => 'Appointment not found.',
                'status' => 404
            ];
        }

        $this->appointment->destroy($id);
        return [
            'success' => true,
            'message' => 'Appoinment deleted successfully.',
            'status' => 201
        ];

        return $this->appointment->find($id)->delete();
    }

    public function validateStore($params)
    {
        return $this->appointment
            ->where('user', $params['user'])
            ->whereBetween('start_date', [$params['start_date'], $params['deadline']])
            ->whereBetween('deadline', [$params['start_date'], $params['deadline']])
            ->first();
    }
}
