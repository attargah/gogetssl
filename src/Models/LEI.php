<?php

namespace Attargah\GogetSSL\Models;

use Attargah\GogetSSL\GogetSSL;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class LEI extends GogetSSL
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
     * Placing an order for LEI products
     *
     * Parameters:
     *  productId - Required. Product ID, can be taken from getAllProducts method.
     *  legalName - Required.String. Name of the Legal Entity noting that accuracy here helps the overall process flow and accuracy of any potential duplicate test. e.g. ABC Limited
     *  registrationAuthorityEntityId - Required. String. Company Number for the Legal Entity noting that accuracy here helps the overall process flow and accuracy of any potential duplicate test. e.g. 68678678 - Tip - don't forget to ensure any leading '0's are added - this is common in the UK.
     *  legalJurisdiction - Required. String. Format of ISO 3166-2. A supported legal jurisdiction is required. e.g. DK or US-CA for California the United States
     *  firstName - Required. String. The First Name(s) of the Signing Authority with the responsibility/authority to request and approve the creation of an LEI e.g. Peter
     *  lastName - Required. String. The Last Name of the Signing Authority e.g. Anderson
     *  isLevel2DataAvailable - Required. 1 or 0. A Boolean value - If the Legal Entity consolidates accounts with parental entities, then Level 2 data will be required.
     *  legalPostal - Required. String.
     *  legalfirstAddressLine - Required. String
     *  legalCountry - Required. String. ISO code format.
     *  legalCity - Required. String.
     *  multiYearSupport - Required. Enum - 1,2,3,4,5.
     *  transfer - Required field. 1 or 0
     *
     * Optional Parameters:
     *  isLevel2DataConsolidate - Optional. 1 or 0.
     *  isLevel2DataUltimate - Optional. 1 or 0.
     *  incorporationDate - Optional.Date format yyyy-mm-dd.
     *  legalState - Optional. String.
     *  hqCity - Optional. String.
     *  hqState - Optional. String.
     *  hqCountry - Optional. String.
     *  hqfirstAddressLine - Optional. String.
     *  hqPostal - Optional. String.
     *
     * If no errors, following parameters will be returned:
     *  product_id - product id
     *  order_number - unique order UIID
     *  order_id - unique order ID
     *  lie_id - unique lei ID
     *  order_amount - order amount
     *  currency - order currency
     *  tax - order tax if applicable
     *  tax_rate - order tax rate if applicable
     *  success - success code (true)
     *  invoice_num - unique invoice UIID (Optional)
     *  invoice_id - unique invoice ID (Optional)
     *
     * @param array $array
     * @param bool $is_test
     * @return array
     */
    public function createNewLEI(array $array,bool $is_test = false): array
    {
        $test_param = "";
        if ($is_test) {
            $test_param = "&test=1";
        }
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => $array
        ];
        $request = new Request('POST', $this->url . 'orders/lei/create?auth_key=' . $this->key . $test_param, $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);

    }

    /**
     * This API call is used to query supported jurisdictions and confidence levels.
     *  Group A is fully automated including signing authority verification resulting in rapid, efficient LEI issuance
     *  Group B is verification time 1 hour - 36 hours
     *  Group C is a manually processed jurisdiction requiring manual verification of data on the business registry
     *
     * If no errors, following parameters will be returned:
     *  success - success value (true)
     *  jurisdictions - Required. Array. List supported countries and states. Fields - code, group, notes.
     *
     * @return array
     */
    public function getLEIJurisdictions(): array
    {
        $request = new Request('GET', $this->url . '/lei/jurisdictions?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * Confirm LEI Data Quality. This API call is used to confirm the LE-RD data quality status before an LEI can be issued.
     * Set the correct 'order_id' in the URL before making an API call.
     *
     * Parameters:
     *  confirm - Required. 0 or 1.
     *
     * If no errors, following parameters will be returned:
     *  order_status - Required. Enum: "rejected" or "processing"
     *  success - Boolean.
     *
     * @param string $confirm
     * @param int $orderID
     * @return array
     */
    public function confirmLEIDataQuality(string $confirm,int $orderID): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'confirm' => $confirm
            ]];

        $request = new Request('POST', $this->url . 'lei/confirm/'.$orderID.'?auth_key=' . $this->key , $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * This call is used to check the LEI Order Status. Both 'LEI - Create New LEI' and 'LEI - Import Existing LEI' are supported. The Access Token from 'Authentication - Request Access Token' is required to submit the request.
     *
     * Parameters:
     *  order_id
     *
     * If no errors, following parameters will be returned: If no errors in request following parameters will be returned:
     *  "product_id" - Required. Product ID, can be taken from getAllProducts method.
     *  "confidence_level" - Optional.      | Plain Text
     *  "le_number" - LEI code              | Plain Text
     *  "valid_from" - Date                 | Plain Text
     *  "valid_till" - Date                 | Plain Text
     *  "legal_address" - Optional.         | Plain Text
     *  "headquarters_address" - Optional.  | Plain Text
     *  "success" - success code (true)     | Plain Text
     *
     *
     * @param int $orderID
     * @return array
     */
    public function getLeiStatus(int $orderID): array
    {
        $request = new Request('GET', $this->url . '/lei/status'.$orderID.'?auth_key=' . $this->key);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }

    /**
     * This API is used to initiate the renewal process which move the ‘nextRenewalDate’ forward by 1 year.
     * Renewal is the process to verify all Level 1 and Level 2 data is correct to maintain the integrity of the GLEIS. This API call is generally used once per calendar year per LEI.
     * Multi-year LEIs which have LE-RR reporting exceptions are excluded as they will automatically renew during the contract period.
     *
     * Parameters:
     *  isLevel1DataSame - A Boolean value – to agree that the current LE-RD (Level 1) data is the same as the previous year
     *
     * Optional Parameters:
     *  firstName - Required. String. The First Name(s) of the Signing Authority with the responsibility/authority to request and approve the creation of an LEI e.g. Peter
     *  lastName - Required. String. The Last Name of the Signing Authority e.g. Anderson
     *  multiYearSupport - Required. Enum - 1,2,3,4,5.
     *
     * If no errors, following parameters will be returned:
     *  product_id - product id
     *  order_number - unique order UIID
     *  order_id - unique order ID
     *  lie_id - unique lei ID
     *  order_amount - order amount
     *  currency - order currency
     *  tax - order tax if applicable
     *  tax_rate - order tax rate if applicable
     *  success - success code (true)
     *  invoice_num - unique invoice UIID (Optional)
     *  invoice_id - unique invoice ID (Optional)
     *  lei_number - LEI Number for the Legal Entity. e.g. 98450024FD4543302F20
     *
     * @param int $orderID
     * @param array $array
     * @return array
     */
    public function renewLEI(int $orderID,array $array): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'confirm' => $array
            ]];

        $request = new Request('POST', $this->url . 'orders/lei/renew/'.$orderID.'?auth_key=' . $this->key , $headers);
        $res = $this->client->sendAsync($request, $options)->wait();
        return $this->handleResponse($res);
    }

    /**
     * LEI number or company name search will reveal the information contained within a Legal Entity Identifier.
     * It can be used to check the validity of an LEI number or ensure that any information held on an entity is up to date.
     *
     * Parameters:
     *  query - The name of the company or lei code
     *
     * If no errors, following parameters will be returned:
     *  "result" - array of objects entities
     *  "leiNumber" - lei code,
     *  "nextRenewalDate": Date,
     *  "entityStatus": entity status,
     *  "leiStatus": lei status,
     *  "legalName": Name of the Legal Entity noting that accuracy here helps the overall process flow and accuracy of any potential duplicate test. e.g. ABC Limited,
     *  "registrationAuthorityEntityId": Company Number for the Legal Entity,
     *  "entityLegalFormCode": ISO standard 20275 ‘Financial Services – Entity Legal Forms (ELF)’,
     *  "legalJurisdiction": Format of ISO 3166-2,
     *  "legalState": state,
     *  "legalCountry": ISO code,
     *  "legalCity": city,
     *  "legalPostal": postal code,
     *  "legalfirstAddressLine": address,
     *  "hqState": headquarters state,
     *  "hqCountry": ISO code,
     *  "hqCity": headquarters city,
     *  "hqPostal": headquarters postal code,
     *  "hqfirstAddressLine": headquarters address
     *  "success" - success code (true)
     *
     * @param string $query
     * @return array
     */
    public function leiLookup(string $query): array
    {
        $request = new Request('GET', $this->url . '/lei/lookup?auth_key=' . $this->key.'&query='.$query);
        $res = $this->client->sendAsync($request)->wait();
        return $this->handleResponse($res);
    }


}
