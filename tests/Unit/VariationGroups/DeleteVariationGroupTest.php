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
use TrollAndToad\Sellbrite\VariationGroups\DeleteVariationGroup;

class DeleteVariationGroupTest extends TestCase
{
    public function testDeleteVariationGroupSuccessfullyDeleteAVariationGroup()
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
                'Succesfully deleted a variation group.'
            )
        );

        $sku = '1903275';

        // Create a new instance of DeleteProduct
        $deleteVariationGroup = new DeleteVariationGroup($accountToken, $secretKey, $mockClient);

        // Send the request and get the response object
        $responseStr = $deleteVariationGroup->sendRequest($sku);

        // Assert the returned JSON response matches the expected data
        $this->assertSame('Succesfully deleted a variation group.', $responseStr);
    }

    // End public function testPostProductSuccessfullyPostAProduct

    public function testDeleteVariationGroupNoSkuThrowsException()
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
                'You failed to supply a SKU.'
            )
        );

        $sku = '';

        // Create a new instance of DeleteProduct
        $deleteVariationGroup = new DeleteVariationGroup($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $responseStr = $deleteVariationGroup->sendRequest($sku);
    }

    // End public function testDeleteVariationGroupNoSkuThrowsException

    public function testDeleteVariationGroupBadCredentialsThrowsException()
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

        $sku = '20397hsga0';

        // Create a new instance of DeleteProduct
        $deleteVariationGroup = new DeleteVariationGroup($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $responseStr = $deleteVariationGroup->sendRequest($sku);
    }

    // End public function testDeleteVariationGroupBadCredentialsThrowsException

    public function testDeleteVariationGroupThrowDefaultException()
    {
        // Get the stored credentials
        $accountToken = 'a0sg0236has';
        $secretKey = 'banana32milkshake';

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

        $sku = '20397hsga0';

        // Create a new instance of DeleteProduct
        $deleteVariationGroup = new DeleteVariationGroup($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $responseStr = $deleteVariationGroup->sendRequest($sku);
    }

    // End public function testDeleteVariationGroupThrowDefaultException
} // End class DeleteVariationGroupTest
