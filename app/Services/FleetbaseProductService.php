<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FleetbaseProductService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.fleetbase.io/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('FLEETBASE_API_KEY'),
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function list($params = [])
    {
        try {
            $response = $this->client->get('products', ['query' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->logError($e);
            return ['error' => 'Failed to fetch products'];
        }
    }

    protected function logError(RequestException $e)
    {
        if ($e->hasResponse()) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();
            Log::error("Fleetbase API request failed with status code {$statusCode}: {$responseBody}");
        } else {
            Log::error("Fleetbase API request failed: " . $e->getMessage());
        }
    }
}
