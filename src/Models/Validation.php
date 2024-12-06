<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class Validation extends GogetSSL
{

    private string $url;

    private client $client;


    public function __construct($config)
    {
        parent::__construct($config);
        $this->url = $this->config['GOGETSSL_API_URL'] . '/orders/ssl/';
        $this->client = new Client();
    }

    public function changeDomainsValidationMethod(int $orderID,array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'change_domains_validation_method/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    public function changeValidationEmail(int $orderID,array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'change_validation_email/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    public function resendValidationEmail(int $orderID):array
    {
        $request = new Request('GET', $this->url.'resend_validation_email/'.$orderID.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function changeDcv(int $orderID,array $array):array
    {

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'change_dcv/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    public function revalidate(int $orderID,string $domain):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'domain' => $domain
            ]
        ];
        $request = new Request('POST', $this->url . 'revalidate/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }
    public function resend(int $orderID,string $domain):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'domain' => $domain
            ]
        ];
        $request = new Request('POST', $this->url . 'revalidate/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

}
