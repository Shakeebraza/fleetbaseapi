<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FleetbaseDriverService;

class DriverController extends Controller
{
    protected $driverService;

    public function __construct(FleetbaseDriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);

        $data = $this->driverService->listDrivers($limit);

        return response()->json($data);
    }

    public function show($id)
    {
        $data = $this->driverService->getDriver($id);

        return response()->json($data);
    }
    public function createDriver()
    {
        $driverData = [
            'name' => 'fission fox',
            'email' => 'test10@gmail.com',
            'password' => '123456789',
            'phone' => '+15404694338',
            'phone_country_code' => 10,
            'country' => 'us',
            'city' => 'Charlotte',
        ];

       

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to create driver',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($data, 201);
    }
    public function updateDriver($id)
    {
        $data = [
            'name' => 'Aliz',
            'city' => 'Pakistan',
        ];

        $response = $this->driverService->updateDriver($id, $data);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to update driver',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($response, 200);
    }
    public function deleteDriver($id)
    {
        $data = $this->driverService->deleteDriver($id);

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to delete driver',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($data, 200);
    }
}
