<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class DCV extends GogetSSL
{
    private string $url;

    private client $client;


    public function __construct($config)
    {
        parent::__construct($config);
        $this->url = $this->config['url'] . '/tools';
        $this->client = new Client();
    }

    /**
     * This API method provides validation information for alternative DCV methods.
     * This endpoint can only be used for ssl certificates of the GoGetSSL and Sectigo brands.
     * Current method does not provide Unique Value
     *
     * Parameters:
     *  csr – CSR code for which the validation information must be provided.
     *
     * If no errors, following parameters will be returned:
     *  HTTP: { "http": { "link": "http://domain.tld/.well-known/pki-validation/37D0C93EE263FF9EEEA799215A9C3225.txt", "filename": "37D0C93EE263FF9EEEA799215A9C3225.txt", "content": "D30C576BF9EB30A75211CB799848EE5CABFCE3D8EE13212A57C9B7E42EF9BAA2\r\nCOMODOCA.COM" } }
     *  HTTPS: { "https": { "link": "http://domain.tld/.well-known/pki-validation/37D0C93EE263FF9EEEA799215A9C3225.txt", "filename": "37D0C93EE263FF9EEEA799215A9C3225.txt", "content": "D30C576BF9EB30A75211CB799848EE5CABFCE3D8EE13212A57C9B7E42EF9BAA2\r\nCOMODOCA.COM" } }
     *  DNS: { "dns": { "record": "_37D0C93EE263FF9EEEA799215A9C3225.domain.tld CNAME d30c576bf9eb30a75211cb799848ee5c.abfce3d8ee13212a57c9b7e42ef9baa2.comodoca.com" } }
     *
     * @param string $certificate
     * @return array
     */
    public function getDomainAlternative(string $certificate): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'csr' => $certificate,
            ]];
        $request = new Request('POST', $this->url . '/domain/alternative?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getDomainEmails method returns an array of valid approver email addresses for specified “domain” parameter.
     * This method does not perform a WHOIS email lookup.
     *
     * Parameters:
     *  domain - valid FQDN
     *
     * If no errors, following parameters will be returned:
     *  ComodoApprovalEmails - array of valid email addresses
     *  GeotrustApprovalEmails - array of valid email addresses
     * Historically this method returns 2 arrays, but they are completely identical and not vendor specific.
     *
     * @param string $domain
     * @return array
     */
    public function getDomainEmails(string $domain): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'domain' => $domain,
            ]];
        $request = new Request('POST', $this->url . '/domain/emails?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);

    }

    /**
     * The getDomainEmailsForGeotrust method returns an array of valid approver email addresses for specified “domain”.
     *
     * Parameters:
     *  domain - valid FQDN
     *
     * If no errors, following parameters will be returned:
     *  getDomainEmailsForGeotrust - array of valid email addresses
     *
     * @param string $domain
     * @return array
     */
    public function getDomainEmailsForGeotrust(string $domain): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'domain' => $domain,
            ]];
        $request = new Request('POST', $this->url . '/domain/emails/geotrust?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The domainGetFromWhois method returns an array of valid approver email addresses for specified “domain” parameter from Comodo API.
     *
     * Parameters:
     *  domain - valid FQDN
     *
     * If no errors, following parameters will be returned:
     *  ComodoApprovalEmails - array of valid email addresses from Comodo API
     *  GeotrustApprovalEmails - array of valid email addresses from Comodo AP
     * WHOIS emails not always available due to multiple issues
     *
     * @param string $domain
     * @return array
     */
    public function domainGetFromWhois(string $domain): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'domain' => $domain,
            ]];
        $request = new Request('POST', $this->url . '/domain/domain_get_from_whois?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);

    }

}
