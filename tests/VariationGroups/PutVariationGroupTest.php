<?php

declare(strict_types=1);

namespace dqfan2012\Sellbrite\Test\VariationGroups;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use dqfan2012\Sellbrite\VariationGroups\PutVariationGroup;

class PutVariationGroupTest extends TestCase
{
    public function testPutVariationGroupsSuccessfullyPutVariationGroup()
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

        $sku  = '64_ctrl';
        $name = 'Nintendo 64 Controller';

        $childSKUs = [
            '64_ctrl_grey',
            '64_ctrl_red'
        ];

        $variationAttr = [
            'color'
        ];

        $description = 'The best controller ever made!';

        $images = [
            "https://images.sellbrite.com/development/1/64_ctrl/e239693f-474b-53e8-81b1-ec940aa5e4b5.jpg"
        ];

        // Create a new instance of PutVariationGroup
        $putVariationGroup = new PutVariationGroup($accountToken, $secretKey, $mockClient);

        // Send the request and get the response object
        $response = $putVariationGroup->sendRequest(
            $sku,
            $name,
            $childSKUs,
            $variationAttr,
            $description,
            $images
        );

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
                       '64_ctrl_red'
                    ],
                    'variation_attributes' => [
                       'color'
                    ],
                    'description' => 'The best controller ever made!',
                    'images' => [
                       'https://images.sellbrite.com/development/1/64_ctrl/e239693f-474b-53e8-81b1-ec940aa5e4b5.jpg'
                    ]
                ]
            ])
        );
    } // End public function testGetVariationGroupsSuccessfullyGetVariationGroups

    public function testPutVariationGroupsThrowSkuException()
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
                'You failed to supply a SKU.'
            )
        );

        $sku  = '';
        $name = 'Nintendo 64 Controller';

        $childSKUs = [
            '64_ctrl_grey',
            '64_ctrl_red'
        ];

        $variationAttr = [
            'color'
        ];

        $description = 'The best controller ever made!';

        $images = [
            "https://images.sellbrite.com/development/1/64_ctrl/e239693f-474b-53e8-81b1-ec940aa5e4b5.jpg"
        ];

        // Create a new instance of PutVariationGroup
        $putVariationGroup = new PutVariationGroup($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $response = $putVariationGroup->sendRequest(
            $sku,
            $name,
            $childSKUs,
            $variationAttr,
            $description,
            $images
        );
    } // End public function testPutVariationGroupsThrowSkuException

    public function testPutVariationGroupsThrowNameException()
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
                'You have to provide a name for the variation group.'
            )
        );

        $sku  = '64_ctrl';
        $name = '';

        $childSKUs = [
            '64_ctrl_grey',
            '64_ctrl_red'
        ];

        $variationAttr = [
            'color'
        ];

        $description = 'The best controller ever made!';

        $images = [
            "https://images.sellbrite.com/development/1/64_ctrl/e239693f-474b-53e8-81b1-ec940aa5e4b5.jpg"
        ];

        // Create a new instance of PutVariationGroup
        $putVariationGroup = new PutVariationGroup($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $response = $putVariationGroup->sendRequest(
            $sku,
            $name,
            $childSKUs,
            $variationAttr,
            $description,
            $images
        );
    } // End public function testPutVariationGroupsThrowNameException

    public function testPutVariationGroupsThrowChildSkusException()
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
                'You have to provide a name for the variation group.'
            )
        );

        $sku  = '64_ctrl';
        $name = 'Nintendo 64 Controller';

        $childSKUs = [];

        $variationAttr = [
            'color'
        ];

        $description = 'The best controller ever made!';

        $images = [
            "https://images.sellbrite.com/development/1/64_ctrl/e239693f-474b-53e8-81b1-ec940aa5e4b5.jpg"
        ];

        // Create a new instance of PutVariationGroup
        $putVariationGroup = new PutVariationGroup($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $response = $putVariationGroup->sendRequest(
            $sku,
            $name,
            $childSKUs,
            $variationAttr,
            $description,
            $images
        );
    } // End public function testPutVariationGroupsThrowChildSkusException

    public function testPutVariationGroupsThrowVariationAttrsException()
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
                'You have to provide a name for the variation group.'
            )
        );

        $sku  = '64_ctrl';
        $name = 'Nintendo 64 Controller';

        $childSKUs = [
            '64_ctrl_grey',
            '64_ctrl_red'
        ];

        $variationAttr = [];

        $description = 'The best controller ever made!';

        $images = [
            "https://images.sellbrite.com/development/1/64_ctrl/e239693f-474b-53e8-81b1-ec940aa5e4b5.jpg"
        ];

        // Create a new instance of PutVariationGroup
        $putVariationGroup = new PutVariationGroup($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $response = $putVariationGroup->sendRequest(
            $sku,
            $name,
            $childSKUs,
            $variationAttr,
            $description,
            $images
        );
    } // End public function testPutVariationGroupsThrowVariationAttrsException

    public function testPutVariationGroupsThrowBadCredentialsException()
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

        $sku  = '64_ctrl';
        $name = 'Nintendo 64 Controller';

        $childSKUs = [
            '64_ctrl_grey',
            '64_ctrl_red'
        ];

        $variationAttr = [
            'color'
        ];

        $description = 'The best controller ever made!';

        $images = [
            "https://images.sellbrite.com/development/1/64_ctrl/e239693f-474b-53e8-81b1-ec940aa5e4b5.jpg"
        ];

        // Create a new instance of PutVariationGroup
        $putVariationGroup = new PutVariationGroup($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $response = $putVariationGroup->sendRequest(
            $sku,
            $name,
            $childSKUs,
            $variationAttr,
            $description,
            $images
        );
    } // End public function testPutVariationGroupsThrowVariationAttrsException

    public function testPutVariationGroupsThrowDefaultException()
    {
        // Get the stored credentials
        $accountToken = '0923ga026098ygt';
        $secretKey    = 'asd0g920697h';

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

        $sku  = '64_ctrl';
        $name = 'Nintendo 64 Controller';

        $childSKUs = [
            '64_ctrl_grey',
            '64_ctrl_red'
        ];

        $variationAttr = [
            'color'
        ];

        $description = 'The best controller ever made!';

        $images = [
            "https://images.sellbrite.com/development/1/64_ctrl/e239693f-474b-53e8-81b1-ec940aa5e4b5.jpg"
        ];

        // Create a new instance of PutVariationGroup
        $putVariationGroup = new PutVariationGroup($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request and get the response object
        $response = $putVariationGroup->sendRequest(
            $sku,
            $name,
            $childSKUs,
            $variationAttr,
            $description,
            $images
        );
    } // End public function testPutVariationGroupsThrowDefaultException
} // End class PutVariationGroupTest
