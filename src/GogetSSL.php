<?php

namespace Attargah\GogetSSL;

use Attargah\GogetSSL\Models\Products;

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

    public function CSR()
    {
        // TODO: Implement CSR() method.
    }

    public function DCV()
    {
        // TODO: Implement DCV() method.
    }

    public function WebServers()
    {
        // TODO: Implement WebServers() method.
    }

    public function Account()
    {
        // TODO: Implement Account() method.
    }

    public function LEI()
    {
        // TODO: Implement LEI() method.
    }

    public function Orders()
    {
        // TODO: Implement Orders() method.
    }

    public function Validation()
    {
        // TODO: Implement Validation() method.
    }

    public function Invoices()
    {
        // TODO: Implement Invoices() method.
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
