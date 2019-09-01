<?php

namespace Test\Unit\Service;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use App\Http\Services\AppointmentService;
use App\Http\Repositories\AppointmentRepository;
use App\Appointment;

class AppointmentServiceTest extends TestCase
{
	public function testConstruct()
	{
		$AppointmentRepositorySpy = Mockery::Spy(AppointmentRepository::class);

		$appointmentService = new AppointmentService($AppointmentRepositorySpy);

		$this->assertInstanceOf(AppointmentRepository::class, $AppointmentRepositorySpy);
	}

	public function testIndex()
	{
		$appointment = new Appointment;
		$appointment->id = 1;
		$appointment->start_date = '2019-08-29';
		$appointment->concluded_date = null;
		$appointment->deadline = '2019-08-30';
		$appointment->status = 0;
		$appointment->title = 'Testing for Odig';
		$appointment->description = 'Create tests using Mockery.';
		$appointment->user = 'Fernando';

		$appointmentRepositoryMock = Mockery::Mock(AppointmentRepository::class);
		$appointmentRepositoryMock->shouldReceive('index')
			->andReturn($appointment);

		$appointmentService = new AppointmentService($appointmentRepositoryMock);
		$return = $appointmentService->index();

		$this->assertEquals($appointment, $return);
	}

	public function testStore()
	{
		$params = [
			'start_date' => '2019-01-02',
			'deadline' => '2019-01-03',
			'user' => 'Fernando'
		];
		$data = [
			'id' => 1,
			'start_date' => '2019-01-02',
			'concluded_date' => null,
			'deadline' => '2019-01-03',
			'status' => 0,
			'title' => 'Testing for Odig',
			'description' => 'Create tests using Mockery.',
			'user' => 'Fernando'
		];

		$appointmentRepositoryMock = Mockery::Mock(AppointmentRepository::class);
		$appointmentRepositoryMock->shouldReceive('validateStore')
			->with($params)
			->andReturnNull()
			->shouldReceive('store')
			->andReturn(true);

		$saved = [
			'success' => true,
			'message' => 'New appointment successfully created.',
			'status' => 201
		];
		$appointmentService = new AppointmentService($appointmentRepositoryMock);
		$return = $appointmentService->store($data);

		$this->assertEquals($saved, $return);
	}

	public function testStoreDateNotAvailable()
	{
		$params = [
			'start_date' => '2019-09-17',
			'deadline' => '2019-09-18',
			'user' => 'Fernando'
		];
		$data = [
			'id' => 1,
			'start_date' => '2019-09-17',
			'concluded_date' => null,
			'deadline' => '2019-09-18',
			'status' => 0,
			'title' => 'Testing for Odig',
			'description' => 'Create tests using Mockery.',
			'user' => 'Fernando'
		];

		$appointment = new Appointment;

		$appointmentRepositoryMock = Mockery::Mock(AppointmentRepository::class);
		$appointmentRepositoryMock->shouldReceive('validateStore')
			->with($params)
			->andReturn($appointment);

		$checkedDate = [
			'success' => false,
			'message' => 'The selected period already has an appointment for this user.',
			'status' => 200
		];
		$appointmentService = new AppointmentService($appointmentRepositoryMock);
		$return = $appointmentService->store($data);

		$this->assertEquals($checkedDate, $return);
	}

	public function testStoreDateIsWeekend()
	{
		$params = [
			'start_date' => '2019-09-07',
			'deadline' => '2019-09-18',
			'user' => 'Fernando'
		];
		$data = [
			'id' => 1,
			'start_date' => '2019-09-07',
			'concluded_date' => null,
			'deadline' => '2019-09-18',
			'status' => 0,
			'title' => 'Testing for Odig',
			'description' => 'Create tests using Mockery.',
			'user' => 'Fernando'
		];

		$appointmentRepositoryMock = Mockery::Mock(AppointmentRepository::class);
		$appointmentRepositoryMock->shouldReceive('validateStore')
			->with($params)
			->andReturnNull();

		$checkedDate = [
			'success' => false,
			'message' => 'The selected date is on a weekend.',
			'status' => 200
		];
		$appointmentService = new AppointmentService($appointmentRepositoryMock);
		$return = $appointmentService->store($data);

		$this->assertEquals($checkedDate, $return);
	}

	public function testUpdate()
	{
		$data = [
			'id' => 1,
			'concluded_date' => '2019-08-29',
			'status' => 1
		];

		$appointmentRepositoryMock = Mockery::Mock(AppointmentRepository::class);
		$appointmentRepositoryMock->shouldReceive('update')
			->andReturn(1);

		$updated = [
			'success' => true,
			'message' => 'Appointment successfully updated.'
		];

		$appointmentService = new AppointmentService($appointmentRepositoryMock);
		$return = $appointmentService->update($data);

		$this->assertEquals($updated, $return);
	}

	public function testDestroy()
	{
		$id = [
			'id' => 1
		];
		$appointment = new Appointment;

		$appointmentRepositoryMock = Mockery::Mock(AppointmentRepository::class);
		$appointmentRepositoryMock->shouldReceive('first')
			->with($id)
			->andReturn($appointment)
			->shouldReceive('destroy')
			->andReturn(true);

		$deleted = [
			'success' => true,
			'message' => 'Appoinment deleted successfully.',
			'status' => 201
		];

		$appointmentService = new AppointmentService($appointmentRepositoryMock);
		$return = $appointmentService->destroy(1);

		$this->assertEquals($deleted, $return);
	}

	public function testDestroyIdNotFound()
	{
		$id = [
			'id' => 99
		];

		$appointmentRepositoryMock = Mockery::Mock(AppointmentRepository::class);
		$appointmentRepositoryMock->shouldReceive('first')
			->with($id)
			->andReturnNull();

		$result = [
			'success' => false,
			'message' => 'Appointment not found.',
			'status' => 404
		];

		$appointmentService = new AppointmentService($appointmentRepositoryMock);
		$return = $appointmentService->destroy(99);

		$this->assertEquals($result, $return);
	}

	public function testSort()
	{
		$fromDate = '2019-01-01';
		$toDate = '2019-01-31';
		$appointment = [
			'0' => [
				'id' => 1,
				'start_date' => '2019-01-09',
				'concluded_date' => null,
				'deadline' => '2019-01-10',
				'status' => 0,
				'title' => 'Testing for Odig',
				'description' => 'Create tests using Mockery.',
				'user' => 'Fernando'
			],
		];

		$appointmentRepositoryMock = Mockery::Mock(AppointmentRepository::class);
		$appointmentRepositoryMock->shouldReceive('sort')
			->andReturn($appointment);

		$result = [
			'success' => true,
			'message' => '1 appointment(s) found.',
			'status' => 200,
			'result' => $appointment
		];

		$appointmentService = new AppointmentService($appointmentRepositoryMock);
		$return = $appointmentService->sort($fromDate, $toDate);

		$this->assertEquals($result, $return);
	}

	public function testSortNotFound()
	{
		$fromDate = '2019-01-01';
		$toDate = '2019-01-31';
		$appointment = array();

		$appointmentRepositoryMock = Mockery::Mock(AppointmentRepository::class);
		$appointmentRepositoryMock->shouldReceive('sort')
			->andReturn($appointment);

		$checkedDates = [
			'success' => false,
			'message' => 'No appointments found for the selected period.',
			'status' => 404
		];

		$appointmentService = new AppointmentService($appointmentRepositoryMock);
		$return = $appointmentService->sort($fromDate, $toDate);

		$this->assertEquals($checkedDates, $return);
	}

}