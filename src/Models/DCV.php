<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class DCV extends GogetSSL
{
    private string $url;

    private client $client;


    public function __construct($config)
    {
        parent::__construct($config);
        $this->url = $this->config['GOGETSSL_API_URL'] . '/tools';
        $this->client = new Client();
    }

    public function getDomainAlternative(string $certificate): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'csr' => $certificate,
            ]];
        $request = new Request('POST', $this->url . '/domain/alternative?auth_key=' . $this->key,$headers);
        $res = $this->client->sendAsync($request,$options)->wait();
        return $this->handleResponse($res);
    }

    public function getDomainEmails(string $domain): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'domain' => $domain,
            ]];
        $request = new Request('POST', $this->url . '/domain/emails?auth_key=' . $this->key,$headers);
        $res = $this->client->sendAsync($request,$options)->wait();
        return $this->handleResponse($res);

    }

    public function getDomainEmailsForGeotrust(string $domain): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'domain' => $domain,
            ]];
        $request = new Request('POST', $this->url . '/domain/emails/geotrust?auth_key=' . $this->key,$headers);
        $res = $this->client->sendAsync($request,$options)->wait();
        return $this->handleResponse($res);
    }

    public function domainGetFromWhois(string $domain): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'domain' => $domain,
            ]];
        $request = new Request('POST', $this->url . '/domain/domain_get_from_whois?auth_key=' . $this->key,$headers);
        $res = $this->client->sendAsync($request,$options)->wait();
        return $this->handleResponse($res);

    }

}
