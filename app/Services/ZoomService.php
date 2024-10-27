<?php

namespace App\Services;

use Firebase\JWT\JWT; // Import the JWT library
use GuzzleHttp\Client; // Import GuzzleHttp for API requests
use GuzzleHttp\Exception\RequestException;

class ZoomService
{
    private $clientId;
    private $clientSecret;
    private $accountId;
    private $httpClient;
    private $jwtToken;
    private $tokenExpiresAt;

    public function __construct()
    {
        $this->clientId = env('ZOOM_CLIENT_ID'); 
        $this->clientSecret = env('ZOOM_CLIENT_SECRET');
        $this->accountId = env('ZOOM_ACCOUNT_ID');
        $this->httpClient = new Client(); // Initialize GuzzleHttp client
    }

    // Generate JWT token for Zoom API
    public function generateJwt()
    {
        $payload = [
            'iss' => $this->clientId,
            'exp' => time() + 60, // Token valid for 60 seconds
        ];

        // Specify the algorithm used for signing (usually HS256)
        $this->jwtToken = JWT::encode($payload, $this->clientSecret, 'HS256');
        $this->tokenExpiresAt = time() + 60; // Set token expiration time
        return $this->jwtToken;
    }

    // Ensure the token is valid, regenerate if necessary
    private function getJwtToken()
    {
        if (!$this->jwtToken || time() >= $this->tokenExpiresAt) {
            return $this->generateJwt();
        }
        return $this->jwtToken;
    }

    // Create a Zoom meeting
    public function createMeeting($data)
    {
        $token = $this->getJwtToken(); // Use the valid token

        try {
            $response = $this->httpClient->post("https://api.zoom.us/v2/users/{$this->accountId}/meetings", [
                'headers' => [
                    'Authorization' => "Bearer $token",
                    'Content-Type' => 'application/json',
                ],
                'json' => $data, // Pass the meeting data
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            // Handle the exception (e.g., log the error message)
            throw new \Exception("Error creating Zoom meeting: " . $e->getMessage());
        }
    }
}
