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

namespace TrollAndToad\Sellbrite\Test\Unit\Warehouses;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use TrollAndToad\Sellbrite\Warehouses\GetWarehouseFulfillments;

class GetWarehouseFulfillmentsTest extends TestCase
{
    public function testGetWarehouseFulfillmentsApiSuccessfullyGetFulfillments()
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
                ['Content-Type' => 'application/json', 'Total-Pages' => 1],
                '[
                    {
                      "display_ref": "dcc6be95",
                      "shipping_contact_name": "Ozzy the Octopus",
                      "shipping_email": "ozzy@sellbrite.com",
                      "shipping_company_name": "UPS",
                      "shipping_address_1": "130 West Union St",
                      "shipping_address_2": "#A",
                      "shipping_city": "Pasadena",
                      "shipping_state_region": "CA",
                      "shipping_postal_code": "91103",
                      "shipping_country_code": "US",
                      "shipping_phone_number": "808-123-1234",
                      "subtotal": 100,
                      "discount": 10,
                      "tax": 10.0,
                      "shipping_cost": 20,
                      "total": 120.0,
                      "sb_payment_status": "all",
                      "shipment_status": "none",
                      "ordered_at": "2017-01-06T22:28:42Z",
                      "sb_status": "open",
                      "cancelled_at": null,
                      "shipped_at": "2017-01-06T22:28:42Z",
                      "billing_address_1": "44 Green St",
                      "billing_address_2": null,
                      "billing_address_3": null,
                      "billing_city": "Pasadena",
                      "billing_state_region": "CA",
                      "billing_postal_code": "91801",
                      "billing_country": "United States",
                      "billing_country_code": "US",
                      "billing_phone_number": "808-143-8290",
                      "billing_contact_name": "B. Voldemort",
                      "billing_email": "bvoldemort@sellbrite.com",
                      "billing_company_name": "Sellbrite",
                      "sb_order_seq": 6666,
                      "channel_uuid": "497425c2-6598-4c03-8289-12323dab6bd",
                      "channel_type_display_name": "eBay",
                      "requested_shipping_service": "USPS Priority Mail",
                      "requested_shipping_provider": "USPS",
                      "requested_shipping_special": "amazon_prime",
                      "customer_notes": "Leave out on patio",
                      "merchant_notes": "Fragile",
                      "channel_name": "eBay Channel 1",
                      "items": [
                        {
                          "order_item_ref": "test-123-ref",
                          "fulfillment_quantity": 1,
                          "quantity": 1,
                          "title": "Planet Earth DVD",
                          "sku": "01230-01230-00",
                          "unit_price": 75.05,
                          "total": 82.56,
                          "quantity_fulfilled": 1,
                          "inventory_sku": "planet-dvd-sku",
                          "tax": 7.51
                          }
                        ]
                    }
                  ]'
            )
        );

        // Instantiate a new GetWarehouseFulfillments API Object
        $getWarehouseFulfillments = new GetWarehouseFulfillments($accountToken, $secretKey, $mockClient);

        $warehouseUuid = '7c4e66ae-7cf5-77d0-7a03-77e7851bdd0';

        $page = 1;
        $limit = 100;
        $min_ordered_at = '2017-01-05T22:28:42Z';
        $max_ordered_at = '2017-01-07T22:28:42Z';
        $sb_status = 'open';
        $sb_payment_status = 'all';
        $shipment_status = 'none';

        // Get the JSON response from the request
        $response = $getWarehouseFulfillments->sendRequest(
            $warehouseUuid,
            $page,
            $limit,
            $min_ordered_at,
            $max_ordered_at,
            $sb_status,
            $sb_payment_status,
            $shipment_status
        );

        // Get the json string from the body
        $jsonResponse = (string) $response->getBody();

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $jsonResponse,
            json_encode([
                [
                    'display_ref' => 'dcc6be95',
                    'shipping_contact_name' => 'Ozzy the Octopus',
                    'shipping_email' => 'ozzy@sellbrite.com',
                    'shipping_company_name' => 'UPS',
                    'shipping_address_1' => '130 West Union St',
                    'shipping_address_2' => '#A',
                    'shipping_city' => 'Pasadena',
                    'shipping_state_region' => 'CA',
                    'shipping_postal_code' => '91103',
                    'shipping_country_code' => 'US',
                    'shipping_phone_number' => '808-123-1234',
                    'subtotal' => 100,
                    'discount' => 10,
                    'tax' => 10.0,
                    'shipping_cost' => 20,
                    'total' => 120.0,
                    'sb_payment_status' => 'all',
                    'shipment_status' => 'none',
                    'ordered_at' => '2017-01-06T22:28:42Z',
                    'sb_status' => 'open',
                    'cancelled_at' => null,
                    'shipped_at' => '2017-01-06T22:28:42Z',
                    'billing_address_1' => '44 Green St',
                    'billing_address_2' => null,
                    'billing_address_3' => null,
                    'billing_city' => 'Pasadena',
                    'billing_state_region' => 'CA',
                    'billing_postal_code' => '91801',
                    'billing_country' => 'United States',
                    'billing_country_code' => 'US',
                    'billing_phone_number' => '808-143-8290',
                    'billing_contact_name' => 'B. Voldemort',
                    'billing_email' => 'bvoldemort@sellbrite.com',
                    'billing_company_name' => 'Sellbrite',
                    'sb_order_seq' => 6666,
                    'channel_uuid' => '497425c2-6598-4c03-8289-12323dab6bd',
                    'channel_type_display_name' => 'eBay',
                    'requested_shipping_service' => 'USPS Priority Mail',
                    'requested_shipping_provider' => 'USPS',
                    'requested_shipping_special' => 'amazon_prime',
                    'customer_notes' => 'Leave out on patio',
                    'merchant_notes' => 'Fragile',
                    'channel_name' => 'eBay Channel 1',
                    'items' => [
                        [
                            'order_item_ref' => 'test-123-ref',
                            'fulfillment_quantity' => 1,
                            'quantity' => 1,
                            'title' => 'Planet Earth DVD',
                            'sku' => '01230-01230-00',
                            'unit_price' => 75.05,
                            'total' => 82.56,
                            'quantity_fulfilled' => 1,
                            'inventory_sku' => 'planet-dvd-sku',
                            'tax' => 7.51,
                        ],
                    ],
                ],
            ])
        );
    }

    // End public function testGetWarehouseFulfillmentsApiSuccessfullyGetFulfillments

    public function testGetWarehouseFulfillmentsApiTestEmptyWarehouseUuid()
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
                ['Content-Type' => 'application/json', 'Total-Pages' => 1],
                '[
                    {
                      "display_ref": "dcc6be95",
                      "shipping_contact_name": "Ozzy the Octopus",
                      "shipping_email": "ozzy@sellbrite.com",
                      "shipping_company_name": "UPS",
                      "shipping_address_1": "130 West Union St",
                      "shipping_address_2": "#A",
                      "shipping_city": "Pasadena",
                      "shipping_state_region": "CA",
                      "shipping_postal_code": "91103",
                      "shipping_country_code": "US",
                      "shipping_phone_number": "808-123-1234",
                      "subtotal": 100,
                      "discount": 10,
                      "tax": 10.0,
                      "shipping_cost": 20,
                      "total": 120.0,
                      "sb_payment_status": "all",
                      "shipment_status": "none",
                      "ordered_at": "2017-01-06T22:28:42Z",
                      "sb_status": "open",
                      "cancelled_at": null,
                      "shipped_at": "2017-01-06T22:28:42Z",
                      "billing_address_1": "44 Green St",
                      "billing_address_2": null,
                      "billing_address_3": null,
                      "billing_city": "Pasadena",
                      "billing_state_region": "CA",
                      "billing_postal_code": "91801",
                      "billing_country": "United States",
                      "billing_country_code": "US",
                      "billing_phone_number": "808-143-8290",
                      "billing_contact_name": "B. Voldemort",
                      "billing_email": "bvoldemort@sellbrite.com",
                      "billing_company_name": "Sellbrite",
                      "sb_order_seq": 6666,
                      "channel_uuid": "497425c2-6598-4c03-8289-12323dab6bd",
                      "channel_type_display_name": "eBay",
                      "requested_shipping_service": "USPS Priority Mail",
                      "requested_shipping_provider": "USPS",
                      "requested_shipping_special": "amazon_prime",
                      "customer_notes": "Leave out on patio",
                      "merchant_notes": "Fragile",
                      "channel_name": "eBay Channel 1",
                      "items": [
                        {
                          "order_item_ref": "test-123-ref",
                          "fulfillment_quantity": 1,
                          "quantity": 1,
                          "title": "Planet Earth DVD",
                          "sku": "01230-01230-00",
                          "unit_price": 75.05,
                          "total": 82.56,
                          "quantity_fulfilled": 1,
                          "inventory_sku": "planet-dvd-sku",
                          "tax": 7.51
                          }
                        ]
                    }
                  ]'
            )
        );

        // Instantiate a new GetWarehouseFulfillments API Object
        $getWarehouseFulfillments = new GetWarehouseFulfillments($accountToken, $secretKey, $mockClient);

        $warehouseUuid = '';

        $page = 1;
        $limit = 100;
        $min_ordered_at = '2017-01-05T22:28:42Z';
        $max_ordered_at = '2017-01-07T22:28:42Z';
        $sb_status = 'open';
        $sb_payment_status = 'all';
        $shipment_status = 'none';

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Get the JSON response from the request
        $response = $getWarehouseFulfillments->sendRequest(
            $warehouseUuid,
            $page,
            $limit,
            $min_ordered_at,
            $max_ordered_at,
            $sb_status,
            $sb_payment_status,
            $shipment_status
        );
    }

    // End public function testGetWarehouseFulfillmentsApiSuccessfullyGetFulfillments

    public function testGetWarehouseFulfillmentsApiTestLimitTooLarge()
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
                ['Content-Type' => 'application/json', 'Total-Pages' => 1],
                '[
                    {
                      "display_ref": "dcc6be95",
                      "shipping_contact_name": "Ozzy the Octopus",
                      "shipping_email": "ozzy@sellbrite.com",
                      "shipping_company_name": "UPS",
                      "shipping_address_1": "130 West Union St",
                      "shipping_address_2": "#A",
                      "shipping_city": "Pasadena",
                      "shipping_state_region": "CA",
                      "shipping_postal_code": "91103",
                      "shipping_country_code": "US",
                      "shipping_phone_number": "808-123-1234",
                      "subtotal": 100,
                      "discount": 10,
                      "tax": 10.0,
                      "shipping_cost": 20,
                      "total": 120.0,
                      "sb_payment_status": "all",
                      "shipment_status": "none",
                      "ordered_at": "2017-01-06T22:28:42Z",
                      "sb_status": "open",
                      "cancelled_at": null,
                      "shipped_at": "2017-01-06T22:28:42Z",
                      "billing_address_1": "44 Green St",
                      "billing_address_2": null,
                      "billing_address_3": null,
                      "billing_city": "Pasadena",
                      "billing_state_region": "CA",
                      "billing_postal_code": "91801",
                      "billing_country": "United States",
                      "billing_country_code": "US",
                      "billing_phone_number": "808-143-8290",
                      "billing_contact_name": "B. Voldemort",
                      "billing_email": "bvoldemort@sellbrite.com",
                      "billing_company_name": "Sellbrite",
                      "sb_order_seq": 6666,
                      "channel_uuid": "497425c2-6598-4c03-8289-12323dab6bd",
                      "channel_type_display_name": "eBay",
                      "requested_shipping_service": "USPS Priority Mail",
                      "requested_shipping_provider": "USPS",
                      "requested_shipping_special": "amazon_prime",
                      "customer_notes": "Leave out on patio",
                      "merchant_notes": "Fragile",
                      "channel_name": "eBay Channel 1",
                      "items": [
                        {
                          "order_item_ref": "test-123-ref",
                          "fulfillment_quantity": 1,
                          "quantity": 1,
                          "title": "Planet Earth DVD",
                          "sku": "01230-01230-00",
                          "unit_price": 75.05,
                          "total": 82.56,
                          "quantity_fulfilled": 1,
                          "inventory_sku": "planet-dvd-sku",
                          "tax": 7.51
                          }
                        ]
                    }
                  ]'
            )
        );

        // Instantiate a new GetWarehouseFulfillments API Object
        $getWarehouseFulfillments = new GetWarehouseFulfillments($accountToken, $secretKey, $mockClient);

        $warehouseUuid = '7c4e66ae-7cf5-77d0-7a03-77e7851bdd0';

        $page = 1;
        $limit = 250;
        $min_ordered_at = '2017-01-05T22:28:42Z';
        $max_ordered_at = '2017-01-07T22:28:42Z';
        $sb_status = 'open';
        $sb_payment_status = 'all';
        $shipment_status = 'none';

        // Get the JSON response from the request
        $response = $getWarehouseFulfillments->sendRequest(
            $warehouseUuid,
            $page,
            $limit,
            $min_ordered_at,
            $max_ordered_at,
            $sb_status,
            $sb_payment_status,
            $shipment_status
        );

        // Get the json string from the body
        $jsonResponse = (string) $response->getBody();

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $jsonResponse,
            json_encode([
                [
                    'display_ref' => 'dcc6be95',
                    'shipping_contact_name' => 'Ozzy the Octopus',
                    'shipping_email' => 'ozzy@sellbrite.com',
                    'shipping_company_name' => 'UPS',
                    'shipping_address_1' => '130 West Union St',
                    'shipping_address_2' => '#A',
                    'shipping_city' => 'Pasadena',
                    'shipping_state_region' => 'CA',
                    'shipping_postal_code' => '91103',
                    'shipping_country_code' => 'US',
                    'shipping_phone_number' => '808-123-1234',
                    'subtotal' => 100,
                    'discount' => 10,
                    'tax' => 10.0,
                    'shipping_cost' => 20,
                    'total' => 120.0,
                    'sb_payment_status' => 'all',
                    'shipment_status' => 'none',
                    'ordered_at' => '2017-01-06T22:28:42Z',
                    'sb_status' => 'open',
                    'cancelled_at' => null,
                    'shipped_at' => '2017-01-06T22:28:42Z',
                    'billing_address_1' => '44 Green St',
                    'billing_address_2' => null,
                    'billing_address_3' => null,
                    'billing_city' => 'Pasadena',
                    'billing_state_region' => 'CA',
                    'billing_postal_code' => '91801',
                    'billing_country' => 'United States',
                    'billing_country_code' => 'US',
                    'billing_phone_number' => '808-143-8290',
                    'billing_contact_name' => 'B. Voldemort',
                    'billing_email' => 'bvoldemort@sellbrite.com',
                    'billing_company_name' => 'Sellbrite',
                    'sb_order_seq' => 6666,
                    'channel_uuid' => '497425c2-6598-4c03-8289-12323dab6bd',
                    'channel_type_display_name' => 'eBay',
                    'requested_shipping_service' => 'USPS Priority Mail',
                    'requested_shipping_provider' => 'USPS',
                    'requested_shipping_special' => 'amazon_prime',
                    'customer_notes' => 'Leave out on patio',
                    'merchant_notes' => 'Fragile',
                    'channel_name' => 'eBay Channel 1',
                    'items' => [
                        [
                            'order_item_ref' => 'test-123-ref',
                            'fulfillment_quantity' => 1,
                            'quantity' => 1,
                            'title' => 'Planet Earth DVD',
                            'sku' => '01230-01230-00',
                            'unit_price' => 75.05,
                            'total' => 82.56,
                            'quantity_fulfilled' => 1,
                            'inventory_sku' => 'planet-dvd-sku',
                            'tax' => 7.51,
                        ],
                    ],
                ],
            ])
        );
    }

    // End public function testGetWarehouseFulfillmentsApiTestLimitTooLarge

    public function testGetWarehouseFulfillmentsApiTestDefaultError()
    {
        // Get the stored credentials
        $accountToken = 'N8209ngasnd89032';
        $secretKey = 'M023hgh032h';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining JSON
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                500,
                ['Content-Type' => 'application/json'],
                'This is the default error.'
            )
        );

        // Instantiate a new GetWarehouseFulfillments API Object
        $getWarehouseFulfillments = new GetWarehouseFulfillments($accountToken, $secretKey, $mockClient);

        $warehouseUuid = '7c4e66ae-7cf5-77d0-7a03-77e7851bdd0';

        $page = 1;
        $limit = 250;
        $min_ordered_at = '2017-01-05T22:28:42Z';
        $max_ordered_at = '2017-01-07T22:28:42Z';
        $sb_status = 'open';
        $sb_payment_status = 'all';
        $shipment_status = 'none';

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Get the JSON response from the request
        $response = $getWarehouseFulfillments->sendRequest(
            $warehouseUuid,
            $page,
            $limit,
            $min_ordered_at,
            $max_ordered_at,
            $sb_status,
            $sb_payment_status,
            $shipment_status
        );
    }

    // End public function testGetWarehouseFulfillmentsApiTestDefaultError

    public function testGetWarehouseFulfillmentsApiTestBadAuth()
    {
        // Get the stored credentials
        $accountToken = '';
        $secretKey = '';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining JSON
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                401,
                ['Content-Type' => 'application/json'],
                'HTTP Basic: Access denied.'
            )
        );

        // Instantiate a new GetWarehouseFulfillments API Object
        $getWarehouseFulfillments = new GetWarehouseFulfillments($accountToken, $secretKey, $mockClient);

        $warehouseUuid = '7c4e66ae-7cf5-77d0-7a03-77e7851bdd0';

        $page = 1;
        $limit = 250;
        $min_ordered_at = '2017-01-05T22:28:42Z';
        $max_ordered_at = '2017-01-07T22:28:42Z';
        $sb_status = 'open';
        $sb_payment_status = 'all';
        $shipment_status = 'none';

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Get the JSON response from the request
        $response = $getWarehouseFulfillments->sendRequest(
            $warehouseUuid,
            $page,
            $limit,
            $min_ordered_at,
            $max_ordered_at,
            $sb_status,
            $sb_payment_status,
            $shipment_status
        );
    }

    // End public function testGetWarehouseFulfillmentsApiTestBadAuth
} // End class GetWarehouseFulfillmentsTest
