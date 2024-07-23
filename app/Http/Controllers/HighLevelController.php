<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HighLevelApiService;

class HighLevelController extends Controller
{
    protected $highLevelApiService;

    public function __construct(HighLevelApiService $highLevelApiService)
    {
        $this->highLevelApiService = $highLevelApiService;
    }

    public function redirectToAuthorization()
    {
        $authUrl = $this->highLevelApiService->getAuthorizationUrl();
        return redirect()->away($authUrl);
    }

    public function handleCallback(Request $request)
    {
        if (!$request->has('code')) {
            return view('/error')->with('message', 'Authorization code not provided.');
        }

        $code = $request->query('code');
        // dd(session()->all());
        $tokens = $this->highLevelApiService->getAccessTokenFromLeadConnector($code);
        // dd($tokens);

        if (!$tokens || !isset($tokens['access_token'])) {
            return redirect('/')->with('message', 'Failed to retrieve access token.');
        }

        // Store tokens in session or database
        session([
            'highlevel_access_token' => $tokens['access_token'],
            'userId' => $tokens['userId'],
            'companyId' => $tokens['companyId'],
            'highlevel_refresh_token' => $tokens['refresh_token'],
        ]);

        return redirect()->route('contacts');
    }

    public function fetchContacts()
    {
        // dd(session()->all());
        $accessToken = session('highlevel_access_token');

        if (!$accessToken) {
            return response()->json(['error' => 'Access token not found.'], 401);
        }

        try {
            $contacts = $this->highLevelApiService->fetchContacts($accessToken,$locationId='NovQXVITh9Sw3CUcgzav');
            return response()->json($contacts);
            // return view('contacts', ['contactsJson' => $contacts]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
