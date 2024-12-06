<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Invoices extends GogetSSL
{
    private string $url;

    private client $client;


    public function __construct($config)
    {
        parent::__construct($config);
        $this->url = $this->config['url'] . '/';
        $this->client = new Client();
    }

    public function getAllInvoices():array
    {
        $request = new Request('GET', $this->url.'account/invoices?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getUnpaidInvoices():array
    {
        $request = new Request('GET', $this->url.'account/invoices/unpaid?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getOrderInvoice(int $orderID):array
    {
        $request = new Request('GET', $this->url.'orders/invoice/'.$orderID.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getInvoiceListByPeriod(string $dateFrom,string $dateTill):array
    {
        $request = new Request('GET', $this->url.'invoice/?auth_key='.$this->key.'&date_from='.$dateFrom.'&date_till='.$dateTill);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    public function getInvoiceDetails(int $invoiceID):array
    {
        $request = new Request('GET', $this->url.'invoice/'.$invoiceID.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }


}
