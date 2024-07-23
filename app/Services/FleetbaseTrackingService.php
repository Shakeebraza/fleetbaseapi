<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FleetbaseTrackingService
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

    public function createTrackingNumber($data)
    {
        try {
            $response = $this->client->post('tracking-numbers', [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }

    public function getTrackingNumber($id)
    {
        try {
            $response = $this->client->get("tracking-numbers/{$id}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }

    public function listTrackingNumbers()
    {
        try {
            $response = $this->client->get('tracking-numbers');
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }

    public function updateTrackingNumber($id, $data)
    {
        try {
            $response = $this->client->put("tracking-numbers/{$id}", [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }

    public function deleteTrackingNumber($id)
    {
        try {
            $response = $this->client->delete("tracking-numbers/{$id}");
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
