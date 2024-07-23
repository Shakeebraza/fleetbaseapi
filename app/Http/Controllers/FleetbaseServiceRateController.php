<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FleetbaseServiceRateService;

class FleetbaseServiceRateController extends Controller
{
    protected $serviceRateService;

    public function __construct(FleetbaseServiceRateService $serviceRateService)
    {
        $this->serviceRateService = $serviceRateService;
    }
    public function list()
    {
        $response = $this->serviceRateService->listServiceRates();

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to fetch service rates',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['data' => $response]);
    }
    public function get($id)
    {
        $response = $this->serviceRateService->getServiceRate($id);
    
        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to fetch service rate',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }
    
        return response()->json(['data' => $response]);
    }
    public function create(Request $request)
    {
        $data = [
            'service_name' => 'shakeeb', 
            'service_type' => 'passenger', 
            'rate_calculation_method' => 'algo', 
            'currency' => 'SGD', 
            'base_fee' => 100, 
            'algorithm' => '(({distance}/1000)*55)+(({time}/60)*33)', 
            'has_peak_hours_fee' => true, 
            'peak_hours_calculation_method' => 'flat', 
            'peak_hours_flat_fee' => 200,
            'peak_hours_start' => '17:00', 
            'peak_hours_end' => '19:00'
        ];

        $response = $this->serviceRateService->createServiceRate($data);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to create service rate',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['message' => 'Service rate created successfully', 'data' => $response]);
    }



    public function update($id)
    {
        $data = [
            'service_name' => 'shakeeb', 
            'service_type' => 'passenger', 
            'rate_calculation_method' => 'algo', 
            'currency' => 'SGD', 
            'base_fee' => 100, 
            'algorithm' => '(({distance}/1000)*55)+(({time}/60)*33)', 
            'has_peak_hours_fee' => true, 
            'peak_hours_calculation_method' => 'flat', 
            'peak_hours_flat_fee' => 200,
            'peak_hours_start' => '17:00', 
            'peak_hours_end' => '19:00'
        ];

        $response = $this->serviceRateService->updateServiceRate($id, $data);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to update service rate',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['message' => 'Service rate updated successfully', 'data' => $response]);
    }

    public function delete($id)
    {
        $response = $this->serviceRateService->deleteServiceRate($id);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to delete service rate',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($response);
    }


}
