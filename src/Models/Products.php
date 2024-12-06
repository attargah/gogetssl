<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class Products extends GogetSSL
{

    private string $url;

    private client $client;


    public function __construct($config)
    {

        parent::__construct($config);
        $this->url = $this->config['GOGETSSL_API_URL'] . '/products';
        $this->client = new Client();
    }

    public function getAllProducts(): array
    {
        $request = new Request('GET', $this->url . '?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }


    public function getAllProductPrices(): array
    {
        $request = new Request('GET', $this->url . '/all_prices?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getProductDetails(int $productID): array
    {
        $request = new Request('GET', $this->url . '/details/' . $productID . '?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getProductPrice(int $productID): array
    {
        $request = new Request('GET', $this->url . '/price/' . $productID . '?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getProductAgreement(int $productID): array
    {
        $request = new Request('GET', $this->url . '/agreement/' . $productID . '?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getSslProducts(): array
    {
        $request = new Request('GET', $this->url . '/ssl?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getSslProduct(int $productID) : array
    {
        $request = new Request('GET', $this->url . '/ssl/' . $productID . '?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }




}
