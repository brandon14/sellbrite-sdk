<?php

declare(strict_types=1);

namespace TrollAndToad\Sellbrite\Test\Products;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use TrollAndToad\Sellbrite\Products\GetProduct;

class GetProductTest extends TestCase
{
    public function testGetProductSuccessfullyGetProducts()
    {
        // Get the stored credentials
        $accountToken = 'am2902ngt3Nn';
        $secretKey    = 'happy28bananas';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining JSON
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                200,
                [ 'Content-Type' => 'application/json' ],
                '[{
                    "id": 1,
                    "sku": "1903275",
                    "asin": null,
                    "condition": "used",
                    "brand": null,
                    "manufacturer": null,
                    "manufacturer_model_number": null,
                    "name": "Test Product",
                    "description": null,
                    "price": 0,
                    "cost": 0,
                    "package_length": 0,
                    "package_width": 0,
                    "package_height": 0,
                    "package_unit_of_length": "inches",
                    "package_weight": 0,
                    "package_unit_of_weight": "pounds",
                    "msrp": 0,
                    "category_name": "",
                    "features": [
                        "yellow",
                        "beautiful"
                    ],
                    "warranty": null,
                    "condition_note": null,
                    "upc": null,
                    "ean": null,
                    "isbn": null,
                    "gtin": null,
                    "gcid": null,
                    "epid": null,
                    "image_list": "",
                    "custom_attributes": {
                        "plate": "paper"
                    }
                }]'
            )
        );

        $page = 1;
        $limit = 100;
        $skuArr = ['1903275'];

        // Create a new instance of DeleteProduct
        $getProduct = new GetProduct($accountToken, $secretKey, $mockClient);

        // Send the request and get the response object
        $response = $getProduct->sendRequest($page, $limit, $skuArr);

        $responseJson = (string) $response->getBody();

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $responseJson,
            json_encode([
                [
                    'id' => 1,
                    'sku' => '1903275',
                    'asin' => null,
                    'condition' => 'used',
                    'brand' => null,
                    'manufacturer' => null,
                    'manufacturer_model_number' => null,
                    'name' => 'Test Product',
                    'description' => null,
                    'price' => 0,
                    'cost' => 0,
                    'package_length' => 0,
                    'package_width' => 0,
                    'package_height' => 0,
                    'package_unit_of_length' => 'inches',
                    'package_weight' => 0,
                    'package_unit_of_weight' => 'pounds',
                    'msrp' => 0,
                    'category_name' => '',
                    'features' => [
                        'yellow',
                        'beautiful'
                    ],
                    'warranty' => null,
                    'condition_note' => null,
                    'upc' => null,
                    'ean' => null,
                    'isbn' => null,
                    'gtin' => null,
                    'gcid' => null,
                    'epid' => null,
                    'image_list' => '',
                    'custom_attributes' => [
                        'plate' => 'paper'
                    ]
                ]
            ])
        );
    } // End public function testPostProductSuccessfullyPostAProduct

    public function testGetProductTestHigherLimitAmount()
    {
        // Get the stored credentials
        $accountToken = 'am2902ngt3Nn';
        $secretKey    = 'happy28bananas';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining JSON
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                200,
                [ 'Content-Type' => 'application/json' ],
                '[{
                    "id": 1,
                    "sku": "1903275",
                    "asin": null,
                    "condition": "used",
                    "brand": null,
                    "manufacturer": null,
                    "manufacturer_model_number": null,
                    "name": "Test Product",
                    "description": null,
                    "price": 0,
                    "cost": 0,
                    "package_length": 0,
                    "package_width": 0,
                    "package_height": 0,
                    "package_unit_of_length": "inches",
                    "package_weight": 0,
                    "package_unit_of_weight": "pounds",
                    "msrp": 0,
                    "category_name": "",
                    "features": [
                        "yellow",
                        "beautiful"
                    ],
                    "warranty": null,
                    "condition_note": null,
                    "upc": null,
                    "ean": null,
                    "isbn": null,
                    "gtin": null,
                    "gcid": null,
                    "epid": null,
                    "image_list": "",
                    "custom_attributes": {
                        "plate": "paper"
                    }
                }]'
            )
        );

        $page = 1;
        $limit = 555;
        $skuArr = ['1903275'];

        // Create a new instance of DeleteProduct
        $getProduct = new GetProduct($accountToken, $secretKey, $mockClient);

        // Send the request and get the response object
        $response = $getProduct->sendRequest($page, $limit, $skuArr);

        $responseJson = (string) $response->getBody();

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $responseJson,
            json_encode([
                [
                    'id' => 1,
                    'sku' => '1903275',
                    'asin' => null,
                    'condition' => 'used',
                    'brand' => null,
                    'manufacturer' => null,
                    'manufacturer_model_number' => null,
                    'name' => 'Test Product',
                    'description' => null,
                    'price' => 0,
                    'cost' => 0,
                    'package_length' => 0,
                    'package_width' => 0,
                    'package_height' => 0,
                    'package_unit_of_length' => 'inches',
                    'package_weight' => 0,
                    'package_unit_of_weight' => 'pounds',
                    'msrp' => 0,
                    'category_name' => '',
                    'features' => [
                        'yellow',
                        'beautiful'
                    ],
                    'warranty' => null,
                    'condition_note' => null,
                    'upc' => null,
                    'ean' => null,
                    'isbn' => null,
                    'gtin' => null,
                    'gcid' => null,
                    'epid' => null,
                    'image_list' => '',
                    'custom_attributes' => [
                        'plate' => 'paper'
                    ]
                ]
            ])
        );
    } // End public function testGetProductTestHigherLimitAmount

    public function testGetProductBadCredentialsThrowException()
    {
        // Get the stored credentials
        $accountToken = '';
        $secretKey    = '';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining JSON
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                401,
                [ 'Content-Type' => 'application/json' ],
                'HTTP Basic: Access denied.'
            )
        );

        $page = 1;
        $limit = 100;
        $skuArr = ['1903275'];

        // Create a new instance of DeleteProduct
        $getProduct = new GetProduct($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $response = $getProduct->sendRequest($page, $limit, $skuArr);
    } // End public function testGetProductBadCredentialsThrowException

    public function testGetProductThrowDefaultException()
    {
        // Get the stored credentials
        $accountToken = 'M9902nig02';
        $secretKey    = '22038hgdlahngo234';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining JSON
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                405,
                [ 'Content-Type' => 'application/json' ],
                'This is the default error.'
            )
        );

        $page = 1;
        $limit = 100;
        $skuArr = ['1903275'];

        // Create a new instance of DeleteProduct
        $getProduct = new GetProduct($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $response = $getProduct->sendRequest($page, $limit, $skuArr);
    } // End public function testGetProductBadCredentialsThrowException
} // End class GetProductTest
