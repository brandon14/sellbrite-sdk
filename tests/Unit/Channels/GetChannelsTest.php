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

namespace TrollAndToad\Sellbrite\Test\Unit\Channels;

use function json_encode;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use TrollAndToad\Sellbrite\Core\ApiCallOptions;
use TrollAndToad\Sellbrite\Channels\GetChannels;
use TrollAndToad\Sellbrite\Channels\GetChannelsRequest;
use TrollAndToad\Sellbrite\Core\Exceptions\BadRequestException;
use TrollAndToad\Sellbrite\Core\Exceptions\UnauthorizedException;
use TrollAndToad\Sellbrite\Core\Exceptions\RateLimitExceededException;

// TODO: Add tests for accessing channel and response properties and more exception cases.

/**
 * TODO: Undocumented class.
 *
 * @author Samuel Stidham <sastidham@trollandtoad.com>
 */
class GetChannelsTest extends TestCase
{
    /**
     * TODO: Undocumented function.
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function testChannelsApiRequestReturnsGetChannelResponse(): void
    {
        // Get the stored credentials.
        $accountToken = 'this-is-a-token';
        $secretKey = 'secretkey';

        // Create a mock client object.
        $mockClient = $this->createMock(ClientInterface::class);
        $channels = [
            [
                'uuid'                      => 'test-uuid-1234-5678',
                'name'                      => 'Amazon Channel 1',
                'state'                     => 'active',
                'channel_type_display_name' => 'Amazon',
                'created_at'                => '2017-01-17T23:14:44+00:00',
                'site_id'                   => 'A1F83G8C2ARO7P',
                'channel_site_region'       => 'Amazon.co.uk (United Kingdom)',
            ],
        ];

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // containing JSON.
        $mockClient->expects($this::once())
            ->method('request')
            ->with('GET', 'https://api.sellbrite.com/v1/channels')
            ->willReturn(new Response(
                200,
                ['content-type' => 'application/json'],
                json_encode($channels)
            ));

        $opts = new ApiCallOptions($accountToken, $secretKey, $mockClient);

        // Instantiate a new GetChannels API Object.
        $getChannels = new GetChannels($opts);
        $request = new GetChannelsRequest();

        // Get the API response.
        /** @var \TrollAndToad\Sellbrite\Channels\GetChannelsResponse $apiResponse */
        $apiResponse = $getChannels->sendRequest($request);
        $responseChannels = $apiResponse->getChannels();
        $channelsCount = count($responseChannels);

        // Assert each channel object matches the channels we expect.
        for ($i = 0; $i < $channelsCount; ++$i) {
            $this::assertEquals($channels[$i], $responseChannels[$i]->toArray());
        }
    }

    /**
     * TODO: Undocumented function.
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function testChannelsApiBadCredentialsRequestShouldThrowException(): void
    {
        // Get the stored credentials.
        $accountToken = '';
        $secretKey = '';

        // Create a mock client object.
        $mockClient = $this->createMock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // containing an error.
        $mockClient->expects($this::once())
            ->method('request')
            ->with('GET', 'https://api.sellbrite.com/v1/channels')
            ->willReturn(new Response(
                401,
                ['content-type' => 'text/html'],
                'HTTP Basic: Access denied'
            ));

        $opts = new ApiCallOptions($accountToken, $secretKey, $mockClient);

        // Instantiate a new GetChannels API Object.
        $getChannels = new GetChannels($opts);

        // Expect a UnauthorizedException.
        $this->expectException(UnauthorizedException::class);

        $request = new GetChannelsRequest();
        // Send the request.
        $getChannels->sendRequest($request);
    }

    /**
     * TODO: Undocumented function.
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function testChannelsApiRequestShouldThrowExceptionOnErrorResponse(): void
    {
        // Get the stored credentials.
        $accountToken = 'this-is-a-token';
        $secretKey = 'secretkey';

        // Create a mock client object.
        $mockClient = $this->createMock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // containing an error.
        $mockClient->expects($this::once())
            ->method('request')
            ->with('GET', 'https://api.sellbrite.com/v1/channels')
            ->willReturn(new Response(
                400,
                ['Content-Type' => 'application/json'],
                json_encode(['error' => 'Bad request'])
            ));

        $opts = new ApiCallOptions($accountToken, $secretKey, $mockClient);

        // Instantiate a new GetChannels API Object.
        $getChannels = new GetChannels($opts);

        // Expect a BadRequestException from the request.
        $this->expectException(BadRequestException::class);

        $request = new GetChannelsRequest();
        // Send the request.
        $getChannels->sendRequest($request);
    }

    /**
     * TODO: Undocumented function.
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function testChannelsApiRequestThrowsRateLimitExceptionWhenRateLimited(): void
    {
        // Get the stored credentials.
        $accountToken = 'this-is-a-token';
        $secretKey = 'secretkey';

        // Create a mock client object.
        $mockClient = $this->createMock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // containing an error.
        $mockClient->expects($this::once())
            ->method('request')
            ->with('GET', 'https://api.sellbrite.com/v1/channels')
            ->willReturn(new Response(
                403,
                ['Content-Type' => 'text/html'],
                'Rate Limit Exceeded'
            ));

        $opts = new ApiCallOptions($accountToken, $secretKey, $mockClient);

        // Instantiate a new GetChannels API Object.
        $getChannels = new GetChannels($opts);

        // Expect a RateLimitExceededException from the request.
        $this->expectException(RateLimitExceededException::class);

        $request = new GetChannelsRequest();
        // Send the request.
        $getChannels->sendRequest($request);
    }
}
