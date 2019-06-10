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
use TrollAndToad\Sellbrite\Orders\GetOrder;

class GetOrderTest extends TestCase
{
    public function testGetOrderApiRequest()
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
                  }'
            )
        );

        // Instantiate a new GetOrder API Object
        $getOrder = new GetOrder($accountToken, $secretKey, $mockClient);

        $sb_order_sequence = 'M923ngmZp';

        // Get the JSON response from the request
        $jsonResponse = $getOrder->sendRequest($sb_order_sequence);

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $jsonResponse,
            json_encode([
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
                'channel_name' => 'eBay Channel 1',
                'requested_shipping_service' => 'USPS Priority Mail',
                'requested_shipping_provider' => 'USPS',
                'requested_shipping_special' => 'amazon_prime',
                'customer_notes' => 'Leave out on patio',
                'merchant_notes' => 'Fragile',
                'ship_by_date' => '2017-01-20T22:28:42Z',
                'deliver_by_date' => '2017-01-10T22:28:42Z',
                'items' => [
                    [
                        'order_item_ref' => 'test-123-ref',
                        'quantity' => 2,
                        'title' => 'Planet Earth DVD',
                        'sku' => '01230-01230-00',
                        'unit_price' => 100,
                        'price' => 100,
                        'total' => 202.08,
                        'quantity_fulfilled' => 1,
                        'inventory_sku' => 'planet-dvd-sku',
                        'tax' => 2.08,
                    ],
                ],
            ])
        );
    }

    // End public function testGetOrderApiRequest

    public function testGetOrderApiWithoutSbOrderSequenceNumber()
    {
        // Get the stored credentials
        $accountToken = 'M92hta0jasdg90';
        $secretKey = 'N9832nmg93';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining an error
        $mockClient->shouldReceive('request')
            ->andReturns(new \GuzzleHttp\Psr7\Response(
                401,
                ['Content-Type' => 'application/json'],
                "You couldn't be authenticated")
            );

        // Instantiate a new GetOrder API Object
        $getOrder = new GetOrder($accountToken, $secretKey, $mockClient);

        $sb_order_sequence = null;

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $jsonResponse = $getOrder->sendRequest($sb_order_sequence);

        $this->assertSame($json, "401 Unauthorized. You couldn't be authenticated because bad credentials was supplied.");
    }

    // End public function testGetOrderApiWithoutSbOrderSequenceNumber

    public function testGetOrderApiBadAuthShouldReturnAnException()
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

        // Instantiate a new GetOrder API Object
        $getOrder = new GetOrder($accountToken, $secretKey, $mockClient);

        $sb_order_sequence = 'M923ngmZp';

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $jsonResponse = $getOrder->sendRequest($sb_order_sequence);
    }

    // End public function testGetOrderApiBadAuthShouldReturnAnException

    public function testGetOrderApiRequestShouldReturnDefaultException()
    {
        // Get the stored credentials
        $accountToken = 'M09243hgm';
        $secretKey = '230gnam39';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining an error
        $mockClient->shouldReceive('request')
            ->andReturns(new \GuzzleHttp\Psr7\Response(
                400,
                ['Content-Type' => 'application/json'],
                'This is the default error.'
            )
        );

        // Instantiate a new GetOrder API Object
        $getOrder = new GetOrder($accountToken, $secretKey, $mockClient);

        $sb_order_sequence = 'M923ngmZp';

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $jsonResponse = $getOrder->sendRequest($sb_order_sequence);
    }

    // End public function testGetOrderApiRequestShouldReturnDefaultException
} // End class GetChannelsTest
