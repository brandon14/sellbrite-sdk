<?php

/**
 *
 * This file is part of the trollandtoad/sellbrite package.
 *
 * Copyright (c) 2019 TrollAndToad.com
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 */

declare(strict_types=1);

namespace TrollAndToad\Sellbrite\Test\Unit\Products;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use TrollAndToad\Sellbrite\Products\PostProduct;

class PostProductTest extends TestCase
{
    public function testPostProductSuccessfullyPostAProduct()
    {
        // Get the stored credentials
        $accountToken = 'am2902ngt3Nn';
        $secretKey = 'happy28bananas';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining JSON
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                '{
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
                }'
            )
        );

        $sku = '1903275';

        $productInfoArr = [
            'name'                      => 'Test Product',
            'asin'                      => null,
            'condition'                 => 'used',
            'brand'                     => null,
            'manufacturer'              => null,
            'manufacturer_model_number' => null,
            'description'               => null,
            'price'                     => 0.00,
            'cost'                      => 0.00,
            'package_length'            => 0,
            'package_width'             => 0,
            'package_height'            => 0,
            'package_unit_of_length'    => 'inches',
            'package_weight'            => 0,
            'package_unit_of_weight'    => 'pounds',
            'mrsp'                      => 0,
            'category_name'             => null,
            'features'                  => [
                'yellow',
                'beautiful',
            ],
            'warranty'                  => null,
            'condition_note'            => null,
            'upc'                       => null,
            'ean'                       => null,
            'isbn'                      => null,
            'gtin'                      => null,
            'epid'                      => null,
            'image_list'                => [],
            'custom_attributes'         => [
                'plate' => 'paper',
            ],
        ];

        // Create a new instance of PostProduct
        $postProduct = new PostProduct($accountToken, $secretKey, $mockClient);

        // Send the request and get the response object
        $response = $postProduct->sendRequest($sku, $productInfoArr);

        // Get the json object
        $jsonResponse = (string) $response->getBody();

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $jsonResponse,
            json_encode([
                'id'                        => 1,
                'sku'                       => '1903275',
                'asin'                      => null,
                'condition'                 => 'used',
                'brand'                     => null,
                'manufacturer'              => null,
                'manufacturer_model_number' => null,
                'name'                      => 'Test Product',
                'description'               => null,
                'price'                     => 0,
                'cost'                      => 0,
                'package_length'            => 0,
                'package_width'             => 0,
                'package_height'            => 0,
                'package_unit_of_length'    => 'inches',
                'package_weight'            => 0,
                'package_unit_of_weight'    => 'pounds',
                'msrp'                      => 0,
                'category_name'             => '',
                'features'                  => [
                    'yellow',
                    'beautiful',
                ],
                'warranty'                  => null,
                'condition_note'            => null,
                'upc'                       => null,
                'ean'                       => null,
                'isbn'                      => null,
                'gtin'                      => null,
                'gcid'                      => null,
                'epid'                      => null,
                'image_list'                => '',
                'custom_attributes'         => [
                    'plate' => 'paper',
                ],
            ])
        );
    }

    // End public function testPostProductSuccessfullyPostAProduct

    public function testPostProductNotProvidingASkuShouldReturnAnException()
    {
        // Get the stored credentials
        $accountToken = 'M08923hgm';
        $secretKey = 'Sg934qjteaj923464ha';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining an error
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                200,
                ['Content-Type' => 'text/html'],
                'You failed to supply a SKU.'
            )
        );

        $sku = '';

        $productInfoArr = [
            'name'                      => 'Test Product',
            'asin'                      => null,
            'condition'                 => 'used',
            'brand'                     => null,
            'manufacturer'              => null,
            'manufacturer_model_number' => null,
            'description'               => null,
            'price'                     => 0.00,
            'cost'                      => 0.00,
            'package_length'            => 0,
            'package_width'             => 0,
            'package_height'            => 0,
            'package_unit_of_length'    => 'inches',
            'package_weight'            => 0,
            'package_unit_of_weight'    => 'pounds',
            'mrsp'                      => 0,
            'category_name'             => null,
            'features'                  => [
                'yellow',
                'beautiful',
            ],
            'warranty'                  => null,
            'condition_note'            => null,
            'upc'                       => null,
            'ean'                       => null,
            'isbn'                      => null,
            'gtin'                      => null,
            'epid'                      => null,
            'image_list'                => [],
            'custom_attributes'         => [
                'plate' => 'paper',
            ],
        ];

        // Instantiate a new GetChannels API Object
        $postProduct = new PostProduct($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $response = $postProduct->sendRequest($sku, $productInfoArr);
    }

    // End public function testPostProductNotProvidingASkuShouldReturnAnException

    public function testPostProductNotProvidingProductInfoShouldReturnAnException()
    {
        // Get the stored credentials
        $accountToken = 'M08923hgm';
        $secretKey = 'Sg934qjteaj923464ha';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining an error
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                200,
                ['Content-Type' => 'text/html'],
                'You failed to supply a product information array.'
            )
        );

        $sku = '209t7w092';

        $productInfoArr = [];

        // Instantiate a new GetChannels API Object
        $postProduct = new PostProduct($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $response = $postProduct->sendRequest($sku, $productInfoArr);
    }

    // End public function testPostProductNotProvidingProductInfoShouldReturnAnException

    public function testPostProductBadCredentialsForPostProductApiRequestShouldReturnAnException()
    {
        // Get the stored credentials
        $accountToken = '';
        $secretKey = '';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining an error
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                401,
                ['Content-Type' => 'text/html'],
                'HTTP Basic: Access denied.'
            )
        );

        $sku = '1903275';

        $productInfoArr = [
            'name'                      => 'Test Product',
            'asin'                      => null,
            'condition'                 => 'used',
            'brand'                     => null,
            'manufacturer'              => null,
            'manufacturer_model_number' => null,
            'description'               => null,
            'price'                     => 0.00,
            'cost'                      => 0.00,
            'package_length'            => 0,
            'package_width'             => 0,
            'package_height'            => 0,
            'package_unit_of_length'    => 'inches',
            'package_weight'            => 0,
            'package_unit_of_weight'    => 'pounds',
            'mrsp'                      => 0,
            'category_name'             => null,
            'features'                  => [
                'yellow',
                'beautiful',
            ],
            'warranty'                  => null,
            'condition_note'            => null,
            'upc'                       => null,
            'ean'                       => null,
            'isbn'                      => null,
            'gtin'                      => null,
            'epid'                      => null,
            'image_list'                => [],
            'custom_attributes'         => [
                'plate' => 'paper',
            ],
        ];

        // Instantiate a new GetChannels API Object
        $postProduct = new PostProduct($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $response = $postProduct->sendRequest($sku, $productInfoArr);
    }

    // End public function testBadCredentialsForGetAllOrdersApiRequestShouldReturnAnException

    public function testPostProductDefaultException()
    {
        // Get the stored credentials
        $accountToken = 'M902460t7hna';
        $secretKey = 'SM9powh62806hmngk';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining an error
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                405,
                ['Content-Type' => 'text/html'],
                'This is the default error.'
            )
        );

        $sku = '1903275';

        $productInfoArr = [
            'name'                      => 'Test Product',
            'asin'                      => null,
            'condition'                 => 'used',
            'brand'                     => null,
            'manufacturer'              => null,
            'manufacturer_model_number' => null,
            'description'               => null,
            'price'                     => 0.00,
            'cost'                      => 0.00,
            'package_length'            => 0,
            'package_width'             => 0,
            'package_height'            => 0,
            'package_unit_of_length'    => 'inches',
            'package_weight'            => 0,
            'package_unit_of_weight'    => 'pounds',
            'mrsp'                      => 0,
            'category_name'             => null,
            'features'                  => [
                'yellow',
                'beautiful',
            ],
            'warranty'                  => null,
            'condition_note'            => null,
            'upc'                       => null,
            'ean'                       => null,
            'isbn'                      => null,
            'gtin'                      => null,
            'epid'                      => null,
            'image_list'                => [],
            'custom_attributes'         => [
                'plate' => 'paper',
            ],
        ];

        // Instantiate a new GetChannels API Object
        $postProduct = new PostProduct($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $response = $postProduct->sendRequest($sku, $productInfoArr);
    }

    // End public function testBadCredentialsForGetAllOrdersApiRequestShouldReturnAnException
} // End class PostProductTest
