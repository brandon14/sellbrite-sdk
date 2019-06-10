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

namespace TrollAndToad\Sellbrite\Test\Unit\VariationGroups;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use TrollAndToad\Sellbrite\VariationGroups\GetVariationGroup;

class GetVariationGroupTest extends TestCase
{
    public function testGetVariationGroupsSuccessfullyGetVariationGroups()
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
                '[{
                    "sku":"64_ctrl",
                    "name":"Nintendo 64 Controller",
                    "child_skus":[
                       "64_ctrl_grey",
                       "64_ctrl_red"
                    ],
                    "variation_attributes":[
                       "color"
                    ],
                    "description":"The best controller ever made!",
                    "images":[
                       "https://images.sellbrite.com/development/1/64_ctrl/e239693f-474b-53e8-81b1-ec940aa5e4b5.jpg"
                    ]
                 }]'
            )
        );

        $page = 1;
        $limit = 100;
        $skuArr = ['64_ctrl'];

        // Create a new instance of GetVariationGroup
        $getVariationGroup = new GetVariationGroup($accountToken, $secretKey, $mockClient);

        // Send the request and get the response object
        $response = $getVariationGroup->sendRequest($page, $limit, $skuArr);

        $responseJson = (string) $response->getBody();

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $responseJson,
            json_encode([
                [
                    'sku' => '64_ctrl',
                    'name' =>'Nintendo 64 Controller',
                    'child_skus' => [
                       '64_ctrl_grey',
                       '64_ctrl_red',
                    ],
                    'variation_attributes' => [
                       'color',
                    ],
                    'description' => 'The best controller ever made!',
                    'images' => [
                       'https://images.sellbrite.com/development/1/64_ctrl/e239693f-474b-53e8-81b1-ec940aa5e4b5.jpg',
                    ],
                ],
            ])
        );
    }

    // End public function testGetVariationGroupsSuccessfullyGetVariationGroups

    public function testGetVariationGroupsTestMaxLimit()
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
                '[{
                    "sku":"64_ctrl",
                    "name":"Nintendo 64 Controller",
                    "child_skus":[
                       "64_ctrl_grey",
                       "64_ctrl_red"
                    ],
                    "variation_attributes":[
                       "color"
                    ],
                    "description":"The best controller ever made!",
                    "images":[
                       "https://images.sellbrite.com/development/1/64_ctrl/e239693f-474b-53e8-81b1-ec940aa5e4b5.jpg"
                    ]
                 }]'
            )
        );

        $page = 1;
        $limit = 555;
        $skuArr = ['64_ctrl'];

        // Create a new instance of GetVariationGroup
        $getVariationGroup = new GetVariationGroup($accountToken, $secretKey, $mockClient);

        // Send the request and get the response object
        $response = $getVariationGroup->sendRequest($page, $limit, $skuArr);

        $responseJson = (string) $response->getBody();

        // Assert the returned JSON response matches the expected data
        $this->assertJsonStringEqualsJsonString(
            $responseJson,
            json_encode([
                [
                    'sku' => '64_ctrl',
                    'name' =>'Nintendo 64 Controller',
                    'child_skus' => [
                       '64_ctrl_grey',
                       '64_ctrl_red',
                    ],
                    'variation_attributes' => [
                       'color',
                    ],
                    'description' => 'The best controller ever made!',
                    'images' => [
                       'https://images.sellbrite.com/development/1/64_ctrl/e239693f-474b-53e8-81b1-ec940aa5e4b5.jpg',
                    ],
                ],
            ])
        );
    }

    // End public function testGetVariationGroupsTestMaxLimit

    public function testGetVariationBadCredentialsShouldThrowException()
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

        $page = 1;
        $limit = 555;
        $skuArr = ['64_ctrl'];

        // Create a new instance of GetVariationGroup
        $getVariationGroup = new GetVariationGroup($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $response = $getVariationGroup->sendRequest($page, $limit, $skuArr);
    }

    // End public function testGetVariationBadCredentialsShouldThrowException

    public function testGetVariationThrowDefaultException()
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
                405,
                ['Content-Type' => 'application/json'],
                'This is the default error.'
            )
        );

        $page = 1;
        $limit = 100;
        $skuArr = ['64_ctrl'];

        // Create a new instance of GetVariationGroup
        $getVariationGroup = new GetVariationGroup($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $response = $getVariationGroup->sendRequest($page, $limit, $skuArr);
    }

    // End public function testGetVariationThrowDefaultException
} // End class GetVariationGroupTest
