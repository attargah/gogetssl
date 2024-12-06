<?php

namespace Attargah\GogetSSL;

use Attargah\GogetSSL\Models\Account;
use Attargah\GogetSSL\Models\CSR;
use Attargah\GogetSSL\Models\DCV;
use Attargah\GogetSSL\Models\Invoices;
use Attargah\GogetSSL\Models\LEI;
use Attargah\GogetSSL\Models\Orders;
use Attargah\GogetSSL\Models\Products;
use Attargah\GogetSSL\Models\Validation;
use Attargah\GogetSSL\Models\WebServers;

class GogetSSL implements \Attargah\GogetSSL\Contracts\GogetSSL
{

    protected array $config;

    protected string $key;

    public function __construct(array $config){
        $this->config = $config;
        $this->key = (new Auth($this->config))->getKey();
    }

    public function Products(): Products
    {
       return new Products($this->config);
    }

    public function CSR(): CSR
    {
        return new CSR($this->config);
    }

    public function DCV(): DCV
    {
        return new DCV($this->config);
    }

    public function WebServers(): WebServers
    {
        return new WebServers($this->config);
    }

    public function Account(): Account
    {
        return new Account($this->config);
    }

    public function LEI(): LEI
    {
        return new LEI($this->config);
    }

    public function Orders(): Orders
    {
        return new Orders($this->config);
    }

    public function Validation(): Validation
    {
        return new Validation($this->config);
    }

    public function Invoices(): Invoices
    {
        return new Invoices($this->config);
    }

    public function handleResponse($response):array
    {
        $data = json_decode($response->getBody()->getContents(), true) ?? ['error'=>'Data not found'];
        return [
            'success' => empty($data['error']),
            'error' => !empty($data['error']),
            'body' => $data,
            'status' => $response->getStatusCode(),
        ];

    }



}
