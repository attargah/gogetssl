<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class Validation extends GogetSSL
{

    private string $url;

    private client $client;


    public function __construct($config)
    {
        parent::__construct($config);
        $this->url = $this->config['url'] . '/orders/ssl/';
        $this->client = new Client();
    }

    /**
     * Method allows to change domain control validation method for multiple domains from one SSL certificate
     *
     * Parameters:
     *  domains - enumeration of domain names separated by commas.
     *  new_methods - enumeration of new verification methods for the corresponding domain separated by commas. Valid values for Comodo/Section/GoGetSSL are a valid email address or HTTP, HTTPS, and DNS. Example: "dns,admin@domen2.com"
     *  orderID - Order ID
     *
     * If no errors, following parameters will be returned:
     *  message - Text message on successful operation
     *  success - success value (true)
     *
     * @param int $orderID
     * @param array $array
     * @return array
     */
    public function changeDomainsValidationMethod(int $orderID,array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'change_domains_validation_method/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * Method allows to change domain control validation method for specified common name (base domain) OR SAN item.
     *
     * Parameters:
     *  domain - common name (base domain) or SAN item
     *  new_method - new validation method for the specified domain. Valid values are valid email address or HTTP, HTTPS and DNS.
     *
     * If no errors, following parameters will be returned:
     *  message - text message on successful operation
     *  success - success value (true)
     *
     * @param int $orderID
     * @param array $array
     * @return array
     */
    public function changeValidationMethod(int $orderID,array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'change_validation_method/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * This method can be used for one of the following purposes:
     *  In case if email DCV method is already used this method can change the current DCV email address.
     *  Another usage option is changing of the current DCV method.
     *  Multi domain certificates are supported for Comodo.
     *
     * Parameters:
     *  order_id - unique order ID
     *  approver_email – in case if email DCV method is supposed to be used, provide an approver email address in this field. In case if email DCV method is already used, you can change current approver email address by providing another address in this field. In case of non-email DCV method please specified a desired method in this field using one of the following values: 'http', 'https', 'dns'.
     *  san_approval array( [domain][name] = domain, [domain][method] = dns/http/https/)
     *
     * If no errors, following parameters will be returned for each of the DCV methods respectively:
     *  E-mail:
     *      dcv_method – 'email'
     *      approver_email – Approver email address
     *  HTTP:
     *      { "http": { "link": "http://domain.tld/.well-known/pki-validation/37D0C93EE263FF9EEEA799215A9C3225.txt", "filename": "37D0C93EE263FF9EEEA799215A9C3225.txt", "content": "D30C576BF9EB30A75211CB799848EE5CABFCE3D8EE13212A57C9B7E42EF9BAA2\r\nCOMODOCA.COM\r\nt0827792001533920169" } }
     *  HTTPS:
     *      { "https": { "link": "http://domain.tld/.well-known/pki-validation/37D0C93EE263FF9EEEA799215A9C3225.txt", "filename": "37D0C93EE263FF9EEEA799215A9C3225.txt", "content": "D30C576BF9EB30A75211CB799848EE5CABFCE3D8EE13212A57C9B7E42EF9BAA2\r\nCOMODOCA.COM\r\nt0827792001533920169" } }
     *  DNS:
     *      { "dns": { "record": "_37D0C93EE263FF9EEEA799215A9C3225.domain.tld CNAME d30c576bf9eb30a75211cb799848ee5c.abfce3d8ee13212a57c9b7e42ef9baa2.t0837512001533895392.comodoca.com" } }
     *
     * @param int $orderID
     * @param array $array
     * @return array
     */
    public function changeValidationEmail(int $orderID,array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'change_validation_email/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The resendValidationEmail method re-sends validation e-mail for the order matching “order_id” parameter.
     *
     * Parameters:
     *  order_id - ID of the order
     *
     * If no errors, following parameters will be returned for each of the DCV methods respectively:
     *  message - error message or code
     *  success - result code
     *
     * @param int $orderID
     * @return array
     */
    public function resendValidationEmail(int $orderID):array
    {
        $request = new Request('GET', $this->url.'resend_validation_email/'.$orderID.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * Is used for update of DCV parameters (method, validation email).
     *
     * Parameters:
     *  order_id integer - MyGoGet order Id.
     *  domain_name string - Name of domain, for which the DCV information must be updated.
     *  new_method string - New DCV method (email, http, dns).
     *  approver_email string - DCV email address. This parameter is applicable only in case of 'email' dcv method. It also mandatory
     *
     * @param int $orderID
     * @param array $array
     * @return array
     */
    public function changeDcv(int $orderID,array $array):array
    {

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'change_dcv/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * Use 'revalidate' method in order to retry/recheck DNS CNAME OR HTTP HASH file for order matching “order_id” parameter.
     *
     * Parameters:
     *  order_id - your order ID returned in addSSLOrder method
     *  domain - CN/SAN domain name
     *
     * If no errors, following parameters will be returned:
     *  message - text message on successful operation
     *  success - success value (true)
     *
     * @param int $orderID
     * @param string $domain
     * @return array
     */
    public function revalidate(int $orderID,string $domain):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'domain' => $domain
            ]
        ];
        $request = new Request('POST', $this->url . 'revalidate/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * Use 'resend' method in order to resend validation email for specified domain from order matching “order_id” parameter.
     *
     * Parameters:
     *  order_id - your order ID returned in addSSLOrder method
     *  domain - CN/SAN domain name
     *
     * If no errors, following parameters will be returned:
     *  message - text message on successful operation
     *  success - success value (true)
     *
     * @param int $orderID
     * @param string $domain
     * @return array
     */
    public function resend(int $orderID,string $domain):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'domain' => $domain
            ]
        ];
        $request = new Request('POST', $this->url . 'revalidate/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

}
