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
use TrollAndToad\Sellbrite\Inventory\PatchInventory;

class PatchInventoryTest extends TestCase
{
    public function testPatchInventoryApiCallSuccessfullyUpdateItems()
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
                    "body": "Request received"
                }'
            )
        );

        $inventoryArray = [
            'inventory' => [
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
            ],
        ];

        // Instantiate a new PatchInventory API Object
        $patchInventory = new PatchInventory($accountToken, $secretKey, $mockClient);

        // Get the JSON response from the request
        $responseStr = $patchInventory->sendRequest($inventoryArray);

        $this->assertSame($responseStr, 'Request received');
    }

    // End public function testPatchInventoryApiCallSuccessfullyUpdateItems

    public function testPatchInventoryApiCallMoreThan50ItemsError()
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
                    "body": "Request received"
                }'
            )
        );

        $inventoryArray = [
            'inventory' => [
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
                [
                    'sku' => 'JL1141234',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 4,
                    'available' => 4,
                    'bin_location' => 'CR3M-89MN-0P',
                ],
                [
                    'sku' => 'AL11A1M3BC',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 9,
                    'available' => 9,
                    'bin_location' => 'TMZN-NN331',
                ],
                [
                    'sku' => 'P3920NMI3',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 6,
                    'available' => 6,
                    'bin_location' => 'ABC-DE3-FG1M3N',
                ],
            ],
        ];

        // Instantiate a new PatchInventory API Object
        $patchInventory = new PatchInventory($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Get the JSON response from the request
        $responseStr = $patchInventory->sendRequest($inventoryArray);
    }

    // End public function testPatchInventoryApiCallMoreThan50ItemsError

    public function testPatchInventoryApiCallBadAuthentication()
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
                ['Content-Type' => 'text/html'],
                'HTTP Basic: Access denied.'
            )
        );

        $inventoryArray = [
            'inventory' => [
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
            ],
        ];

        // Instantiate a new PatchInventory API Object
        $patchInventory = new PatchInventory($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request
        $response = $patchInventory->sendRequest($inventoryArray);
    }

    // End public function testPatchInventoryApiCallBadAuthentication

    public function testPatchInventoryApiCallBadRequestDefaultError()
    {
        // Get the stored credentials
        $accountToken = 'M2930ng';
        $secretKey = 'MNzmcme982n';

        // Create a mock client object
        $mockClient = \Mockery::mock(ClientInterface::class);

        // The mock client should receive a request call and it should return at PSR-7 Response object
        // cotaining JSON
        $mockClient->shouldReceive('request')->andReturns(
            new Response(
                400,
                ['Content-Type' => 'application/json'],
                'This is the default error.'
            )
        );

        $inventoryArray = [
            'inventory' => [
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a8431234-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
            ],
        ];

        // Instantiate a new PatchInventory API Object
        $patchInventory = new PatchInventory($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request
        $response = $patchInventory->sendRequest($inventoryArray);
    }

    // End public function testPatchInventoryApiCallBadRequestDefaultError

    public function testPatchInventoryApiCallBadWarehouseUuid()
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
                404,
                ['Content-Type' => 'application/json'],
                '{ "error": "Warehouse not found" }'
            )
        );

        $inventoryArray = [
            'inventory' => [
                [
                    'sku' => 'L11M311354',
                    'description' => 'This is a description.',
                    'warehouse_uuid' => 'a843134-9e24-479c-abf4-1234d5861234',
                    'on_hand' => 1,
                    'available' => 1,
                    'bin_location' => 'AM-33-1MNZ2',
                ],
            ],
        ];

        // Instantiate a new PatchInventory API Object
        $patchInventory = new PatchInventory($accountToken, $secretKey, $mockClient);

        // Expect an exception from the request
        $this->expectException(\Exception::class);

        // Send the request
        $response = $patchInventory->sendRequest($inventoryArray);
    }

    // End public function testPatchInventoryApiCallBadWarehouseUuid
} // End class PatchInventoryTest
