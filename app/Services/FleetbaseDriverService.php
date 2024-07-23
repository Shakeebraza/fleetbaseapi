<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FleetbaseDriverService
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

    public function listDrivers($limit = 10)
    {
        $params = array_filter([
            'limit' => $limit,
        ]);

        Log::info('Listing Drivers with parameters:', $params);

        try {
            $response = $this->client->get('drivers', ['query' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return ['error' => 'Failed to fetch drivers'];
        }
    }

    public function getDriver($id)
    {
        try {
            $response = $this->client->get("drivers/{$id}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return ['error' => 'Failed to fetch driver'];
        }
    }
    public function createDriver($driverData)
    {
        try {
            $response = $this->client->post('drivers', [
                'form_params' => $driverData
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return [
                'error' => 'Failed to create driver',
                'details' => $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage()
            ];
        }
    }
    public function updateDriver($id, $data)
    {
        try {
            $response = $this->client->put("drivers/{$id}", [
                'form_params' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }
    public function deleteDriver($id)
    {
        try {
            $response = $this->client->delete("drivers/{$id}");

            // Return the response if successful
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
