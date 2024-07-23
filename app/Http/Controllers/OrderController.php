<?php

namespace App\Http\Controllers;

use App\Services\FleetbaseService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $fleetbaseService;

    public function __construct(FleetbaseService $fleetbaseService)
    {
        $this->fleetbaseService = $fleetbaseService;
    }


    public function index()
    {
        $orders = $this->fleetbaseService->listOrders();

        return response()->json($orders);
    }

    public function show($id)
    {
        $order = $this->fleetbaseService->getOrder($id);

        return response()->json($order);
    }
    public function create()
    {
        $order = [
            'payload' => 'payload_gkk38HQ',
            'dispatch' => false,
            'type' => 'Point',
            'order_config' => [          
                'key' => 'coordinates'           
            ]
        ];

        $data = $this->fleetbaseService->createOrder($order);

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to create order',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($data);
    }
    public function update(Request $request, $id)
    {
        $status = $request->input('status'); // Retrieve status from request

        $data = $this->fleetbaseService->updateOrderStatus($id, $status);

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to update order status',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json($data);
    }
    public function delete(Request $request, $id)
    {
        $data = $this->fleetbaseService->deleteOrder($id);

        if (isset($data['error'])) {
            return response()->json([
                'error' => 'Failed to delete order',
                'details' => $data['details'] ?? 'No additional details available'
            ], 400);
        }

        return response()->json([
            'success' => 'Order successfully deleted',
        ]);
    }
    
}

