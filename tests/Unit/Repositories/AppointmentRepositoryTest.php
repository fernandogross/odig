<?php

namespace Test\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use App\Http\Repositories\AppointmentRepository;
use App\Appointment;

class AppointmentRepositoryTest extends TestCase
{
	public function testConstruct()
	{
		$appointmentSpy = Mockery::Spy(Appointment::class);

		$appointmentRepository = new AppointmentRepository($appointmentSpy);

		$this->assertInstanceOf(AppointmentRepository::class, $appointmentRepository);
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

		$appointmentMock = Mockery::Mock(Appointment::class);
		$appointmentMock->shouldReceive('get')
			->andReturn($appointment);

		$appointmentRepository = new AppointmentRepository($appointmentMock);
		$return = $appointmentRepository->index();

		$this->assertEquals($appointment, $return);
	}
	public function testStore()
	{
		$data = [
			'id' => 1,
			'concluded_date' => '2019-08-29',
			'status' => 1
		];
		$appointmentMock = Mockery::Mock(Appointment::class);
		$appointmentMock->shouldReceive('fill')
			->andReturnSelf()
			->shouldReceive('save')
			->andReturn(true);

		$appointmentRepository = new AppointmentRepository($appointmentMock);
		$return = $appointmentRepository->store($data);

		$this->assertEquals(true, $return);
	}

	public function testUpdate()
	{
		$data = [
			'id' => 1,
			'concluded_date' => '2019-08-30',
			'status' => 1
		];
		$appointmentMock = Mockery::Mock(Appointment::class);
		$appointmentMock->shouldReceive('where')
			->andReturnSelf()
			->shouldReceive('update')
			->andReturn(1);

		$appointmentRepository = new AppointmentRepository($appointmentMock);
		$return = $appointmentRepository->update($data);

		$this->assertEquals(1, $return);
	}

	public function testDestroy()
	{
		$appointmentMock = Mockery::Mock(Appointment::class);
		$appointmentMock->shouldReceive('find')
			->andReturnSelf()
			->shouldReceive('delete')
			->andReturn(true);

		$appointmentRepository = new AppointmentRepository($appointmentMock);
		$return = $appointmentRepository->destroy(1);

		$this->assertEquals(true, $return);
	}

	public function testSort()
	{
		$fromDate = '2019-08-29';
		$toDate = '2019-08-30';

		$appointment = new Appointment;
		$appointment->id = 1;
		$appointment->start_date = '2019-08-29';
		$appointment->concluded_date = null;
		$appointment->deadline = '2019-08-30';
		$appointment->status = 0;
		$appointment->title = 'Testing for Odig';
		$appointment->description = 'Create tests using Mockery.';
		$appointment->user = 'Fernando';

		$appointmentMock = Mockery::Mock(Appointment::class);
		$appointmentMock->shouldReceive('whereBetween')
			->andReturnSelf()
			->shouldReceive('get')
			->andReturn($appointment);

		$appointmentRepository = new AppointmentRepository($appointmentMock);
		$return = $appointmentRepository->sort($fromDate, $toDate);

		$this->assertEquals($appointment, $return);
	}

	public function testFirst()
	{
		$params = [
			'id' => 1
		];

		$appointment = new Appointment;
		$appointment->id = 1;
		$appointment->start_date = '2019-08-29';
		$appointment->concluded_date = null;
		$appointment->deadline = '2019-08-30';
		$appointment->status = 0;
		$appointment->title = 'Testing for Odig';
		$appointment->description = 'Create tests using Mockery.';
		$appointment->user = 'Fernando';

		$appointmentMock = Mockery::Mock(Appointment::class);
		$appointmentMock->shouldReceive('where')
			->andReturnSelf()
			->shouldReceive('first')
			->andReturn($appointment);

		$appointmentRepository = new AppointmentRepository($appointmentMock);
		$return = $appointmentRepository->first($params);

		$this->assertEquals($appointment, $return);
	}

	public function testValidateStore()
	{
		$params = [
			'start_date' => '2019-01-02',
			'deadline' => '2019-01-06',
			'user' => 'Fernando'
		];

		$appointment = new Appointment;
		$appointment->id = 1;
		$appointment->start_date = '2019-01-02';
		$appointment->concluded_date = null;
		$appointment->deadline = '2019-01-06';
		$appointment->status = 0;
		$appointment->title = 'Testing for Odig';
		$appointment->description = 'Create tests using Mockery.';
		$appointment->user = 'Fernando';

		$appointmentMock = Mockery::Mock(Appointment::class);
		$appointmentMock->shouldReceive('where')
			->andReturnSelf()
			->shouldReceive('whereBetween')
			->andReturnSelf()
			->shouldReceive('whereBetween')
			->andReturnSelf()
			->shouldReceive('first')
			->andReturn($appointment);

		$appointmentRepository = new AppointmentRepository($appointmentMock);
		$return = $appointmentRepository->validateStore($params);

		$this->assertEquals($appointment, $return);
	}
}