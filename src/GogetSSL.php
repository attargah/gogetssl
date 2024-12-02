<?php

namespace Attargah\GogetSSL;

class GogetSSL implements \Attargah\GogetSSL\Contracts\GogetSSL
{

    protected array $config;

    protected string $token;


    public function __construct(array $config){

        $this->config = $config;
        $this->token = (new Auth($this->config))->getToken();

    }

    public function Products()
    {
        // TODO: Implement Products() method.
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



}
