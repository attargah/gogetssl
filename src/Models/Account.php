<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Account extends GogetSSL
{

    private string $url;

    private client $client;

    public function __construct($config)
    {
        parent::__construct($config);
        $this->url = $this->config['GOGETSSL_API_URL'] . '/account/';
        $this->client = new Client();
    }

    public function getAccountDetails(): array
    {
        $request = new Request('GET', $this->url.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);

    }

    public function getAccountBalance(): array
    {
        $request = new Request('GET', $this->url.'/balance?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);

    }




}
