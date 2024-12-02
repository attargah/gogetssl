<?php

namespace Attargah\GogetSSL;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Auth
{

    private array $config;


    public function __construct(array $config)
    {

        $this->config = $config;
    }

    public function getToken(): string
    {

        $accessToken = Cache::get('gogetssl_key');

        if (!$accessToken) {
            return $this->fetchNewToken();
        }

        return $accessToken;
    }

    public function fetchNewToken(): string
    {

        try {
            $client = new Client();
            $response = $client->post($this->config['url'] . '/auth', [
                'form_params' => [
                    'user' => $this->config['username'],
                    'pass' => $this->config['password'],
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);
                if (!empty($data['key'])){
                    Cache::put('gogetssl_key', $data['key'], now()->addYear());
                    return $data['key'];
                }

            }
            throw new \Exception('Token fetch failed: ' . $response->getBody()->getContents());
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

}
