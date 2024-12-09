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
     * The getWebservers method returns the list of available web server types for different vendors.
     * Web Server type required to use methods “addSSLOrder” and “reissueSSLOrder”
     *
     * Parameters:
     *  Supplier ID = Comodo/GGSSL: 1 / Geotrust/Symantec/Thawte/RapidSSL: 2
     *
     * If no errors, following parameters will be returned:
     *  webservers - array of available webservers
     *  id - ID of webserver
     *  software - Webserver or software name
     *  success - success value (true)
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
