<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FleetbaseEntityService;

class EntityController extends Controller
{
    protected $entityService;

    public function __construct(FleetbaseEntityService $entityService)
    {
        $this->entityService = $entityService; 
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

        $data = $this->entityService->list($query, $limit, $offset, $orderBy, $within); 
        return response()->json($data);
    }

    public function show($id)
    {
        $data = $this->entityService->getPlace($id); 

        return response()->json($data);
    }

    public function createEntity()
    {
        $data = [
            'type' => 'fcl',
            'name' => 'FCL #281290',
            'internal_id' => '281290',
            'description' => '20ft Full Container Load',
            'weight' => 16800,
            'weight_unit' => 'kg',
            'length' => 6.1,
            'width' => 2.4,
            'height' => 2.6,
            'dimensions_unit' => 'm'
        ];

        $response = $this->entityService->createEntity($data);

        if (isset($response['error'])) {
            return response()->json([
                'message' => 'Failed to create entity',
                'error' => $response['details']
            ], 400);
        }

        return response()->json([
            'message' => 'Entity created successfully',
            'data' => $response
        ]);
    }
    public function update(Request $request, $id)
    {
        $data = [
            'declared_value' => 20000,
            'currency' => 'USD'
        ];

        $response = $this->entityService->updateEntity($id, $data);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to update entity',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['message' => 'Entity updated successfully']);
    }

    public function deleteEntity($id)
    {
        $response = $this->entityService->deleteEntity($id);

        if (isset($response['error'])) {
            return response()->json([
                'message' => 'Failed to delete entity',
                'error' => $response['details']
            ], 400);
        }

        return response()->json([
            'message' => 'Entity deleted successfully',
            'data' => $response
        ]);
    }
}
