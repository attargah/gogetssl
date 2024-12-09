<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class Orders extends GogetSSL
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
     * AddSSLOrder allows the creation of New SSL Order. Includes submission of information like: CSR code, validation method, Technical/Administrative contact details and Organization details.
     * Our system sends two (2) automatically emails once addSSLOrder method used:
     *  New Order Notification email will be sent to Account Owner E-mail, not the end-customer
     *  Generated PDF invoice
     * You can disable any notifications from Account Settings
     *
     * Parameters:
     *  product_id - Required. product ID, can be taken from getAllProducts method
     *  period - Required. Use months, example: 12/24
     *  csr - Required. Can be generated using generateCSR
     *  server_count - Required. Server Licenses, for Unlimited pass “-1”
     *  approver_email - Required. DCV approver email for the primary domain, can be taken from the list provided by getDomainEmails methods. This parameter must be used only if dcv_method pameter value is 'email'.
     *  approver_emails - A comma separated list of domain control validation e-mail addresses. One and only one e-mail must be provided for each additional domain provided in dns_names parameter. DCV e-mail address for the primary domain must not be included to the list. This parameter must be used only if dcv_method prameter value is 'email'.
     *  webserver_type - Required. Webserver type, can be taken from =getWebservers method
     *  dns_names – Required for SAN/UCC/Multi-Domain SSL, for the rest of products this parameter must not be provided. A comma separated list of additional domain names. The list must not contain the primary domain.
     *  admin_firstname - Required.
     *  admin_lastname - Required.
     *  admin_organization - required for OV/EV SSL certificates
     *  admin_addressline1 - required for OV/EV SSL certificates
     *  admin_phone - Required.
     *  admin_title - Required.
     *  admin_email - Required.
     *  admin_city - required for OV SSL certificates
     *  admin_country - required for OV SSL certificates
     *  admin_fax - required for OV SSL certificates
     *  admin_postalcode
     *  admin_region
     *  dcv_method – Required. Value of this specifies DCV method to be used. Possible values:: 'email', 'dns', 'http', 'https'. File-based validation is not available for wildcard domains.
     *  tech_firstname - Required .
     *  tech_lastname - Required .
     *  tech_organization - required for OV SSL certificates
     *  tech_addressline1
     *  tech_phone - Required.
     *  tech_title - Required.
     *  tech_email - Required.
     *  tech_city - required for OV/EV SSL certificates
     *  tech_country - required for OV/EV SSL certificates
     *  tech_fax
     *  tech_postalcode
     *  tech_region
     *  org_name - required for OV/EV SSL certificates
     *  org_division - required for OV/EV SSL certificates
     *  org_duns, DUNS number
     *  org_addressline1 - required for OV/EV SSL certificates
     *  org_city - required for OV/EV SSL certificates
     *  org_country - required for OV/EV SSL certificates
     *  org_fax
     *  org_phone - required for OV/EV SSL certificates
     *  org_postalcode - required for OV/EV SSL certificates
     *  org_region - required for OV SSL certificates
     *  org_lei - Legal Entity Identifier. Max length for org lei should be 20 characters
     *  signature_hash – hashing algorythm ('SHA2')
     *  unique_code - is the random value used during DCV process. Only numbers and alphabetic characters are allowed. The length of the string is from 15 to 20 characters. We will generate own random value if no values provided. At present Sectigo and GOGETSSL products support that feature. For Digicert we generate values on our side. Please check Products (custom_dcv_random_value 1/0) to understand which products do support custom random values.
     *  test - Y (if submitted, the order will not be processed)
     * Note: Quantity of items in the approver_emails list must be always equal to quantity of items in the dns_names list.
     *
     * If no errors, following parameters will be returned:
     *  product_id
     *  order_id - unique order ID
     *  invoice_id - unique invoice ID
     *  order_status - order status
     *  success - success code (true)
     *  order_amount - order amount
     *  currency - order currency
     *  tax - order tax if applicable
     *  tax_rate - order tax rate if applicable
     *   approver_method - data for selected DCV method, if order_status is "active"
     *      http - if requested dcv_method=http
     *          link
     *          filename
     *          content
     *      https - if requested dcv_method=https
     *          link
     *          filename
     *          content
     *      dns - if requested dcv_method=dns
     *          record
     *      email - if requested dcv_method = mail
     *          email
     *      san - array of SAN items
     *          san_name
     *          status
     *          status_description
     *          validation_method
     *          validation - data for selected DCV
     *
     * @param array $array
     * @return array
     */
    public function addSSLOrder(array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'orders/add_ssl_order?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);

    }

    /**
     * The reissueSSLOrder method reissues your SSL certificate. Most common reasons to reissue SSL:
     *  Lost Private Key, resubmit new CSR
     *  Change common name for your order (Comodo ONLY)
     *  Add/Change SAN items for Multi-Domain SSL certificate
     *
     * Parameters:
     *  order_id - your order ID returned in addSSLOrder method
     *  csr - CSR code for SSL certificate
     *  approver_email - approver email, can be taken from getDomainEmails methods
     *  approver_emails - A comma separated list of domain control validation e-mail addresses. One and only one e-mail must be provided for each additional domain. DCV e-mail address for the primary domain must not be included to the list.
     *  webserver_type - webserver type, can be taken from getWebservers method.
     *  dns_names – Required for SAN/UCC/Multi-Domain SSL. A comma separated list of additional domain names. The list must not contain the primary domain.
     *  dcv_method – Domain Control Validation method (email, http, dns).
     *  signature_hash – hashing algorythm ('SHA2').
     *  unique_code - is the random value used during DCV process. Only numbers and alphabetic characters are allowed. The length of the string is from 15 to 20 characters. We will generate own random value if no values provided. At present Sectigo and GOGETSSL products support that feature. For Digicert we generate values on our side. Please check Products (custom_dcv_random_value 1/0) to understand which products do support custom random values
     *
     * If no errors, following parameters will be returned:
     *  order_id - unique order ID
     *  order_status - order status (reissue)
     *  validation – Contains validation information in case of http and DNS DCV methods
     *  success - success code (true)
     *
     * @param array $array
     * @param int $orderID
     * @return array
     */
    public function reissueSSLOrder(array $array,int $orderID):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'orders/ssl/reissue/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);

    }

    /**
     * AddSSLRenewOrder is the exactly same method like addSSLOrder and should be used to renew SSL certificates.
     * You can start the renewal process not earlier than before 30-days of SSL expiration date.
     * CA (certificate authority) would add left days from original order to renew.
     * Renewal process requires all same steps of verification as done placing Original order.
     * Comodo CPAC and all CodeSigning SSL certificates do not support renewal features and are processed as new orders.
     *
     * Parameters:
     *  product_id - Required. product ID, can be taken from getAllProducts method
     *  period - Required. Use months, example: 12/24
     *  csr - Required. Can be generated using generateCSR
     *  server_count - Required. Server Licenses, for Unlimited pass “-1”
     *  approver_email - Required. DCV approver email for the primary domain, can be taken from the list provided by getDomainEmails methods. This parameter must be used only if dcv_method pameter value is 'email'.
     *  approver_emails - A comma separated list of domain control validation e-mail addresses. One and only one e-mail must be provided for each additional domain provided in dns_names parameter. DCV e-mail address for the primary domain must not be included to the list. This parameter must be used only if dcv_method prameter value is 'email'.
     *  webserver_type - Required. Webserver type, can be taken from =getWebservers method
     *  dns_names – Required for SAN/UCC/Multi-Domain SSL, for the rest of products this parameter must not be provided. A comma separated list of additional domain names. The list must not contain the primary domain.
     *  admin_firstname - Required.
     *  admin_lastname - Required.
     *  admin_organization - required for OV/EV SSL certificates
     *  admin_addressline1 - required for OV/EV SSL certificates
     *  admin_phone - Required.
     *  admin_title - Required.
     *  admin_email - Required.
     *  admin_city - required for OV SSL certificates
     *  admin_country - required for OV SSL certificates
     *  admin_fax - required for OV SSL certificates
     *  admin_postalcode
     *  admin_region
     *  dcv_method – Required. Value of this specifies DCV method to be used. Possible values:: 'email', 'dns', 'http', 'https'. File-based validation is not available for wildcard domains.
     *  tech_firstname - Required .
     *  tech_lastname - Required .
     *  tech_organization - required for OV SSL certificates
     *  tech_addressline1
     *  tech_phone - Required.
     *  tech_title - Required.
     *  tech_email - Required.
     *  tech_city - required for OV/EV SSL certificates
     *  tech_country - required for OV/EV SSL certificates
     *  tech_fax
     *  tech_postalcode
     *  tech_region
     *  org_name - required for OV/EV SSL certificates
     *  org_division - required for OV/EV SSL certificates
     *  org_duns, DUNS number
     *  org_addressline1 - required for OV/EV SSL certificates
     *  org_city - required for OV/EV SSL certificates
     *  org_country - required for OV/EV SSL certificates
     *  org_fax
     *  org_phone - required for OV/EV SSL certificates
     *  org_postalcode - required for OV/EV SSL certificates
     *  org_region - required for OV SSL certificates
     *  org_lei - Legal Entity Identifier. Max length for org lei should be 20 characters
     *  signature_hash – hashing algorythm ('SHA2')
     *  unique_code - is the random value used during DCV process. Only numbers and alphabetic characters are allowed. The length of the string is from 15 to 20 characters. We will generate own random value if no values provided. At present Sectigo and GOGETSSL products support that feature. For Digicert we generate values on our side. Please check Products (custom_dcv_random_value 1/0) to understand which products do support custom random values.
     *  test - Y (if submitted, the order will not be processed)
     * Note: Quantity of items in the approver_emails list must be always equal to quantity of items in the dns_names list.
     *
     * If no errors, following parameters will be returned:
     *  product_id
     *  order_id - unique order ID
     *  invoice_id - unique invoice ID
     *  order_status - order status
     *  success - success code (true)
     *  order_amount - order amount
     *  currency - order currency
     *  tax - order tax if applicable
     *  tax_rate - order tax rate if applicable
     *  approver_method - data for selected DCV method, if order_status is "active"
     *      http - if requested dcv_method=http
     *          link
     *          filename
     *          content
     *      https - if requested dcv_method=https
     *          link
     *          filename
     *          content
     *      dns - if requested dcv_method=dns
     *          record
     *      email - if requested dcv_method = mail
     *          email
     *      san - array of SAN items
     *          san_name
     *          status
     *          status_description
     *          validation_method
     *          validation - data for selected DCV
     *
     * @param array $array
     * @return array
     */
    public function addSSLRenewOrder(array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'orders/add_ssl_renew_order?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * Use that method to purchase more SAN items to your Multi-Domain SSL Certificate.
     * Use reissueSSLOrder method to reissue SSL with new SAN items.
     *
     * Parameters:
     *  order_id - ORDER ID to which your add extra SAN
     *  single_san_count - quantity of Single SAN items (optional)
     *  wildcard_san_count - quantity of Wildcard SAN item (optional)
     *
     * If no errors, following parameters will be returned:
     *  invoice_id - unique invoice ID
     *  order_id - unique order ID
     *  order_status
     *  order_amount
     *  currency
     *  tax
     *  tax_rate
     *  success: true
     *
     * @param array $array
     * @return array
     */
    public function addSSLSANOrder(array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'orders/add_ssl_san_order?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * Use that option to request cancellation/refund of any order. Please note, it takes from 2-48 hours to review cancellation request.
     *
     * Parameters:
     *  order_id - ID of the order to be canceled
     *  reason – Cancellation reason
     *
     * If no errors, following parameters will be returned:
     *  order_id - unique order ID
     *
     * @param array $array
     * @return array
     */
    public function cancelOrder(array $array):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'orders/cancel_ssl_order?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getCommonOrderDetails returns base information for all submitted certificate orders.
     * It is possible to filter result by passing "status" param with one of following values: "active", "processing", "expired", "revoked", "rejected".
     *
     * Parameters:
     *  status - active / processing / expired / revoked / rejected
     *
     * If no errors, array with following parameters will be returned:
     *  order_id - unique order ID
     *  status - order status (active, cancelled, expired, incomplete, new_order, unpaid, pending, processing, reissue, rejected,)
     *  valid_from
     *  valid_till
     *  common_name - domain from CSR
     *
     * @param string $status
     * @return array
     */
    public function getOrderCommonDetails(string $status = 'active'):array
    {
        $request = new Request('GET', $this->url.'orders?auth_key='.$this->key.'&status='.$status);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getOrdersStatuses returns statuses for the orders listed in cIds parameter and expiration date for certificates with status 'active'.
     *
     * Parameters:
     *  cIds - comma separated order IDs
     *
     * If no errors, following parameters will be returned:
     *  certificates - array of certificates
     *  order_id - unique order ID
     *  status - certificate status (active, cancelled, expired, incomplete, unpaid, pending, processing, reissue, rejected)
     *  expires - expiration date (only for certificates with status 'active')
     *  success - success value (true)
     *  time_stamp - server timestamp
     *
     * @param string $cIds
     * @return array
     */
    public function getOrderStatuses(string $cIds):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'cids' => $cIds
            ]
        ];
        $request = new Request('POST', $this->url . 'orders/statuses?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getOrderStatus returns detailed information for the order matching “order_id” parameter.
     * “order_id” is returned during addSSLOrder command.
     *
     * Parameters:
     *  order_id ID of the required order
     *
     * If no errors, following parameters will be returned:
     *  order_id - unique order ID
     *  partner_order_id - unique ID returned from vendor
     *  internal_id
     *  status - order status (active, cancelled, expired, incomplete, new_order, unpaid, pending, processing, reissue, rejected,)
     *  status_description
     *  dcv_status - 0/1 for not validated domains, 2 for validated
     *  product_id - product ID
     *  domain - FQDN from CSR
     *  total_domains - total domains count
     *  base_domain_count
     *  single_san_count
     *  wildcard_san_count
     *  validity_period - order validity period in months
     *  valid_from
     *  valid_till
     *  begin_date - subscription start date
     *  end_date - subscription end date
     *  csr_code - CSR code of certificate returned if status “active”
     *  ca_code - CA code of certificate id status “active”
     *  crt_code - Certificate code is status “active”
     *  server_count
     *  reissue - is certificate reissued (0/1)
     *  reissue_now - is certificate in reissue processing (0/1)
     *  renew - is certificate renewed (0/1)
     *  webserver_type
     *  upgrade
     *  approver_emails
     *  dcv_method - (http, https, dns, email)
     *  admin_addressline1
     *  admin_addressline2
     *  admin_city
     *  admin_country
     *  org_addressline3
     *  org_city
     *  org_country
     *  admin_fax
     *  admin_phone
     *  admin_postalcode
     *  admin_region
     *  admin_email
     *  admin_firstname
     *  admin_lastname
     *  admin_organization
     *  admin_title
     *  org_addressline3
     *  org_city
     *  org_country
     *  org_fax
     *  org_phone
     *  org_postalcode
     *  org_region
     *  org_lei
     *  tech_organization
     *  tech_addressline1
     *  tech_addressline2
     *  tech_addressline3
     *  tech_city
     *  tech_country
     *  tech_fax
     *  tech_phone
     *  tech_postalcode
     *  tech_region
     *  tech_email
     *  tech_firstname
     *  tech_lastname
     *  tech_title
     *  ssl_price
     *  ssl_period
     *  admin_msg
     *  free_ev_upgrade
     *  codesigning_inviteurl
     *  validation_description
     *  manual_check: 0; if 1, order is under brand validation
     *  pre_signing: 0; if 1, Comodo has too many orders and issuance of SSL delayed
     *  approver_method
     *  san - array of SAN items
     *  san_name
     *  validation_method -(http, https, dns, email)
     *  status - domain validation status (0 / 1 / 2)
     *  status_description description of domain validation status (not set for 0, processing for 1, validated for 2)
     *  success - success value (true)
     *  time_stamp
     *
     * @param int $orderID
     * @return array
     */
    public function getOrderStatus(int $orderID):array
    {
        $request = new Request('GET', $this->url.'orders/status/'.$orderID.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * This API allows you to initiate Certification Authority Authorization (CAA) record recheck in case the certificate issuance has been blocked due to failed CAA check, meaning the status of this certificate order is ‘PRE-SIGN FAILED!!!’ for the reason pointing to the failed CAA check.
     * Rate limit: 1 request per 10 minutes.
     *
     * @param int $orderID
     * @return array
     */
    public function recheckCAA(int $orderID):array
    {
        $request = new Request('GET', $this->url.'orders/ssl/recheck-caa/'.$orderID.'?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The “getUnpaidOrders” method returns the list of all unpaid orders.
     *
     * If no errors, following parameters will be returned:
     *  orders - an array of unpaid orders
     *  id - order ID
     *  total_price - order total price
     *  currency - order currency
     *  date - order date
     *
     * @return array
     */
    public function getUnpaidOrders():array
    {
        $request = new Request('GET', $this->url.'orders/list/unpaid?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getAllSSLOrders returns a list of all placed SSL orders and their statuses
     *
     * Parameters:
     *  limit
     *  offset
     *
     * If no errors, following parameters will be returned:
     *  orders - array of orders
     *  order_id - unique order ID
     *  status - certificate status (active, cancelled, expired, incomplete, unpaid, pending, processing, reissue, rejected)
     *  limit - current limit
     *  offset - current offset
     *  count - count of extracted records
     *  success - success value (true)
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllSSLOrders(int $limit=1000,int $offset = 1000):array
    {
        $request = new Request('GET', $this->url.'orders/ssl/all?auth_key='.$this->key.'&limit='.$limit.'&offset='.$offset);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     *
     * @param int $orderID
     * @return array
     */
    public function comodoClaimFreeEV(int $orderID):array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $request = new Request('POST', $this->url . 'orders/ssl/comodo_claim_free_ev/'.$orderID.'?auth_key=' . $this->key, $headers);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * The getTotalOrders method returns total amount of orders with status 'active'
     *
     * If no errors, following parameters will be returned:
     *  total_orders
     *  success - success value (true)
     *
     * @return array
     */
    public function getTotalOrders():array
    {
        $request = new Request('GET', $this->url.'account/total_orders?auth_key='.$this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

}
