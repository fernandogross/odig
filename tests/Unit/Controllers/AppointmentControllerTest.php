<?php

namespace Test\Unit\Controllers;

use Tests\TestCase;
use App\Appointment;

class AppointmentControllerTest extends TestCase
{
    protected $endpoint = '/api/appointments';

    public function testStore()
    {
        $newAppointment = [
            'start_date' => '2019-11-18',
            'deadline' => '2019-11-22',
            'title' => 'Implement tests using PHP Unit',
            'description' => 'Study about PHP Unit tests implementation on previous Pipe project.',
            'user' => 'Fernando Gross'
        ];

        $response = $this->post($this->endpoint, $newAppointment);
        $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'New appointment successfully created.',
            'status' => 201
        ]);
    }

    public function testUpdate()
    {
        // Can't use Factory because of strict business rules
        //$appointment = factory(Appointment::class)->create();

        $appointment = new Appointment();
        $appointment->id = 10;
        $response = $this->put("{$this->endpoint}/appointment?id={$appointment->id}", [
            'description' => 'Update test'
        ]);
        $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Appointment successfully updated.'
        ]);
    }
}
