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

namespace TrollAndToad\Sellbrite\Test\Unit\Inventory;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use TrollAndToad\Sellbrite\Inventory\GetAllInventory;

class GetAllInventoryTest extends TestCase
{
    public function testGetAllInventoryTestingAllInputParameters()
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
                ['Content-Type' => 'application/json', 'Total-Pages' => 2],
                '[
                    {
                      "sku": "01230-00123-00",
                      "warehouse_uuid": "19dcad9a-0123-445f-83d4-35a62612382f",
                      "on_hand": 200,
                      "product_name": "Funko Pop",
                      "available": 100,
                      "reserved": 100,
                      "package_length": 5.0,
                      "package_width": 5.0,
                      "package_height": 6.0,
                      "package_weight": 12.0,
                      "cost": 12.0,
                      "upc": "test-upc",
                      "ean": "test-ean",
                      "isbn": "test-isbn",
                      "gtin": "test-gtin",
                      "gcid": "test-gcid",
                      "epid": "test-epid",
                      "asin": "test-asin",
                      "fnsku": "test-fnsku",
                      "bin_location": "test-bin-location"
                    }
                ]'
            )
        );

        // Instantiate a new GetAllInventory API Object
        $getAllInventory = new GetAllInventory($accountToken, $secretKey, $mockClient);

        $page = 1;
        $limit = 100;
        $warehouse_uuid = '19dcad9a-0123-445f-83d4-35a62612382f';
        $sku = null;
        $created_at_min = '2017-01-05T22:28:42Z';
        $created_at_max = '2017-01-07T22:28:42Z';
        $updated_at_min = null;
        $updated_at_max = null;

        // Get the JSON response from the request
        $response = $getAllInventory->sendRequest(
            $page,
            $limit,
            $warehouse_uuid,
            $sku,
            $created_at_min,
            $created_at_max,
            $updated_at_min,
            $updated_at_max
        );

        // Get the json string from the body
        $jsonResponse = (string) $response->getBody();

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $jsonResponse,
            json_encode([
                [
                    'sku'            => '01230-00123-00',
                    'warehouse_uuid' => '19dcad9a-0123-445f-83d4-35a62612382f',
                    'on_hand'        => 200,
                    'product_name'   => 'Funko Pop',
                    'available'      => 100,
                    'reserved'       => 100,
                    'package_length' => 5.0,
                    'package_width'  => 5.0,
                    'package_height' => 6.0,
                    'package_weight' => 12.0,
                    'cost'           => 12.0,
                    'upc'            => 'test-upc',
                    'ean'            => 'test-ean',
                    'isbn'           => 'test-isbn',
                    'gtin'           => 'test-gtin',
                    'gcid'           => 'test-gcid',
                    'epid'           => 'test-epid',
                    'asin'           => 'test-asin',
                    'fnsku'          => 'test-fnsku',
                    'bin_location'   => 'test-bin-location',
                ],
            ])
        );
    }

    // End public function testGetAllInventoryTestingAllInputParameters

    public function testGetAllInventoryTestingLargerLimit()
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
                ['Content-Type' => 'application/json', 'Total-Pages' => 2],
                '[
                    {
                      "sku": "01230-00123-00",
                      "warehouse_uuid": "19dcad9a-0123-445f-83d4-35a62612382f",
                      "on_hand": 200,
                      "product_name": "Funko Pop",
                      "available": 100,
                      "reserved": 100,
                      "package_length": 5.0,
                      "package_width": 5.0,
                      "package_height": 6.0,
                      "package_weight": 12.0,
                      "cost": 12.0,
                      "upc": "test-upc",
                      "ean": "test-ean",
                      "isbn": "test-isbn",
                      "gtin": "test-gtin",
                      "gcid": "test-gcid",
                      "epid": "test-epid",
                      "asin": "test-asin",
                      "fnsku": "test-fnsku",
                      "bin_location": "test-bin-location"
                    }
                ]'
            )
        );

        // Instantiate a new GetAllInventory API Object
        $getAllInventory = new GetAllInventory($accountToken, $secretKey, $mockClient);

        $page = 1;
        $limit = 200;
        $warehouse_uuid = '19dcad9a-0123-445f-83d4-35a62612382f';
        $sku = null;
        $created_at_min = '2017-01-05T22:28:42Z';
        $created_at_max = '2017-01-07T22:28:42Z';
        $updated_at_min = null;
        $updated_at_max = null;

        // Get the JSON response from the request
        $response = $getAllInventory->sendRequest(
            $page,
            $limit,
            $warehouse_uuid,
            $sku,
            $created_at_min,
            $created_at_max,
            $updated_at_min,
            $updated_at_max
        );

        // Get the json string from the body
        $jsonResponse = (string) $response->getBody();

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $jsonResponse,
            json_encode([
                [
                    'sku'            => '01230-00123-00',
                    'warehouse_uuid' => '19dcad9a-0123-445f-83d4-35a62612382f',
                    'on_hand'        => 200,
                    'product_name'   => 'Funko Pop',
                    'available'      => 100,
                    'reserved'       => 100,
                    'package_length' => 5.0,
                    'package_width'  => 5.0,
                    'package_height' => 6.0,
                    'package_weight' => 12.0,
                    'cost'           => 12.0,
                    'upc'            => 'test-upc',
                    'ean'            => 'test-ean',
                    'isbn'           => 'test-isbn',
                    'gtin'           => 'test-gtin',
                    'gcid'           => 'test-gcid',
                    'epid'           => 'test-epid',
                    'asin'           => 'test-asin',
                    'fnsku'          => 'test-fnsku',
                    'bin_location'   => 'test-bin-location',
                ],
            ])
        );
    }

    // End public function testGetAllInventoryTestingLargerLimit

    public function testGetAllInventoryTestingNullWarehouseUUID()
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
                ['Content-Type' => 'application/json', 'Total-Pages' => 2],
                '[
                    {
                      "sku": "01230-00123-00",
                      "warehouse_uuid": "19dcad9a-0123-445f-83d4-35a62612382f",
                      "on_hand": 200,
                      "product_name": "Funko Pop",
                      "available": 100,
                      "reserved": 100,
                      "package_length": 5.0,
                      "package_width": 5.0,
                      "package_height": 6.0,
                      "package_weight": 12.0,
                      "cost": 12.0,
                      "upc": "test-upc",
                      "ean": "test-ean",
                      "isbn": "test-isbn",
                      "gtin": "test-gtin",
                      "gcid": "test-gcid",
                      "epid": "test-epid",
                      "asin": "test-asin",
                      "fnsku": "test-fnsku",
                      "bin_location": "test-bin-location"
                    }
                ]'
            )
        );

        // Instantiate a new GetAllInventory API Object
        $getAllInventory = new GetAllInventory($accountToken, $secretKey, $mockClient);

        $page = 1;
        $limit = 200;
        $warehouse_uuid = '19dcad9a-0123-445f-83d4-35a62612382f';
        $sku = null;
        $created_at_min = '2017-01-05T22:28:42Z';
        $created_at_max = '2017-01-07T22:28:42Z';
        $updated_at_min = null;
        $updated_at_max = null;

        // Get the JSON response from the request
        $response = $getAllInventory->sendRequest(
            $page,
            $limit,
            $warehouse_uuid,
            $sku,
            $created_at_min,
            $created_at_max,
            $updated_at_min,
            $updated_at_max
        );

        // Get the json string from the body
        $jsonResponse = (string) $response->getBody();

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $jsonResponse,
            json_encode([
                [
                    'sku'            => '01230-00123-00',
                    'warehouse_uuid' => '19dcad9a-0123-445f-83d4-35a62612382f',
                    'on_hand'        => 200,
                    'product_name'   => 'Funko Pop',
                    'available'      => 100,
                    'reserved'       => 100,
                    'package_length' => 5.0,
                    'package_width'  => 5.0,
                    'package_height' => 6.0,
                    'package_weight' => 12.0,
                    'cost'           => 12.0,
                    'upc'            => 'test-upc',
                    'ean'            => 'test-ean',
                    'isbn'           => 'test-isbn',
                    'gtin'           => 'test-gtin',
                    'gcid'           => 'test-gcid',
                    'epid'           => 'test-epid',
                    'asin'           => 'test-asin',
                    'fnsku'          => 'test-fnsku',
                    'bin_location'   => 'test-bin-location',
                ],
            ])
        );
    }

    // End public function testGetAllInventoryTestingNullWarehouseUUID

    public function testGetAllInventoryTestingWithSku()
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
                ['Content-Type' => 'application/json', 'Total-Pages' => 2],
                '[
                    {
                      "sku": "01230-00123-00",
                      "warehouse_uuid": "19dcad9a-0123-445f-83d4-35a62612382f",
                      "on_hand": 200,
                      "product_name": "Funko Pop",
                      "available": 100,
                      "reserved": 100,
                      "package_length": 5.0,
                      "package_width": 5.0,
                      "package_height": 6.0,
                      "package_weight": 12.0,
                      "cost": 12.0,
                      "upc": "test-upc",
                      "ean": "test-ean",
                      "isbn": "test-isbn",
                      "gtin": "test-gtin",
                      "gcid": "test-gcid",
                      "epid": "test-epid",
                      "asin": "test-asin",
                      "fnsku": "test-fnsku",
                      "bin_location": "test-bin-location"
                    }
                ]'
            )
        );

        // Instantiate a new GetAllInventory API Object
        $getAllInventory = new GetAllInventory($accountToken, $secretKey, $mockClient);

        $page = 1;
        $limit = 200;
        $warehouse_uuid = '19dcad9a-0123-445f-83d4-35a62612382f';
        $sku = '01230-00123-00';
        $created_at_min = '2017-01-05T22:28:42Z';
        $created_at_max = '2017-01-07T22:28:42Z';
        $updated_at_min = null;
        $updated_at_max = null;

        // Get the JSON response from the request
        $response = $getAllInventory->sendRequest(
            $page,
            $limit,
            $warehouse_uuid,
            $sku,
            $created_at_min,
            $created_at_max,
            $updated_at_min,
            $updated_at_max
        );

        // Get the json string from the body
        $jsonResponse = (string) $response->getBody();

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $jsonResponse,
            json_encode([
                [
                    'sku'            => '01230-00123-00',
                    'warehouse_uuid' => '19dcad9a-0123-445f-83d4-35a62612382f',
                    'on_hand'        => 200,
                    'product_name'   => 'Funko Pop',
                    'available'      => 100,
                    'reserved'       => 100,
                    'package_length' => 5.0,
                    'package_width'  => 5.0,
                    'package_height' => 6.0,
                    'package_weight' => 12.0,
                    'cost'           => 12.0,
                    'upc'            => 'test-upc',
                    'ean'            => 'test-ean',
                    'isbn'           => 'test-isbn',
                    'gtin'           => 'test-gtin',
                    'gcid'           => 'test-gcid',
                    'epid'           => 'test-epid',
                    'asin'           => 'test-asin',
                    'fnsku'          => 'test-fnsku',
                    'bin_location'   => 'test-bin-location',
                ],
            ])
        );
    }

    // End public function testGetAllInventoryTestingWithSku

    public function testGetAllInventoryTestingWithUpdatedDates()
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
                ['Content-Type' => 'application/json', 'Total-Pages' => 2],
                '[
                    {
                      "sku": "01230-00123-00",
                      "warehouse_uuid": "19dcad9a-0123-445f-83d4-35a62612382f",
                      "on_hand": 200,
                      "product_name": "Funko Pop",
                      "available": 100,
                      "reserved": 100,
                      "package_length": 5.0,
                      "package_width": 5.0,
                      "package_height": 6.0,
                      "package_weight": 12.0,
                      "cost": 12.0,
                      "upc": "test-upc",
                      "ean": "test-ean",
                      "isbn": "test-isbn",
                      "gtin": "test-gtin",
                      "gcid": "test-gcid",
                      "epid": "test-epid",
                      "asin": "test-asin",
                      "fnsku": "test-fnsku",
                      "bin_location": "test-bin-location"
                    }
                ]'
            )
        );

        // Instantiate a new GetAllInventory API Object
        $getAllInventory = new GetAllInventory($accountToken, $secretKey, $mockClient);

        $page = 1;
        $limit = 200;
        $warehouse_uuid = '19dcad9a-0123-445f-83d4-35a62612382f';
        $sku = '01230-00123-00';
        $created_at_min = '2017-01-05T22:28:42Z';
        $created_at_max = '2017-01-07T22:28:42Z';
        $updated_at_min = '2017-01-05T22:28:42Z';
        $updated_at_max = '2017-01-07T22:28:42Z';

        // Get the JSON response from the request
        $response = $getAllInventory->sendRequest(
            $page,
            $limit,
            $warehouse_uuid,
            $sku,
            $created_at_min,
            $created_at_max,
            $updated_at_min,
            $updated_at_max
        );

        // Get the json string from the body
        $jsonResponse = (string) $response->getBody();

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $jsonResponse,
            json_encode([
                [
                    'sku'            => '01230-00123-00',
                    'warehouse_uuid' => '19dcad9a-0123-445f-83d4-35a62612382f',
                    'on_hand'        => 200,
                    'product_name'   => 'Funko Pop',
                    'available'      => 100,
                    'reserved'       => 100,
                    'package_length' => 5.0,
                    'package_width'  => 5.0,
                    'package_height' => 6.0,
                    'package_weight' => 12.0,
                    'cost'           => 12.0,
                    'upc'            => 'test-upc',
                    'ean'            => 'test-ean',
                    'isbn'           => 'test-isbn',
                    'gtin'           => 'test-gtin',
                    'gcid'           => 'test-gcid',
                    'epid'           => 'test-epid',
                    'asin'           => 'test-asin',
                    'fnsku'          => 'test-fnsku',
                    'bin_location'   => 'test-bin-location',
                ],
            ])
        );
    }

    // End public function testGetAllInventoryTestingWithUpdatedDates

    public function testGetAllInventoryApiBadCredentialsRequestShouldReturnAnException()
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

        // Instantiate a new GetAllInventory API Object
        $getAllInventory = new GetAllInventory($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $page = null;
        $limit = null;
        $warehouse_uuid = null;
        $sku = null;
        $created_at_min = null;
        $created_at_max = null;
        $updated_at_min = null;
        $updated_at_max = null;

        // Get the JSON response from the request
        $response = $getAllInventory->sendRequest(
            $page,
            $limit,
            $warehouse_uuid,
            $sku,
            $created_at_min,
            $created_at_max,
            $updated_at_min,
            $updated_at_max
        );
    }

    // End public function testGetAllInventoryApiBadCredentialsRequestShouldReturnAnException

    public function testGetAllInventoryApiRequestShouldReturnDefaultException()
    {
        // Get the stored credentials
        $accountToken = 'M09823hgan';
        $secretKey = 'M89023nga301';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining an error
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                400,
                ['Content-Type' => 'text/html'],
                'This is the default error.'
            )
        );

        // Instantiate a new GetAllInventory API Object
        $getAllInventory = new GetAllInventory($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        $page = null;
        $limit = null;
        $warehouse_uuid = null;
        $sku = null;
        $created_at_min = null;
        $created_at_max = null;
        $updated_at_min = null;
        $updated_at_max = null;

        // Get the JSON response from the request
        $response = $getAllInventory->sendRequest(
            $page,
            $limit,
            $warehouse_uuid,
            $sku,
            $created_at_min,
            $created_at_max,
            $updated_at_min,
            $updated_at_max
        );
    }

    // End public function testGetAllInventoryApiRequestShouldReturnDefaultException
} // End class GetAllInventoryTest
