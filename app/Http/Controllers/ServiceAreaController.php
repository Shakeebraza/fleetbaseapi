<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FleetbaseServiceAreaService;
use Illuminate\Support\Facades\Log;

class ServiceAreaController extends Controller
{
    protected $serviceAreaService;

    public function __construct(FleetbaseServiceAreaService $serviceAreaService)
    {
        $this->serviceAreaService = $serviceAreaService;
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);

        $data = $this->serviceAreaService->list($limit, $offset);

        return response()->json($data);
    }

    public function show($id)
    {
        $data = $this->serviceAreaService->getServiceArea($id);

        return response()->json($data);
    }

    public function create(Request $request)
    {
            $serviceArea = [
            'name' => 'laraib fox ',
            'country'=>'pakistan',
            'border'=>4000
                ];
        $data = $this->serviceAreaService->create($serviceArea);

        if (isset($data['error'])) {

            return response()->json([
                'message' => 'data added successfully.....',
                'status'=>200
            ], 200);
        }
    }
    public function update(Request $request, $id)
    {
        $data = [
            'status' => 'inactive',
            'name' => 'shakeeb'
        ];

        $response = $this->serviceAreaService->updateServiceArea($id, $data);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to update service area',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['message' => 'Service area updated successfully']);
    }

    public function delete($id)
    {
        $data = $this->serviceAreaService->deleteServiceArea($id);

        return response()->json($data);
    }
}
