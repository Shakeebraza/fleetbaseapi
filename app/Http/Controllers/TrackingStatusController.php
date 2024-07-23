<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FleetbaseTrackingStatusService;

class TrackingStatusController extends Controller
{
    protected $trackingStatusService;

    public function __construct(FleetbaseTrackingStatusService $trackingStatusService)
    {
        $this->trackingStatusService = $trackingStatusService;
    }

    public function create()
    {
        $data = [
            'name'=>'fission fox',
            'tracking_number' =>'LAU22432337761SD'
        ];
        $response = $this->trackingStatusService->createTrackingStatus($data);

        return response()->json($response);
    }

    public function show($id)
    {
        $response = $this->trackingStatusService->getTrackingStatus($id);

        return response()->json($response);
    }

    public function index()
    {
        $response = $this->trackingStatusService->listTrackingStatuses();

        return response()->json($response);
    }

    public function update( $id)
    {
        $data = [
            'name'=>'fission fox',
            'details' => 'LAU22432337761SD'
        ];
        $response = $this->trackingStatusService->updateTrackingStatus($id, $data);

        return response()->json($response);
    }

    public function destroy($id)
    {
        $response = $this->trackingStatusService->deleteTrackingStatus($id);

        return response()->json($response);
    }
}
