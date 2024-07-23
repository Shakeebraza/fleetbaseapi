<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FleetbaseTrackingService;

class TrackingController extends Controller
{
    protected $trackingService;

    public function __construct(FleetbaseTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    public function create(Request $request)
    {
        $data = [
            'name'=>'testingggg'
        ];

        $response = $this->trackingService->createTrackingNumber($data);

        return response()->json($response);
    }

    public function show($id)
    {
        $response = $this->trackingService->getTrackingNumber($id);

        return response()->json($response);
    }

    public function index()
    {
        $response = $this->trackingService->listTrackingNumbers();

        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $data = [
            'name'=>'testingggg'
        ];

        $response = $this->trackingService->updateTrackingNumber($id, $data);

        return response()->json($response);
    }

    public function destroy($id)
    {
        $response = $this->trackingService->deleteTrackingNumber($id);

        return response()->json($response);
    }
}
