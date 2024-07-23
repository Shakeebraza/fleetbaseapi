<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FleetbaseFleetService;

class FleetController extends Controller
{
    protected $fleetbaseService;

    public function __construct(FleetbaseFleetService $fleetbaseService)
    {
        $this->fleetbaseService = $fleetbaseService;
    }
    public function listFleets()
    {
        $data = $this->fleetbaseService->listFleets();

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to fetch fleets',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($data);
    }
    public function getFleet($id)
    {
        $data = $this->fleetbaseService->getFleet($id);

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to fetch fleet',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($data);
    }
    public function createFleet()
    {
        $fleetData = [
            'name' => 'shakeeb',
            'task' => 'fcl hauling'
        ];

        $data = $this->fleetbaseService->createFleet($fleetData);

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to create fleet',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json([
            'success' => 'Fleet successfully created',
            'data' => $data
        ]);
    }

    public function updateFleet( $id)
    {
        $data = [
            'name' => 'shakeeb', 
            'task'=>NULL
            ];

        $response = $this->fleetbaseService->updateFleet($id, $data);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to update fleet',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($response);
    }
    public function deleteFleet($id)
    {
        $response = $this->fleetbaseService->deleteFleet($id);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to delete fleet',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['message' => 'Fleet deleted successfully']);
    }
}
