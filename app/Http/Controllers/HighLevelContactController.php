<?php

namespace App\Http\Controllers;

use App\Services\FleetbaseContactService;
use Illuminate\Http\Request;

class HighLevelContactController extends Controller
{
    protected $contactService;

    public function __construct(FleetbaseContactService $contactService)
    {
        $this->contactService = $contactService;
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

        $contact = $this->contactService->list($query, $limit, $offset, $orderBy, $within);

        return response()->json($contact);
    }

    public function show($id)
    {
        $contact = $this->contactService->getPlace($id);

        return response()->json($contact);
    }
    public function create()
    {
        $data = [
            'name'=>'testing', 
            'title'=>'test', 
            'email'=>'test@gmail.com', 
            'phone'=> '+15404694336', 
            'phone_country_code'=>10, 
            'type'=>'technician'
            ];

        $response = $this->contactService->createContact($data);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to create contact',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($response, 201);
    }
    public function update($id)
    {
        $data = [
            'name'=>'update data',
            'phone'=>'+15404694399'
            ];  

        $response = $this->contactService->updateContact($id, $data);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to update contact',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($response, 200);
    }
    public function destroy($id)
    {
        $response = $this->contactService->deleteContact($id);

        if (isset($response['error'])) {
            return response()->json([
                'error' => 'Failed to delete contact',
                'details' => $response['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json(['message' => 'Contact deleted successfully'], 200);
    }
}
