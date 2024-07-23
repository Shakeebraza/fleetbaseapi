<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FleetbasePurchaseService;

class PurchaseController extends Controller
{
    protected $purchaseService;

    public function __construct(FleetbasePurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function create(Request $request)
    {
        $data = [
            'name'=>'shakeeb'
        ];

        $response = $this->purchaseService->createPurchaseRate($data);

        return response()->json($response);
    }

    public function show($id)
    {
        $response = $this->purchaseService->getPurchaseRate($id);

        return response()->json($response);
    }

    public function index()
    {
        $response = $this->purchaseService->listPurchaseRates();

        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $data = [
            'name'=>'shakeeb'
        ];


        $response = $this->purchaseService->updatePurchaseRate($id, $data);

        return response()->json($response);
    }

    public function destroy($id)
    {
        $response = $this->purchaseService->deletePurchaseRate($id);

        return response()->json($response);
    }
}
