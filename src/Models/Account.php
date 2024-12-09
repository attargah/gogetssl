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
        $this->url = $this->config['url'] . '/account/';
        $this->client = new Client();
    }

    /**
     * The getAccountDetails method returns basic information for partner account.
     *
     * If no errors, following parameters will be returned:
     *  first_name
     *  last_name
     *  company_name
     *  company_vat
     *  company_phone
     *  phone
     *  fax
     *  address
     *  city
     *  state
     *  postal_code
     *  country
     *  email
     *  reseller_plan
     *  currency
     *  success - success value (true)
     *
     * @return array
     */
    public function getAccountDetails(): array
    {
        $request = new Request('GET', $this->url.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);

    }

    /**
     * The getAccountBalance method returns available funds for partner account.
     *
     * If no errors, following parameters will be returned:
     *  balance - account available credit
     *  currency - currency of available credit
     *  success - success value (true)
     *
     * @return array
     */
    public function getAccountBalance(): array
    {
        $request = new Request('GET', $this->url.'/balance?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);

    }




}
