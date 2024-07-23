<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FleetbaseEntityService
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

        Log::info('Listing Entities with parameters:', $params);

        try {
            $response = $this->client->get('entities', ['query' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return ['error' => 'Failed to fetch Entities'];
        }
    }

    public function getPlace($id)
    {
        try {
            $response = $this->client->get("entities/{$id}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return ['error' => 'Failed to fetch place'];
        }
    }

    public function createEntity($data)
    {
        try {
            $response = $this->client->post('entities', [
                'json' => $data
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return [
                'error' => 'Failed to create entity',
                'details' => $e->getResponse()->getBody()->getContents()
            ];
        }
    }

    public function deleteEntity($id)
    {
        try {
            $response = $this->client->delete("entities/{$id}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
            return [
                'error' => 'Failed to delete entity',
                'details' => $e->getResponse()->getBody()->getContents()
            ];
        }
    }
        public function updateEntity($id, $data)
        {
            try {
                $response = $this->client->put("entities/{$id}", [
                    'json' => $data
                ]);
        
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
