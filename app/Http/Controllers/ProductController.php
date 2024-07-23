<?php

namespace App\Http\Controllers;

use App\Services\FleetbaseProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(FleetbaseProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $params = $request->only(['query', 'limit', 'offset', 'order_by', 'within']);

        if (isset($params['within']) && is_array($params['within'])) {
            $params['within[latitude]'] = $params['within']['latitude'] ?? null;
            $params['within[longitude]'] = $params['within']['longitude'] ?? null;
            $params['within[radius]'] = $params['within']['radius'] ?? 5;
            unset($params['within']);
        }

        $products = $this->productService->list($params);

        return response()->json($products);
    }
}
