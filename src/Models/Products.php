<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class Products extends GogetSSL
{

    private string $url;

    private client $client;


    public function __construct($config)
    {

        parent::__construct($config);
        $this->url = $this->config['url'] . '/products';
        $this->client = new Client();
    }

    /**
     * The getAllProducts method returns a detailed list of all available SSL certificate products.
     *
     * If no errors, following parameters will be returned:
     *  products - an array of available products
     *  id - unique ID of the product to be used with addSSLOrder method
     *  name - product name
     *  periods - array of possible periods in months
     *  organization – is organization validation required (yes/no)
     *  wildcard - is wildcard common name supported (yes/no)
     *  unlimited_servers - is the product for unlimited servers (yes/no)
     *  is_multidomain – is product multidomain (yes/no)
     *  wildcard_san_enabled - is wildcard SANs supported (yes/no)
     *  multidomains_included – total number of included SAN items
     *  single_san_included - included Single SANs
     *  wildcard_san_included - included Wildcard SANs
     *  multidomains_maximum – max allowed SAN quantity
     *  dcv_email - is email validation supported (true/false)
     *  dcv_dns - is DNS validation supported (true/false)
     *  dcv_http - is HTTP validation supported (true/false)
     *  dcv_https - is HTTPS validation supported (true/false)
     *  success - success value (true)
     *
     * @return array
     */
    public function getAllProducts(): array
    {
        $request = new Request('GET', $this->url . '?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }


    /**
     * The getAllProductPrices returns list of available product prices.
     *
     * If no errors, following parameters will be returned:
     *  product_prices - an array of product prices for a specific period
     *  price - base price for this period.
     *  period - possible term of product
     *  id - unique ID of the product
     *
     * @return array
     */
    public function getAllProductPrices(): array
    {
        $request = new Request('GET', $this->url . '/all_prices?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getProductDetails method returns detailed information about requested product.
     *
     * Parameters:
     *  product_id ID of the required product
     *
     * If no errors, following parameters will be returned:
     *  product_name
     *  product_type - type of certificate validation (DV/EV/OV)
     *  product_id
     *  product_brand
     *  product_description
     *  product_agreement
     *  product_organization - is organization validation required (yes/no)
     *  product_wildcard - is wildcard common name supported (yes/no)
     *  product_unlimited_servers
     *  product_is_multidomain - are multiple domains supported (yes/no)
     *  product_multidomains_included - count of SANs included
     *  product_single_san_included - count of Single SANs included
     *  product_wildcard_san_included - count of Wildcard SANs included
     *  product_multidomains_maximum - max. allowed SAN count
     *  product_san_wildcard - is Wildcard SANs supported (yes/no)
     *  product_dcv_email - is email validation supported (true/false)
     *  product_dcv_dns - is DNS validation supported (true/false)
     *  product_dcv_http - is HTTP validation supported (true/false)
     *  product_dcv_https - is HTTPS validation supported (true/false)
     *  recheck_caa
     *  refund_days
     *  terms - the maximum term for product im months
     *  terms_min - the minimum term for product in months
     *  site_seal
     *  change_main_domain
     *  ssl_warranty
     *  estimate
     *  ip_allowed
     *  free_reissues
     *  product_prices - the array of product prices
     *      period - product validity period in months (12,24,36,48,60)
     *      price -- product partner price in default account currency
     *      id
     *  product_san_prices - the array for Single SAN prices ((only for product_is_multidomain products)
     *      period
     *      price
     *      id
     *  product_wildcard_san_prices - the array for Wildcard SAN prices (only for product_san_wildcard products)
     *      period
     *      price
     *      id
     *  success - success value (true)
     *
     * @param int $productID
     * @return array
     */
    public function getProductDetails(int $productID): array
    {
        $request = new Request('GET', $this->url . '/details/' . $productID . '?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getProductPrice method returns list of prices of required product for periods.
     *
     * Parameters:
     *  product_id ID of the required product
     *
     * If no errors, following parameters will be returned:
     *  product_price
     *      price - base price for this period.
     *      period - possible term of product
     *      id - unique ID of the product
     *
     * @param int $productID
     * @return array
     */
    public function getProductPrice(int $productID): array
    {
        $request = new Request('GET', $this->url . '/price/' . $productID . '?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getProductAgreement method returns Agreement of requested product
     *
     * Parameters:
     *  product_id ID of the required product
     *
     * If no errors, following parameters will be returned:
     *  product_id
     *  product_agreement
     *  success - success value (true)
     *
     * @param int $productID
     * @return array
     */
    public function getProductAgreement(int $productID): array
    {
        $request = new Request('GET', $this->url . '/agreement/' . $productID . '?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getSslProducts method returns a detailed list of all available SSL certificate products.
     *
     * If no errors, following parameters will be returned:
     *  products
     *  id - unique ID of the product to be used with addSSLOrder method
     *  brand - product brand
     *  product - product name
     *  max_period - the maximal period of product in months
     *  san_enabled - is product supporting Single SANs (1/0)
     *  wildcard_san_enabled - is product supporting Wildcard SANs
     *  product_type - type of product validation (domain / business / extended)
     *  unlimited_licencing - is the product for unlimited servers (1/0)
     *  wildcard_enabled - is wildcard common name supported (1/0)
     *  claim_ev_enabled
     *  trust_logo
     *  org_required - is organization validation required (1/0)
     *  dcv_email - is email validation supported (true/false)
     *  dcv_dns - is DNS validation supported (true/false)
     *  dcv_http - is HTTP validation supported (true/false)
     *  dcv_https - is HTTPS validation supported (true/false)
     *  recheck_caa
     *  san_max - the maximum amount of SAN items (only for SAN enabled products)
     *  prices - product prices in default account currency
     *      12
     *      ... - base price for each period
     *      60
     *      vendor - vendor prices for each period
     *      san - Single SAN prices for each period (only for san_enabled products)
     *      wildcard_san - Wildcard SAN prices for each period (only for wildcard_san_enabled products)
     *  success - success value (true)
     *
     * @return array
     */
    public function getSslProducts(): array
    {
        $request = new Request('GET', $this->url . '/ssl?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getProductDetails method returns detailed information about requested product.
     *
     * Parameters:
     *  product_id ID of the required product
     *
     * If no errors, following parameters will be returned:
     *  product
     *      id - unique ID of the product to be used with addSSLOrder method
     *      brand - product brand
     *      product - product name
     *      max_period - the maximal period of product in months
     *      san_enabled - is product supporting Single SANs (1/0)
     *      wildcard_san_enabled - is product supporting Wildcard SANs
     *      product_type - type of product validation (domain / business / extended)
     *      unlimited_licencing - is the product for unlimited servers (1/0)
     *      wildcard_enabled - is wildcard common name supported (1/0)
     *      claim_ev_enabled
     *      trust_logo
     *      org_required - is organization validation required (1/0)
     *      dcv_email - is email validation supported (true/false)
     *      dcv_dns - is DNS validation supported (true/false)
     *      dcv_http - is HTTP validation supported (true/false)
     *      dcv_https - is HTTPS validation supported (true/false)
     *      recheck_caa
     *      san_max - the maximum amount of SAN items (only for SAN enabled products)
     *      prices - product prices in default account currency
     *          12
     *          ... - base price for each period
     *          60
     *          vendor - vendor prices for each period
     *          san - Single SAN prices for each period (only for san_enabled products)
     *          wildcard_san - Wildcard SAN prices for each period (only for wildcard_san_enabled products)
     *  success - success value (true)
     *
     * @param int $productID
     * @return array
     */
    public function getSslProduct(int $productID) : array
    {
        $request = new Request('GET', $this->url . '/ssl/' . $productID . '?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }




}
