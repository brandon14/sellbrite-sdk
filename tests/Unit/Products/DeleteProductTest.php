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
use TrollAndToad\Sellbrite\Products\DeleteProduct;

class DeleteProductTest extends TestCase
{
    public function testDeleteProductSuccessfullyDeleteAProduct()
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
                'Succesfully deleted product.'
            )
        );

        $sku = '1903275';

        // Create a new instance of DeleteProduct
        $deleteProduct = new DeleteProduct($accountToken, $secretKey, $mockClient);

        // Send the request and get the response object
        $responseStr = $deleteProduct->sendRequest($sku);

        // Assert the returned JSON response matches the expected data
        $this->assertSame('Succesfully deleted product.', $responseStr);
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

        // Instantiate a new GetChannels API Object
        $deleteProduct = new DeleteProduct($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $response = $deleteProduct->sendRequest($sku);
    }

    // End public function testPostProductNotProvidingASkuShouldReturnAnException

    public function testPostProductProvidingBadCredentialsThrowsException()
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

        $sku = '12377892';

        // Instantiate a new GetChannels API Object
        $deleteProduct = new DeleteProduct($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $response = $deleteProduct->sendRequest($sku);
    }

    // End public function testPostProductProvidingBadCredentialsThrowsException

    public function testPostProductThrowDefaultException()
    {
        // Get the stored credentials
        $accountToken = 'a2906ynasdl';
        $secretKey = '23zmi02607gh';

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

        $sku = '12377892';

        // Instantiate a new GetChannels API Object
        $deleteProduct = new DeleteProduct($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and store the response
        $response = $deleteProduct->sendRequest($sku);
    }

    // End public function testPostProductThrowDefaultException
} // End class DeleteProductTest
