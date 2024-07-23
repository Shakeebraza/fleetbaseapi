<?php

namespace App\Services;

use GuzzleHttp\Client;

class HighLevelApiService
{
    protected $httpClient;
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = config('services.highlevel.base_url');
        $this->clientId = config('services.highlevel.client_id');
        $this->clientSecret = config('services.highlevel.client_secret');
        $this->redirectUri = config('services.highlevel.redirect_uri');
    }

    public function getAuthorizationUrl()
    {
        $url = "{$this->baseUrl}/oauth/chooselocation";
        $params = [
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'scope' => 'contacts.readonly contacts.write',
        ];

        return $url . '?' . http_build_query($params);
    }

    public function getAccessToken($code)
    {
        
        $response = $this->httpClient->post("{$this->baseUrl}/oauth/token", [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'redirect_uri' => $this->redirectUri,
                'code' => $code,
                
            ],
        ]);
        
      
        return json_decode($response->getBody()->getContents(), true);
    }
    public function getAccessTokenFromLeadConnector($code)
    {
        $response = $this->httpClient->post("https://services.leadconnectorhq.com/oauth/token", [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'redirect_uri' => $this->redirectUri,
                'code' => $code,
                'user_type'=>'Location'
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }



    public function fetchContacts($accessToken, $locationId)
    {
        $baseUrl = 'https://services.leadconnectorhq.com/contacts/?locationId=' . $locationId;

        try {
            $response = $this->httpClient->get($baseUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                    'version' => '2021-07-28',
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                // Log the response for debugging
                \Log::error('Failed to fetch contacts', [
                    'status' => $response->getStatusCode(),
                    'body' => $response->getBody()->getContents(),
                ]);

                return response()->json(['error' => 'Failed to fetch contacts', 'details' => json_decode($response->getBody()->getContents(), true)], 400);
            }

            return json_decode($response->getBody()->getContents(), true);

        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Exception when fetching contacts', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Failed to fetch contacts', 'details' => $e->getMessage()], 500);
        }
    }

}

