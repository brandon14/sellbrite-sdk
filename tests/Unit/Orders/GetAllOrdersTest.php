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

namespace TrollAndToad\Sellbrite\Test\Unit\Orders;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use TrollAndToad\Sellbrite\Orders\GetAllOrders;

class GetAllOrdersTest extends TestCase
{
    public function testGetAllOrdersTestingAllInputParameters()
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
                      "channel_name": "eBay Channel 1",
                      "requested_shipping_service": "USPS Priority Mail",
                      "requested_shipping_provider": "USPS",
                      "requested_shipping_special": "amazon_prime",
                      "customer_notes": "Leave out on patio",
                      "merchant_notes": "Fragile",
                      "ship_by_date": "2017-01-20T22:28:42Z",
                      "deliver_by_date": "2017-01-10T22:28:42Z",
                      "items": [
                        {
                          "order_item_ref": "test-123-ref",
                          "quantity": 2,
                          "title": "Planet Earth DVD",
                          "sku": "01230-01230-00",
                          "unit_price": 100,
                          "price": 100,
                          "total": 202.08,
                          "quantity_fulfilled": 1,
                          "inventory_sku": "planet-dvd-sku",
                          "tax": 2.08
                         }
                       ]
                    }
                ]'
            )
        );

        // Instantiate a new GetChannels API Object
        $getAllOrders = new GetAllOrders($accountToken, $secretKey, $mockClient);

        $page = 1;
        $limit = 100;
        $min_ordered_at = '2017-01-05T22:28:42Z';
        $max_ordered_at = '2017-01-07T22:28:42Z';
        $sb_status = 'open';
        $sb_payment_status = 'all';
        $shipment_status = 'none';

        // Get the JSON response from the request
        $response = $getAllOrders->sendRequest(
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
                    'display_ref'                 => 'dcc6be95',
                    'shipping_contact_name'       => 'Ozzy the Octopus',
                    'shipping_email'              => 'ozzy@sellbrite.com',
                    'shipping_company_name'       => 'UPS',
                    'shipping_address_1'          => '130 West Union St',
                    'shipping_address_2'          => '#A',
                    'shipping_city'               => 'Pasadena',
                    'shipping_state_region'       => 'CA',
                    'shipping_postal_code'        => '91103',
                    'shipping_country_code'       => 'US',
                    'shipping_phone_number'       => '808-123-1234',
                    'subtotal'                    => 100,
                    'discount'                    => 10,
                    'tax'                         => 10.0,
                    'shipping_cost'               => 20,
                    'total'                       => 120.0,
                    'sb_payment_status'           => 'all',
                    'shipment_status'             => 'none',
                    'ordered_at'                  => '2017-01-06T22:28:42Z',
                    'sb_status'                   => 'open',
                    'cancelled_at'                => null,
                    'shipped_at'                  => '2017-01-06T22:28:42Z',
                    'billing_address_1'           => '44 Green St',
                    'billing_address_2'           => null,
                    'billing_address_3'           => null,
                    'billing_city'                => 'Pasadena',
                    'billing_state_region'        => 'CA',
                    'billing_postal_code'         => '91801',
                    'billing_country'             => 'United States',
                    'billing_country_code'        => 'US',
                    'billing_phone_number'        => '808-143-8290',
                    'billing_contact_name'        => 'B. Voldemort',
                    'billing_email'               => 'bvoldemort@sellbrite.com',
                    'billing_company_name'        => 'Sellbrite',
                    'sb_order_seq'                => 6666,
                    'channel_uuid'                => '497425c2-6598-4c03-8289-12323dab6bd',
                    'channel_type_display_name'   => 'eBay',
                    'channel_name'                => 'eBay Channel 1',
                    'requested_shipping_service'  => 'USPS Priority Mail',
                    'requested_shipping_provider' => 'USPS',
                    'requested_shipping_special'  => 'amazon_prime',
                    'customer_notes'              => 'Leave out on patio',
                    'merchant_notes'              => 'Fragile',
                    'ship_by_date'                => '2017-01-20T22:28:42Z',
                    'deliver_by_date'             => '2017-01-10T22:28:42Z',
                    'items'                       => [
                        [
                            'order_item_ref'     => 'test-123-ref',
                            'quantity'           => 2,
                            'title'              => 'Planet Earth DVD',
                            'sku'                => '01230-01230-00',
                            'unit_price'         => 100,
                            'price'              => 100,
                            'total'              => 202.08,
                            'quantity_fulfilled' => 1,
                            'inventory_sku'      => 'planet-dvd-sku',
                            'tax'                => 2.08,
                        ],
                    ],
                ],
            ])
        );
    }

    // End public function testGetAllOrdersTestingAllInputParameters

    public function testGetAllOrdersGetTotalPagesHeader()
    {
        // Get the stored credentials
        $accountToken = 'am2902ngt3Nn';
        $secretKey = 'happy28bananas';

        // Initialize the totalPages variable
        $totalPages = 0;

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining JSON
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                200,
                ['Content-Type' => 'application/json', 'Total-Pages' => 5],
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
                      "channel_name": "eBay Channel 1",
                      "requested_shipping_service": "USPS Priority Mail",
                      "requested_shipping_provider": "USPS",
                      "requested_shipping_special": "amazon_prime",
                      "customer_notes": "Leave out on patio",
                      "merchant_notes": "Fragile",
                      "ship_by_date": "2017-01-20T22:28:42Z",
                      "deliver_by_date": "2017-01-10T22:28:42Z",
                      "items": [
                        {
                          "order_item_ref": "test-123-ref",
                          "quantity": 2,
                          "title": "Planet Earth DVD",
                          "sku": "01230-01230-00",
                          "unit_price": 100,
                          "price": 100,
                          "total": 202.08,
                          "quantity_fulfilled": 1,
                          "inventory_sku": "planet-dvd-sku",
                          "tax": 2.08
                         }
                       ]
                    }
                ]'
            )
        );

        // Instantiate a new GetChannels API Object
        $getAllOrders = new GetAllOrders($accountToken, $secretKey, $mockClient);

        $page = 1;
        $limit = 100;
        $min_ordered_at = '2017-01-05T22:28:42Z';
        $max_ordered_at = '2017-01-07T22:28:42Z';
        $sb_status = 'open';
        $sb_payment_status = 'all';
        $shipment_status = 'none';

        // Get the JSON response from the request
        $response = $getAllOrders->sendRequest(
            $page,
            $limit,
            $min_ordered_at,
            $max_ordered_at,
            $sb_status,
            $sb_payment_status,
            $shipment_status
        );

        // Get Total-Pages Header
        if ($response->hasHeader('Total-Pages')) {
            $totalPages = $response->getHeader('Total-Pages')[0];
        }

        $this->assertSame($totalPages, 5);
    }

    // End public function testGetAllOrdersGetTotalPagesHeader

    public function testGetAllOrdersTestingBadDateParameter()
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
                      "channel_name": "eBay Channel 1",
                      "requested_shipping_service": "USPS Priority Mail",
                      "requested_shipping_provider": "USPS",
                      "requested_shipping_special": "amazon_prime",
                      "customer_notes": "Leave out on patio",
                      "merchant_notes": "Fragile",
                      "ship_by_date": "2017-01-20T22:28:42Z",
                      "deliver_by_date": "2017-01-10T22:28:42Z",
                      "items": [
                        {
                          "order_item_ref": "test-123-ref",
                          "quantity": 2,
                          "title": "Planet Earth DVD",
                          "sku": "01230-01230-00",
                          "unit_price": 100,
                          "price": 100,
                          "total": 202.08,
                          "quantity_fulfilled": 1,
                          "inventory_sku": "planet-dvd-sku",
                          "tax": 2.08
                         }
                       ]
                    }
                ]'
            )
        );

        // Instantiate a new GetChannels API Object
        $getAllOrders = new GetAllOrders($accountToken, $secretKey, $mockClient);

        $page = 1;
        $limit = 100;
        $min_ordered_at = 'M8902ngm33n3';
        $max_ordered_at = '2017-01-07T22:28:42Z';
        $sb_status = 'open';
        $sb_payment_status = 'all';
        $shipment_status = 'none';

        // Get the JSON response from the request
        $response = $getAllOrders->sendRequest(
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
                    'display_ref'                 => 'dcc6be95',
                    'shipping_contact_name'       => 'Ozzy the Octopus',
                    'shipping_email'              => 'ozzy@sellbrite.com',
                    'shipping_company_name'       => 'UPS',
                    'shipping_address_1'          => '130 West Union St',
                    'shipping_address_2'          => '#A',
                    'shipping_city'               => 'Pasadena',
                    'shipping_state_region'       => 'CA',
                    'shipping_postal_code'        => '91103',
                    'shipping_country_code'       => 'US',
                    'shipping_phone_number'       => '808-123-1234',
                    'subtotal'                    => 100,
                    'discount'                    => 10,
                    'tax'                         => 10.0,
                    'shipping_cost'               => 20,
                    'total'                       => 120.0,
                    'sb_payment_status'           => 'all',
                    'shipment_status'             => 'none',
                    'ordered_at'                  => '2017-01-06T22:28:42Z',
                    'sb_status'                   => 'open',
                    'cancelled_at'                => null,
                    'shipped_at'                  => '2017-01-06T22:28:42Z',
                    'billing_address_1'           => '44 Green St',
                    'billing_address_2'           => null,
                    'billing_address_3'           => null,
                    'billing_city'                => 'Pasadena',
                    'billing_state_region'        => 'CA',
                    'billing_postal_code'         => '91801',
                    'billing_country'             => 'United States',
                    'billing_country_code'        => 'US',
                    'billing_phone_number'        => '808-143-8290',
                    'billing_contact_name'        => 'B. Voldemort',
                    'billing_email'               => 'bvoldemort@sellbrite.com',
                    'billing_company_name'        => 'Sellbrite',
                    'sb_order_seq'                => 6666,
                    'channel_uuid'                => '497425c2-6598-4c03-8289-12323dab6bd',
                    'channel_type_display_name'   => 'eBay',
                    'channel_name'                => 'eBay Channel 1',
                    'requested_shipping_service'  => 'USPS Priority Mail',
                    'requested_shipping_provider' => 'USPS',
                    'requested_shipping_special'  => 'amazon_prime',
                    'customer_notes'              => 'Leave out on patio',
                    'merchant_notes'              => 'Fragile',
                    'ship_by_date'                => '2017-01-20T22:28:42Z',
                    'deliver_by_date'             => '2017-01-10T22:28:42Z',
                    'items'                       => [
                        [
                            'order_item_ref'     => 'test-123-ref',
                            'quantity'           => 2,
                            'title'              => 'Planet Earth DVD',
                            'sku'                => '01230-01230-00',
                            'unit_price'         => 100,
                            'price'              => 100,
                            'total'              => 202.08,
                            'quantity_fulfilled' => 1,
                            'inventory_sku'      => 'planet-dvd-sku',
                            'tax'                => 2.08,
                        ],
                    ],
                ],
            ])
        );
    }

    // End public function testGetAllOrdersTestingBadDateParameter

    public function testGetAllOrdersTestingLimitGreaterThanMaximum()
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
                      "channel_name": "eBay Channel 1",
                      "requested_shipping_service": "USPS Priority Mail",
                      "requested_shipping_provider": "USPS",
                      "requested_shipping_special": "amazon_prime",
                      "customer_notes": "Leave out on patio",
                      "merchant_notes": "Fragile",
                      "ship_by_date": "2017-01-20T22:28:42Z",
                      "deliver_by_date": "2017-01-10T22:28:42Z",
                      "items": [
                        {
                          "order_item_ref": "test-123-ref",
                          "quantity": 2,
                          "title": "Planet Earth DVD",
                          "sku": "01230-01230-00",
                          "unit_price": 100,
                          "price": 100,
                          "total": 202.08,
                          "quantity_fulfilled": 1,
                          "inventory_sku": "planet-dvd-sku",
                          "tax": 2.08
                         }
                       ]
                    }
                ]'
            )
        );

        // Instantiate a new GetChannels API Object
        $getAllOrders = new GetAllOrders($accountToken, $secretKey, $mockClient);

        $page = 1;
        $limit = 350;
        $min_ordered_at = '2017-01-05T22:28:42Z';
        $max_ordered_at = '2017-01-07T22:28:42Z';
        $sb_status = 'open';
        $sb_payment_status = 'all';
        $shipment_status = 'none';

        // Get the JSON response from the request
        $response = $getAllOrders->sendRequest(
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
                    'display_ref'                 => 'dcc6be95',
                    'shipping_contact_name'       => 'Ozzy the Octopus',
                    'shipping_email'              => 'ozzy@sellbrite.com',
                    'shipping_company_name'       => 'UPS',
                    'shipping_address_1'          => '130 West Union St',
                    'shipping_address_2'          => '#A',
                    'shipping_city'               => 'Pasadena',
                    'shipping_state_region'       => 'CA',
                    'shipping_postal_code'        => '91103',
                    'shipping_country_code'       => 'US',
                    'shipping_phone_number'       => '808-123-1234',
                    'subtotal'                    => 100,
                    'discount'                    => 10,
                    'tax'                         => 10.0,
                    'shipping_cost'               => 20,
                    'total'                       => 120.0,
                    'sb_payment_status'           => 'all',
                    'shipment_status'             => 'none',
                    'ordered_at'                  => '2017-01-06T22:28:42Z',
                    'sb_status'                   => 'open',
                    'cancelled_at'                => null,
                    'shipped_at'                  => '2017-01-06T22:28:42Z',
                    'billing_address_1'           => '44 Green St',
                    'billing_address_2'           => null,
                    'billing_address_3'           => null,
                    'billing_city'                => 'Pasadena',
                    'billing_state_region'        => 'CA',
                    'billing_postal_code'         => '91801',
                    'billing_country'             => 'United States',
                    'billing_country_code'        => 'US',
                    'billing_phone_number'        => '808-143-8290',
                    'billing_contact_name'        => 'B. Voldemort',
                    'billing_email'               => 'bvoldemort@sellbrite.com',
                    'billing_company_name'        => 'Sellbrite',
                    'sb_order_seq'                => 6666,
                    'channel_uuid'                => '497425c2-6598-4c03-8289-12323dab6bd',
                    'channel_type_display_name'   => 'eBay',
                    'channel_name'                => 'eBay Channel 1',
                    'requested_shipping_service'  => 'USPS Priority Mail',
                    'requested_shipping_provider' => 'USPS',
                    'requested_shipping_special'  => 'amazon_prime',
                    'customer_notes'              => 'Leave out on patio',
                    'merchant_notes'              => 'Fragile',
                    'ship_by_date'                => '2017-01-20T22:28:42Z',
                    'deliver_by_date'             => '2017-01-10T22:28:42Z',
                    'items'                       => [
                        [
                            'order_item_ref'     => 'test-123-ref',
                            'quantity'           => 2,
                            'title'              => 'Planet Earth DVD',
                            'sku'                => '01230-01230-00',
                            'unit_price'         => 100,
                            'price'              => 100,
                            'total'              => 202.08,
                            'quantity_fulfilled' => 1,
                            'inventory_sku'      => 'planet-dvd-sku',
                            'tax'                => 2.08,
                        ],
                    ],
                ],
            ])
        );
    }

    // End public function testGetAllOrdersTestingLimitGreaterThanMaximum

    public function testGetAllOrdersTestingInvalidStatus()
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
                      "channel_name": "eBay Channel 1",
                      "requested_shipping_service": "USPS Priority Mail",
                      "requested_shipping_provider": "USPS",
                      "requested_shipping_special": "amazon_prime",
                      "customer_notes": "Leave out on patio",
                      "merchant_notes": "Fragile",
                      "ship_by_date": "2017-01-20T22:28:42Z",
                      "deliver_by_date": "2017-01-10T22:28:42Z",
                      "items": [
                        {
                          "order_item_ref": "test-123-ref",
                          "quantity": 2,
                          "title": "Planet Earth DVD",
                          "sku": "01230-01230-00",
                          "unit_price": 100,
                          "price": 100,
                          "total": 202.08,
                          "quantity_fulfilled": 1,
                          "inventory_sku": "planet-dvd-sku",
                          "tax": 2.08
                         }
                       ]
                    }
                ]'
            )
        );

        // Instantiate a new GetChannels API Object
        $getAllOrders = new GetAllOrders($accountToken, $secretKey, $mockClient);

        $page = 1;
        $limit = 350;
        $min_ordered_at = '2017-01-05T22:28:42Z';
        $max_ordered_at = '2017-01-07T22:28:42Z';
        $sb_status = 'opesagsav3n';
        $sb_payment_status = '980n2';
        $shipment_status = 't2gasdg';

        // Get the JSON response from the request
        $response = $getAllOrders->sendRequest(
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
                    'display_ref'                 => 'dcc6be95',
                    'shipping_contact_name'       => 'Ozzy the Octopus',
                    'shipping_email'              => 'ozzy@sellbrite.com',
                    'shipping_company_name'       => 'UPS',
                    'shipping_address_1'          => '130 West Union St',
                    'shipping_address_2'          => '#A',
                    'shipping_city'               => 'Pasadena',
                    'shipping_state_region'       => 'CA',
                    'shipping_postal_code'        => '91103',
                    'shipping_country_code'       => 'US',
                    'shipping_phone_number'       => '808-123-1234',
                    'subtotal'                    => 100,
                    'discount'                    => 10,
                    'tax'                         => 10.0,
                    'shipping_cost'               => 20,
                    'total'                       => 120.0,
                    'sb_payment_status'           => 'all',
                    'shipment_status'             => 'none',
                    'ordered_at'                  => '2017-01-06T22:28:42Z',
                    'sb_status'                   => 'open',
                    'cancelled_at'                => null,
                    'shipped_at'                  => '2017-01-06T22:28:42Z',
                    'billing_address_1'           => '44 Green St',
                    'billing_address_2'           => null,
                    'billing_address_3'           => null,
                    'billing_city'                => 'Pasadena',
                    'billing_state_region'        => 'CA',
                    'billing_postal_code'         => '91801',
                    'billing_country'             => 'United States',
                    'billing_country_code'        => 'US',
                    'billing_phone_number'        => '808-143-8290',
                    'billing_contact_name'        => 'B. Voldemort',
                    'billing_email'               => 'bvoldemort@sellbrite.com',
                    'billing_company_name'        => 'Sellbrite',
                    'sb_order_seq'                => 6666,
                    'channel_uuid'                => '497425c2-6598-4c03-8289-12323dab6bd',
                    'channel_type_display_name'   => 'eBay',
                    'channel_name'                => 'eBay Channel 1',
                    'requested_shipping_service'  => 'USPS Priority Mail',
                    'requested_shipping_provider' => 'USPS',
                    'requested_shipping_special'  => 'amazon_prime',
                    'customer_notes'              => 'Leave out on patio',
                    'merchant_notes'              => 'Fragile',
                    'ship_by_date'                => '2017-01-20T22:28:42Z',
                    'deliver_by_date'             => '2017-01-10T22:28:42Z',
                    'items'                       => [
                        [
                            'order_item_ref'     => 'test-123-ref',
                            'quantity'           => 2,
                            'title'              => 'Planet Earth DVD',
                            'sku'                => '01230-01230-00',
                            'unit_price'         => 100,
                            'price'              => 100,
                            'total'              => 202.08,
                            'quantity_fulfilled' => 1,
                            'inventory_sku'      => 'planet-dvd-sku',
                            'tax'                => 2.08,
                        ],
                    ],
                ],
            ])
        );
    }

    // End public function testGetAllOrdersTestingInvalidStatus

    public function testGetAllOrdersBadCredentialsForGetAllOrdersApiRequestShouldReturnAnException()
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

        // Instantiate a new GetChannels API Object
        $getAllOrders = new GetAllOrders($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $response = $getAllOrders->sendRequest();
    }

    // End public function testBadCredentialsForGetAllOrdersApiRequestShouldReturnAnException

    public function testGetAllOrdersApiRequestShouldReturnDefaultException()
    {
        // Get the stored credentials
        $accountToken = '*()namgast723h';
        $secretKey = 'N)Sdng0q3ht4nq81';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining an error
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                400,
                ['Content-Type' => 'text/html'],
                'This is an the default error.'
            )
        );

        // Instantiate a new GetChannels API Object
        $getAllOrders = new GetAllOrders($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $response = $getAllOrders->sendRequest();
    }

    // End public function testGetAllOrdersApiRequestShouldReturnDefaultException
} // End class GetAllOrdersTest
