<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ApiFetcher
{
    private const URI = 'http://localhost';
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;;
    }

    public function fetch(): string
    {
        try {
            $response = $this->client->get(self::URI);

            return $response->getBody()->getContents();
        } catch (Exception $exception) {
            Log::error('Api endpoint is not working',
                [
                    'exception' => $exception,
                ]);

            return json_encode([
                'message' => 'Failed',
                'data' => [],
            ]);
        }
    }
}
