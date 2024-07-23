<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FleetbaseServiceRateService
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
    public function listServiceRates()
    {
        try {
            $response = $this->client->get('service-rates');
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }
    public function getServiceRate(string $id)
    {
        try {
            $response = $this->client->get("service-rates/{$id}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }
    public function createServiceRate(array $data)
    {
        try {
            $response = $this->client->post('service-rates', [
                'form_params' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }



    public function updateServiceRate(string $id, array $data)
    {
        try {
            $response = $this->client->put("service-rates/{$id}", [
                'form_params' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }

    public function deleteServiceRate(string $id)
    {
        try {
            $response = $this->client->delete("service-rates/{$id}");
            return ['message' => 'Service rate deleted successfully'];
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
