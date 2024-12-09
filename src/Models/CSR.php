<?php

namespace Attargah\GogetSSL\Models;



use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class CSR extends GogetSSL
{
    private string $url;

    private client $client;


    public function __construct($config)
    {
        parent::__construct($config);
        $this->url = $this->config['url'] . '/tools/csr';
        $this->client = new Client();
    }

    /**
     * The decodeCSR method validates submitted CSR code. Returns parsed data in the array. This method does not require authorization.
     *
     * Parameters:
     *  csr - CSR code, length till 4000 symbols
     *
     * If no errors, following parameters will be returned:
     *  csrResult - array of decoded CSR data
     *  CN - FQDN csr is generated for
     *  C - country ISO format
     *  OU - department
     *  O - organization
     *  L - locality
     *  S - state
     *  version
     *  Email - email address
     *  dnsName(s) – additional SAN items
     *  Key Size – encryption key length
     *  md5 – md5 hash
     *  sha1 – sha1 hash
     *  success - success value (true)
     *
     * @param string $certificate
     * @return array
     */
    public function decodeCSR(string $certificate): array
    {

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'csr' => $certificate,
            ]];
        $request = new Request('POST', $this->url . '/decode?auth_key=' . $this->key,$headers);
        $res = $this->client->sendAsync($request,$options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The generateCSR method generates valid CSR code from the submitted values (2048bits).
     * Returns CSR code and CSR private key. This method does not require authorization.
     *
     * Parameters:
     *  csr_commonname - FQDN csr is generated for, can also be IP
     *  csr_organization - organization name
     *  csr_department - organization department
     *  csr_city - city
     *  csr_state - state
     *  csr_country - country in ISO format
     *  csr_email - email address
     *
     * If no errors, following parameters will be returned:
     *  csr_code - CSR code, needed for SSL generation
     *  csr_key - CSR private key, needed for SSL installation
     *  success - success value (true)
     *
     * @param array $params
     * @return array
     */
    public function generateCSR(array $params): array
    {

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $params
        ];
        $request = new Request('POST', $this->url . '/generate?auth_key=' . $this->key,$headers);
        $res = $this->client->sendAsync($request,$options)->wait();
        return $this->handleResponse($res);

    }

    /**
     * Data validation in CSR. This method does not require authorization.
     *
     * Parameters:
     *  csr - CSR code, length till 4000 symbols
     *
     * If no errors, following parameters will be returned:
     *  csrResult - array of decoded CSR data
     *  CN - FQDN csr is generated for
     *  C - country ISO format
     *  OU - department
     *  O - organization
     *  L - locality
     *  S - state
     *  version
     *  Email - email address
     *  dnsName(s) – additional SAN items
     *  Key Size – encryption key length
     *  md5 – md5 hash
     *  sha1 – sha1 hash
     *  success - success value (true)
     *
     * @param string $certificate
     * @return array
     */
    public function validateCSR(string $certificate): array
    {

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'csr' => $certificate,
            ]];
        $request = new Request('POST', $this->url . '/validate',$headers);
        $res = $this->client->sendAsync($request,$options)->wait();
        return $this->handleResponse($res);
    }


}
