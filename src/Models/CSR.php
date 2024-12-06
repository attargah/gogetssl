<?php

namespace Attargah\GogetSSL\Models;



use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class CSR extends GogetSSL
{
    private string $url;

    private client $client;


    public function __construct($config)
    {
        parent::__construct($config);
        $this->url = $this->config['GOGETSSL_API_URL'] . '/tools/csr';
        $this->client = new Client();
    }

    public function decodeCSR(string $certificate): array
    {

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'csr' => $certificate,
            ]];
        $request = new Request('POST', $this->url . '/decode?auth_key=' . $this->key,$headers);
        $res = $this->client->sendAsync($request,$options)->wait();
        return $this->handleResponse($res);
    }

    public function generateCSR(array $params): array
    {

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $params
        ];
        $request = new Request('POST', $this->url . '/generate?auth_key=' . $this->key,$headers);
        $res = $this->client->sendAsync($request,$options)->wait();
        return $this->handleResponse($res);

    }

    public function validateCSR(string $certificate): array
    {

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'csr' => $certificate,
            ]];
        $request = new Request('POST', $this->url . '/validate',$headers);
        $res = $this->client->sendAsync($request,$options)->wait();
        return $this->handleResponse($res);
    }


}
