<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FleetbaseVehicleService;

class VehicleController extends Controller
{
    protected $fleetbaseVehicleService;

    public function __construct(FleetbaseVehicleService $fleetbaseVehicleService)
    {
        $this->fleetbaseVehicleService = $fleetbaseVehicleService;
    }
    public function getVehicle($id)
    {
        $response = $this->fleetbaseVehicleService->getVehicle($id);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to fetch vehicle',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['data' => $response]);
    }

    public function listVehicles()
    {
        $response = $this->fleetbaseVehicleService->listVehicles();

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to fetch vehicles',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['data' => $response]);
    }

    public function createVehicle()
    {
        $vehicle = [
            'vin' => 'vin2',
        ];

        $response = $this->fleetbaseVehicleService->createVehicle($vehicle);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to create vehicle',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['message' => 'Vehicle created successfully', 'data' => $response]);
    }
    public function updateVehicle(Request $request, $id)
    {
        $vehicleData = ['plate_number'=>4930];

        $response = $this->fleetbaseVehicleService->updateVehicle($id, $vehicleData);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to update vehicle',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['message' => 'Vehicle updated successfully', 'data' => $response]);
    }
    public function deleteVehicle($id)
    {
        $response = $this->fleetbaseVehicleService->deleteVehicle($id);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to delete vehicle',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($response);
    }
}
