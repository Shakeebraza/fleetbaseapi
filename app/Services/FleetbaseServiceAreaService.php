<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FleetbaseServiceAreaService
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

    public function list($limit = 10, $offset = 0)
    {
        $params = array_filter([
            'limit' => $limit,
            'offset' => $offset,
        ]);

        Log::info('Listing Service Areas with parameters:', $params);

        try {
            $response = $this->client->get('service-areas', ['query' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return ['error' => 'Failed to fetch service areas'];
        }
    }

    public function getServiceArea($id)
    {
        try {
            $response = $this->client->get("service-areas/{$id}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return ['error' => 'Failed to fetch service area'];
        }
    }

    public function create($serviceArea)
    {
        try {
            $response = $this->client->post('service-areas', [
                'json' => $serviceArea
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return [
                'error' => 'Failed to create service area',
                'details' => $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage()
            ];
        }
    }
    public function updateServiceArea($id, $data)
    {
        try {
            $response = $this->client->put("service-areas/{$id}", [
                'json' => $data
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }

    public function deleteServiceArea($id)
    {
        try {
            $response = $this->client->delete("service-areas/{$id}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return [
                'error' => 'Failed to delete service area',
                'details' => $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage()
            ];
        }
    }

protected function handleError(RequestException $e)
{
    $errorMessage = 'An error occurred';
    $errorDetails = [];

    if ($e->hasResponse()) {
        $response = $e->getResponse();
        $statusCode = $response->getStatusCode();
        $responseBody = $response->getBody()->getContents();
        $errorMessage = "Fleetbase API request failed with status code {$statusCode}";
        $errorDetails = json_decode($responseBody, true);
    } else {
        $errorMessage = $e->getMessage();
    }

    Log::error($errorMessage, $errorDetails);

    return [
        'error' => $errorMessage,
        'details' => $errorDetails
    ];
}
}
