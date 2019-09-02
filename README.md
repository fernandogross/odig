# ODIG Backend Test: API Rest
API Rest built to CRUD Appointments as a test to backend development for ODIG.

## Requirements
```
PHP >= 7.1.3
Laravel 5.8
Composer
```

## Dependencies
```
phpunit/phpunit ^7
mockery/mockery ^1.2
```

## Installing
Clone this repository and run the following steps/commands:
```
1) Run: composer install
2) Rename the file .env.example to .env
3) Run: php artisan key:generate
4) Run: php artisan migrate
5) Run: php artisan db:seed
```

## Deployment
```
php artisan serve
```

## API Endpoints

| Request | Endpoint | URL | Parameters |
|---|---|---|---|
| GET | List All |http://localhost:8000/api/appointments | *No parameters required* |
| POST | Sort | http://localhost:8000/api/appointments/sort | fromDate; toDate |
| POST | New | http://localhost:8000/api/appointments | start_date; deadline; title; description; user |
| PUT | Update | http://localhost:8000/api/appointments/appointment | id; concluded_date; status |
| DELETE | Delete | http://localhost:8000/api/appointments | id |

## API Request Example
An example on how to sort appointments with starting date between two dates using [Postman](https://www.getpostman.com):
```
1) Select 'POST' request
2) Enter the URL: http://localhost:8000/api/appointments/sort
3) Click on 'Params' and add two dates:
	3.1) Key: 'fromDate'; Value: '2019-09-01'
	3.2) Key: 'toDate'; Value: '2019-09-07'
4) Click the 'Send' button
6) You should receive something like:
	{
	    "success": true,
	    "message": "1 appointment(s) found.",
	    "status": 200,
	    "result": [
	        {
	            "id": 1,
	            "start_date": "2019-09-02",
	            "concluded_date": null,
	            "deadline": "2019-09-06",
	            "status": 0,
	            "title": "Study about Laravel",
	            "description": "Cover basic CRUD and Auth.",
	            "user": "Fernando",
	            "created_at": null,
	            "updated_at": null,
	            "deleted_at": null
	        }
	    ]
	}
```

## Tests
The tests for this project were built with Mockery.

## Running Tests
From root run the following command:
```
./vendor/bin/phpunit ./tests/Unit
```

## Test Coverage
To check test coverage on this project you need [Xdebug](https://xdebug.org/download.php) ([documentation available here](https://xdebug.org/docs)).

From root run the following command:
```
./vendor/bin/phpunit ./tests/Unit/ --coverage-html coverage
```

Check the coverage file:
```
./coverage/index.html
```

## Build with
[Laravel 5.8](https://www.laravel.com/docs/5.8)