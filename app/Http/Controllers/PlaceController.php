<?php

namespace App\Http\Controllers;

use App\Services\FleetbasePlaceService;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    protected $placeService;

    public function __construct(FleetbasePlaceService $placeService)
    {
        $this->placeService = $placeService;
    }

    public function index(Request $request)
    {
        $query = $request->input('query');
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $orderBy = $request->input('order_by');
        $within = [
            'latitude' => $request->input('within.latitude'),
            'longitude' => $request->input('within.longitude'),
            'radius' => $request->input('within.radius')
        ];

        $places = $this->placeService->list($query, $limit, $offset, $orderBy, $within);

        return response()->json($places);
    }
    public function show($id){
        $places = $this->placeService->getplace($id);

        return response()->json($places);
    }
    public function create(Request $request)
    {
        $place = [
            'name' => 'new test',
            'latitude' => '47.6204232',
            'longitude' => '-122.34935530000001'
        ];

        $data = $this->placeService->createPlace($place);

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to create place',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($data);
    }
    public function update($id)
    {
        $place = [
            'building' => 'Seattle Space Needle2'
        ];

        $data = $this->placeService->updatePlace($id, $place);

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to update place',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($data);
    }
    public function delete($id)
    {
        $data = $this->placeService->deletePlace($id);

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to delete place',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['message' => 'Place deleted successfully']);
    }
}
