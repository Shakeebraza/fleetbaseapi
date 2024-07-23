<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FleetbasePayloadService;

class HighLevelPayloadController extends Controller
{
    protected $PayloadService;

    public function __construct(FleetbasePayloadService $PayloadService)
    {
        $this->PayloadService = $PayloadService; 
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

        $data = $this->PayloadService->list($query, $limit, $offset, $orderBy, $within);
        return response()->json($data);
    }

    public function show($id)
    {
        $data = $this->PayloadService->getPlace($id); 

        return response()->json($data);
    }
    Public function create()
    {
        $payload = [
            'pickup' => 'place_cEEsKiP',
            'dropoff' => 'place_bqqIrT8',
            'type' => 'food_delivery',
            'cod_payment' =>1600 ,
            'cod_currency' => 'SGD',
        ];

        $data = $this->PayloadService->createPayload($payload);

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to create payload',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($data);
    }
    public function update($id)
    {
        $payload = [
            'cod_payment' => 1600
        ];

        $data = $this->PayloadService->updatePayload($id, $payload);

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to update payload',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($data);
    }
    public function delete($id)
    {
        $data = $this->PayloadService->deletePayload($id);

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to delete payload',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['message' => 'Payload deleted successfully']);
    }
}
