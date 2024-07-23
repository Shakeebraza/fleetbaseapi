<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FleetbaseService
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

    public function getOrder($id)
    {
        $response = $this->client->get("orders/{$id}");
        return json_decode($response->getBody()->getContents(), true);
    }

    public function listOrders()
    {
        $response = $this->client->get('orders');
        return json_decode($response->getBody()->getContents(), true);
    }

    public function createOrder($order)
    {
        try {
            Log::info('Creating Order with data:', $order); // Log the request data

            $response = $this->client->post('orders', [
                'json' => $order
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            Log::info('Order creation response:', $responseData); // Log the response data

            return $responseData;
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }
    public function updateOrderStatus($id, $status)
    {
        try {
            $response = $this->client->put("orders/{$id}", [
                'form_params' => [
                    'status' => $status,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }
    public function deleteOrder($id)
    {
        try {
            $response = $this->client->delete("orders/{$id}");

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
