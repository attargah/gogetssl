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

    /**
     * The getAllInvoices method returns the list of all partner invoices.
     *
     * If no errors, following parameters will be returned:
     *  invoices - an array of invoices
     *  order_id - invoice order ID
     *  number - invoice serial number
     *  date - invoice creation date
     *  subtotal - subtotal amount
     *  tax - invoice tax amount
     *  total - invoice total amount
     *  status - invoice status (paid, unpaid, cancelled, refunded)
     *  tax_rate - invoice tax rate in %
     *  currency - invoice currency
     *  payment_method - invoice payment method (paypal, skrill, webmoney, balance, bank_transfer)
     *  success - success value (true)
     *
     * @return array
     */
    public function getAllInvoices():array
    {
        $request = new Request('GET', $this->url.'account/invoices?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getUnpaidInvoices method returns the list of all partner invoices with status 'unpaid'.
     *
     * If no errors, following parameters will be returned:
     *  invoices - an array of invoices
     *  order_id - invoice order ID
     *  number - invoice serial number
     *  date - invoice creation date
     *  tax - invoice tax amount
     *  tax_rate - invoice tax rate in %
     *  subtotal - amount without tax
     *  total - invoice amount with tax
     *  currency - invoice currency
     *  payment_method - invoice payment method (paypal, skrill, webmoney, balance, bank_transfer)
     *  success - success value (true)
     *
     * @return array
     */
    public function getUnpaidInvoices():array
    {
        $request = new Request('GET', $this->url.'account/invoices/unpaid?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getOrderInvoice returns detailed information for the invoice matching “order_id” parameter.
     * “order_id” is returned during addSSLOrder command.
     *
     * Parameters:
     *  order_id
     *
     * If no errors, following parameters will be returned:
     *  order_id - unique order ID
     *  number - invoice unique number
     *  date - invoice creation date
     *  subtotal - invoice subtotal amount
     *  tax - invoice tax amount
     *  tax_rate - invoice tax rate in %
     *  total - invoice total amount
     *  status - invoice status (paid, unpaid, refunded, cancelled)
     *  currency - invoice currency
     *  payment_method - invoice payment method (paypal, skrill, webmoney, bank_transfer, balance)
     *  success - success value (true)
     *
     * @param int $orderID
     * @return array
     */
    public function getOrderInvoice(int $orderID):array
    {
        $request = new Request('GET', $this->url.'orders/invoice/'.$orderID.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getInvoiceListByPeriod method returns a list of invoices for the specified period (but not more than 365 days).
     * It is possible to filter result by passing "date_from" and "date_till" parameters in "Y-m-d" format.
     * If no date parameters are provided, then the result for the last 365 days is returned.
     *
     * Parameters:
     *  dateFrom | 2022-01-01 | OPTIONAL
     *  dateTill | 2022-01-31 | OPTIONAL
     *
     * If no errors, following parameters will be returned:
     *  invoices - an array of invoices
     *  id - invoice order ID
     *  number - invoice serial number
     *  date - invoice creation date
     *  subtotal - subtotal amount
     *  tax - invoice tax amount
     *  tax_rate - invoice tax rate in %
     *  total - invoice total amount
     *  currency - invoice currency
     *  status - invoice status (paid, unpaid, cancelled, refunded)
     *  payment_method - invoice payment method (creditcard, paypal, skrill, webmoney, balance, bank_transfer)
     *  items - an array of invoice items
     *  order_id
     *  order_number
     *  date
     *  subtotal
     *  period
     *  product_name
     *  product_id
     *  success - success value (true)
     *
     * @param string $dateFrom
     * @param string $dateTill
     * @return array
     */
    public function getInvoiceListByPeriod(string $dateFrom,string $dateTill):array
    {
        $request = new Request('GET', $this->url.'invoice/?auth_key='.$this->key.'&date_from='.$dateFrom.'&date_till='.$dateTill);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getInvoiceDetails returns information for the invoice matching “invoice_id” parameter.
     * “invoice_id” is returned during addSSLOrder command.
     *
     * Parameters:
     *  invoice_id - ID of the required invoice
     *
     * If no errors, following parameters will be returned:
     *  invoice - an array of invoices
     *  number - invoice serial number
     *  date - invoice creation date
     *  subtotal - subtotal amount
     *  tax - invoice tax amount
     *  tax_rate - invoice tax rate in %
     *  total - invoice total amount
     *  currency - invoice currency
     *  status - invoice status (paid, unpaid, cancelled, refunded)
     *  payment_method - invoice payment method (creditcard, paypal, skrill, webmoney, balance, bank_transfer)
     *  items - an array of invoice items
     *  order_id
     *  order_number
     *  date
     *  subtotal
     *  period
     *  product_name
     *  product_id
     *  success - true
     *
     * @param int $invoiceID
     * @return array
     */
    public function getInvoiceDetails(int $invoiceID):array
    {
        $request = new Request('GET', $this->url.'invoice/'.$invoiceID.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }


}
