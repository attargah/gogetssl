<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class WebServers extends GogetSSL
{

    private string $url;

    private client $client;


    public function __construct($config)
    {
        parent::__construct($config);
        $this->url = $this->config['url'] . '/tools/';
        $this->client = new Client();
    }

    /**
     * Supplier ID
     * for Comodo/GGSSL: 1;
     * for Geotrust/Symantec/Thawte/RapidSSL: 2
     *
     * @param int $supplier_id
     * @return array
     */
    public function getWebServers(int $supplier_id): array
    {
        $request = new Request('GET', $this->url.'/webservers/'.$supplier_id.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }





}
