<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class Orders extends GogetSSL
{

    private string $url;

    private client $client;


    public function __construct($config)
    {
        parent::__construct($config);
        $this->url = $this->config['url'] . '/';
        $this->client = new Client();
    }

    public function addSSLOrder(array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'orders/add_ssl_order?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);

    }

    public function reissueSSLOrder(array $array,int $orderID):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'orders/ssl/reissue/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);

    }

    public function addSSLRenewOrder(array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'orders/add_ssl_renew_order?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    public function addSSLSANOrder(array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'orders/add_ssl_san_order?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    public function cancelOrder(array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'orders/cancel_ssl_order?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    public function getOrderCommonDetails(string $status):array
    {
        $request = new Request('GET', $this->url.'orders?auth_key='.$this->key.'&status='.$status);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getOrderStatuses(string $cids):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'cids' => $cids
            ]
        ];
        $request = new Request('POST', $this->url . 'orders/statuses?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    public function getOrderStatus(int $orderID):array
    {
        $request = new Request('GET', $this->url.'orders/status/'.$orderID.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function recheckCAA(int $orderID):array
    {
        $request = new Request('GET', $this->url.'orders/ssl/recheck-caa/'.$orderID.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getUnpaidOrders():array
    {
        $request = new Request('GET', $this->url.'orders/list/unpaid?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getAllSSLOrders(int $limit=1000,int $offset = 1000):array
    {
        $request = new Request('GET', $this->url.'orders/ssl/all?auth_key='.$this->key.'&limit='.$limit.'&offset='.$offset);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function comodoClaimFreeEV(int $orderID):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $request = new Request('POST', $this->url . 'orders/ssl/comodo_claim_free_ev/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getTotalOrders():array
    {
        $request = new Request('GET', $this->url.'account/total_orders?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

}
