<?php

namespace App\Http\Repositories;

use App\Appointment;

class AppointmentRepository
{
    private $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function index()
    {
        return $this->appointment->get();
    }

    public function store(array $data)
    {
        return $this->appointment->fill($data)->save();
    }

    public function update(array $data)
    {
        return $this->appointment->where('id', $data['id'])->update($data);
    }

    public function destroy($id)
    {
        return $this->appointment->find($id)->delete();
    }

    public function sort($fromDate, $toDate)
    {
        return $this->appointment->whereBetween('start_date', [$fromDate, $toDate])->get();
    }

    public function first($params)
    {
        return $this->appointment->where($params)->first();
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
