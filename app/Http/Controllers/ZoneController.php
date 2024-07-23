<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FleetbaseZoneService;

class ZoneController extends Controller
{
    protected $zoneService;

    public function __construct(FleetbaseZoneService $zoneService)
    {
        $this->zoneService = $zoneService;
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);

        $data = $this->zoneService->listZones($limit);

        return response()->json($data);
    }

    public function show($id)
    {
        $data = $this->zoneService->getZone($id);

        return response()->json($data);
    }

    public function create()
    {
        $zoneData = [
            'name' => 'shakeeb',
            'service_area' => 'sa_oPPkczJ',
            'border'=>54564
        ];

        $data = $this->zoneService->createZone($zoneData);

        if (isset($data['error'])) {
            return response()->json([
                'message' => 'Failed to create zone',
            ], 200);
        }

        return response()->json($data, 201);
    }
    public function update($id)
    {
        $data = [
            'description' => 'This zone is just a circle in the center of Singapore',
            'color' => '#58eb8c',
            'stroke_color' => '#2fbd61',
            'boundary' => [
                'latitude' => 1.352083,
                'longitude' => 103.819836,
                'radius' => 500
            ]
        ];

        $response = $this->zoneService->updateZone($id, $data);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to update zone',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['message' => 'Zone updated successfully']);
    }
    public function delete($id)
    {
        $response = $this->zoneService->deleteZone($id);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to delete zone',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['message' => 'Zone deleted successfully']);
    }
}
