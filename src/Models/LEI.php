<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class LEI extends GogetSSL
{

    private string $url;

    private client $client;

    public function __construct($config)
    {
        parent::__construct($config);
        $this->url = $this->config['url'] . '/';
        $this->client = new Client();
    }

    public function createNewLEI(array $array,bool $is_test = false): array
    {
        $test_param = "";
        if ($is_test) {
            $test_param = "&test=1";
        }
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'orders/lei/create?auth_key=' . $this->key . $test_param, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);

    }

    public function getLEIJurisdictions(): array
    {
        $request = new Request('GET', $this->url . '/lei/jurisdictions?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function confirmLEIDataQuality(string $confirm,int $orderID): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'confirm' => $confirm
            ]];

        $request = new Request('POST', $this->url . 'lei/confirm/'.$orderID.'?auth_key=' . $this->key , $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    public function getLeiStatus(int $orderID): array
    {
        $request = new Request('GET', $this->url . '/lei/status'.$orderID.'?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function renewLEI(int $orderID,array $array): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'confirm' => $array
            ]];

        $request = new Request('POST', $this->url . 'orders/lei/renew/'.$orderID.'?auth_key=' . $this->key , $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    public function leiLookup(string $query): array
    {
        $request = new Request('GET', $this->url . '/lei/lookup?auth_key=' . $this->key.'&query='.$query);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }


}
