<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FleetbasePayloadService
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

    public function list($query = null, $limit = 10, $offset = 0, $orderBy = null, $within = null)
    {
        $params = array_filter([
            'query' => $query,
            'limit' => $limit,
            'offset' => $offset,
            'order_by' => $orderBy,
            'within' => $within,
        ]);

        Log::info('Listing Payloads with parameters:', $params);

        try {
            $response = $this->client->get('payloads', ['query' => $params]); // Corrected endpoint
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return ['error' => 'Failed to fetch Payloads']; // Corrected error message
        }
    }

    public function getPlace($id)
    {
        try {
            $response = $this->client->get("payloads/{$id}"); // Corrected endpoint
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return ['error' => 'Failed to fetch place'];
        }
    }
public function createPayload($payload)
{
    try {
        $response = $this->client->post('payloads', [
            'form_params' => $payload
        ]);

        return json_decode($response->getBody()->getContents(), true);
    } catch (RequestException $e) {
        return $this->handleError($e);
    }
}
public function updatePayload($id, $payload)
{
    try {
        $response = $this->client->put("payloads/{$id}", [
            'form_params' => $payload
        ]);

        return json_decode($response->getBody()->getContents(), true);
    } catch (RequestException $e) {
        return $this->handleError($e);
    }
}
public function deletePayload($id)
{
    try {
        $response = $this->client->delete("payloads/{$id}");

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
