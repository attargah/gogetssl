# GogetSSL API integration for Laravel framework

[![Latest Version on Packagist](https://img.shields.io/packagist/v/attargah/gogetssl.svg?style=flat-square)](https://packagist.org/packages/attargah/gogetssl)
[![Tests](https://img.shields.io/github/actions/workflow/status/attargah/gogetssl/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/attargah/gogetssl/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/attargah/gogetssl.svg?style=flat-square)](https://packagist.org/packages/attargah/gogetssl)

This is a package created for Laravel Framework that allows you to connect with GogetSSL API.

## Installation

You can install the package via composer:

```bash
composer require attargah/gogetssl
```

if you get Undefined Class Error

```bash
composer dump-autoload
```

If you are using an older version of Laravel or have Auto-Discovery disabled, add the following code to the 'aliases'
section of the config/app.php file to use it everywhere;

```bash
'GogetSSL' => Attargah\GogetSSL\Facades\GogetSSL::class,
```

## Configuration

After adding it to your project, you need to add and adjust the following lines in the .env file:

```bash
GOGETSSL_USERNAME = "demo@gogetssl.com" // username
GOGETSSL_PASSWORD = "************************" // Generated Password 
GOGETSSL_API_URL = "https://my.gogetssl.com/api/" //API URL
```

## Usage

You need to include the package in the Controller you will use:

```php
use Attargah\GogetSSL\Facades\GogetSSL;
```

#### Functions

Models and Functions are based on the Postman documentation.

```php
/* Products */
GogetSSL::Products()->getAllProducts();                                     //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#a4a8873b-8715-4d86-bc04-57913cb6c10d  
GogetSSL::Products()->getAllProductPrices();                                //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#179c0821-73d1-4f12-8c4b-7e166a5b3f43
GogetSSL::Products()->getProductDetails($productID);                        //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#701b8bba-4e2b-4f25-bc93-7be15049ac78
GogetSSL::Products()->getProductPrice($productID);                          //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#0ecc7139-f512-4d23-94e0-188ad44e8525
GogetSSL::Products()->getProductAgreement($productID);                      //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#5db0e162-07dc-4c3f-af06-f27d813749a3
GogetSSL::Products()->getSslProducts();                                     //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#f00abae2-3774-4676-a98d-cd26eeac91ab
GogetSSL::Products()->getSslProduct($productID);                            //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#fdd0c1d8-7f3c-468c-84c0-b0ea6d0a0a5b

/* CSR */
GogetSSL::CSR()->decodeCSR($csrCertificate);                                //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#bb29e18a-e5cd-419e-bd42-43279c5a5a3a
GogetSSL::CSR()->generateCSR($csrParams);                                   //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#db47bf94-ad86-4b37-bccb-6ef39dd55aa8
GogetSSL::CSR()->validateCSR($csrCertificate);                              //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#ab83bed7-fec9-4054-8a01-334f35980466

/* DCV */
GogetSSL::DCV()->getDomainAlternative($csrCertificate);                     //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#30e48ab6-63ec-45c9-a8f7-1ea5c8fe35ed
GogetSSL::DCV()->getDomainEmails($domain);                                  //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#f1cde256-f8f2-48f1-b06e-7e2e2cfe1ffb
GogetSSL::DCV()->getDomainEmailsForGeotrust($domainForGeo);                 //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#d69cd050-99d2-4a10-a04e-0859768e1379                    
GogetSSL::DCV()->domainGetFromWhois($domain);                               //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#84ff0ed3-6054-4160-8488-d59b3ad5964a

/* WebServers */
GogetSSL::WebServers()->getWebServers($supplier_id);                        //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#fd96510b-0db7-41aa-8274-8e3179cbbee8

/* Account */
GogetSSL::Account()->getAccountDetails();                                   //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#e4c77858-bac5-479a-92e2-ef41d32dfbcb
GogetSSL::Account()->getAccountBalance();                                   //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#f49761a1-f725-46fa-9986-5803753de0db

/* LEI */
GogetSSL::LEI()->createNewLEI($params,$is_test);                            //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#07e0fa0c-bbd7-4172-b6bb-44e2fed2b3e0
GogetSSL::LEI()->getLEIJurisdictions();                                     //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#f9335eab-b1b9-4f97-a0e4-a5102e974bf6
GogetSSL::LEI()->confirmLEIDataQuality($confirm,$orderID);                  //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#38801076-68ef-4fff-842a-7741aef3c732
GogetSSL::LEI()->getLeiStatus($orderID);                                    //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#4c01e27b-dfb1-41ad-8998-4af18bc3eaa1
GogetSSL::LEI()->renewLEI($orderID,$confirmArray);                          //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#727e69d0-5531-443e-aa4b-d3b6b46083e5
GogetSSL::LEI()->leiLookup($query);                                         //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#2d6eae56-3200-4e52-b5e6-bc27a13be087

/* ORDERS */
GogetSSL::Orders()->addSSLOrder($params);                                   //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#e4c071bd-56f3-4046-be83-f7e3bb7b7750
GogetSSL::Orders()->reissueSSLOrder($params,$orderID);                      //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#09180357-0a48-45eb-93be-d11fa4629afe
GogetSSL::Orders()->addSSLRenewOrder($params);                              //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#83c11ed2-20a9-4d11-9d05-4224d0948c6c
GogetSSL::Orders()->addSSLSANOrder($params);                                //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#5a7d1bf5-a61d-41db-962c-140bdb29f092
GogetSSL::Orders()->cancelOrder($params);                                   //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#78cdcd56-60ad-48fd-92d9-1b171fd725c1
GogetSSL::Orders()->getOrderCommonDetails($status);                         //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#529f4b6b-6069-441b-806c-9f55104d9a11
GogetSSL::Orders()->getOrderStatuses($cIds);                                //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#158300b6-9b8b-4218-a021-7ccb9b2801c9
GogetSSL::Orders()->getOrderStatus($orderID);                               //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#e99c187c-bebf-433a-ae21-84abfba4e93e
GogetSSL::Orders()->recheckCAA($orderID);                                   //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#f2daa479-dff3-4804-bda4-2e71cfecb816
GogetSSL::Orders()->getUnpaidOrders();                                      //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#b0146cdf-6cf5-4c50-ac9e-d1adca398f5b
GogetSSL::Orders()->getAllSSLOrders($limit,$offset);                        //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#33551d5b-1638-4f9f-9074-c814ed7123c2
GogetSSL::Orders()->getTotalOrders();                                       //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#8bd574af-d002-477a-9b01-b7ac4e7a979e

/* Validation */
GogetSSL::Validation()->changeDomainsValidationMethod($orderID,$params);    //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#b1d22f34-7693-4386-a672-5f67cdba23aa
GogetSSL::Validation()->changeValidationMethod($orderID,$params);           //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#49cc48c6-98f1-4ef3-92f8-8a610a3e3349
GogetSSL::Validation()->changeValidationEmail($orderID,$params);            //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#2c0d8c0d-327a-4109-ba67-88c1632c5cce
GogetSSL::Validation()->resendValidationEmail($orderID);                    //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#68e72da6-1c28-41d7-b172-ce17dfe13948
GogetSSL::Validation()->changeDcv($orderID,$params);                        //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#6b9bcc34-88d3-4cb3-9b3a-d0d90cb4ea8c
GogetSSL::Validation()->revalidate($orderID,$domain);                       //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#aee8aa8b-4afd-472e-9e54-b2c65ba1861c
GogetSSL::Validation()->resend($orderID,$domain);                           //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#7387b276-6d9a-445a-9ec2-4b4fca59d563

/* Invoices */
GogetSSL::Invoices()->getAllInvoices();                                     //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#314be70b-e5d6-408c-aa29-237d39139c83
GogetSSL::Invoices()->getUnpaidInvoices();                                  //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#20f976c4-04ea-4d81-a5f8-6ca68ed55922
GogetSSL::Invoices()->getOrderInvoice($orderID);                            //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#b47999fe-869a-4791-a197-daead0327e71
GogetSSL::Invoices()->getInvoiceListByPeriod($dateFrom,$dateTill);          //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#9b73716b-e07f-4a32-8dd5-ffcf38900e13    
GogetSSL::Invoices()->getInvoiceDetails($invoiceID);                        //                      https://documenter.getpostman.com/view/5593375/T1LHFp7m#14824d24-7978-422c-8fe5-aaa7c5fb4d06



```

#### Returns
This is the return you should get if there is no problem with your operation

```php
Array
(
[success] => true // if operation success
[error] => false // if operation fail
[body] => stdClass Object // GogetSSL Response
[status] => 200 // Response Status
)
```

## Testing

```bash
php artisan test
```
or
```bash
vendor/bin/pest
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [attargah](https://github.com/attargah configure)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
