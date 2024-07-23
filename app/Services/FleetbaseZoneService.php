<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FleetbaseZoneService
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

    public function listZones($limit = 10)
    {
        $params = array_filter([
            'limit' => $limit,
        ]);

        Log::info('Listing Zones with parameters:', $params);

        try {
            $response = $this->client->get('zones', ['query' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return ['error' => 'Failed to fetch zones'];
        }
    }

    public function getZone($id)
    {
        try {
            $response = $this->client->get("zones/{$id}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return ['error' => 'Failed to fetch zone'];
        }
    }
    public function createZone($zoneData)
    {
        try {
            $response = $this->client->post('zones', [
                'form_params' => $zoneData
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return [
                'error' => 'Failed to create zone',
                'details' => $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage()
            ];
        }
    }
    public function updateZone($id, $data)
    {
        try {
            $response = $this->client->put("zones/{$id}", [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }
    public function deleteZone($id)
    {
        try {
            $response = $this->client->delete("zones/{$id}");

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
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
