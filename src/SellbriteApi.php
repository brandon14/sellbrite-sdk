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

namespace TrollAndToad\Sellbrite;

use function count;
use function get_class;
use BadMethodCallException;
use TrollAndToad\Sellbrite\Core\ApiCall;
use TrollAndToad\Sellbrite\Core\ApiCallOptions;
use TrollAndToad\Sellbrite\Core\AbstractApiRequest;
use TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface;

/**
 * Facade to make all Sellbrite API call invocations from a single class. Can be thought of as
 * a sort of "facade" to interface with the SDK.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 *
 * @method static \TrollAndToad\Sellbrite\Channels\GetChannelResponse getChannels(\TrollAndToad\Sellbrite\Core\ApiCallOptions $options, \TrollAndToad\Sellbrite\Channels\GetChannelRequest $request)
 * @method static \TrollAndToad\Sellbrite\Inventory\GetAllInventoryResponse getAllInventory(\TrollAndToad\Sellbrite\Core\ApiCallOptions $options, \TrollAndToad\Sellbrite\Inventory\GetAllInventoryRequest $request)
 *
 * @todo Document all possible static functions.
 */
final class SellbriteApi
{
    /**
     * API caller class instance. Will be late statically bound.
     *
     * @var \TrollAndToad\Sellbrite\Core\ApiCall|null
     */
    private static $apiCall = null;

    /**
     * Handles static proxies to underlying SDK API requests by matching the method name to a specific
     * API call.
     *
     * {@inheritdoc}
     */
    public static function __callStatic(string $name, array $arguments)
    {
        // Ensure static function params meet the expected types.
        if (($count = count($arguments)) < 2) {
            self::throwBadMethodCall("Too few arguments supplied. Expected [2], received [{$count}].", $name);
        }

        // Invalid options class argument.
        if (! $arguments[0] instanceof ApiCallOptions) {
            $optionsClass = ApiCallOptions::class;
            $class = get_class($arguments[0]);
            self::throwBadMethodCall("Argument 1 should be of type [{$optionsClass}], received [{$class}].", $name);
        }

        /** @var \TrollAndToad\Sellbrite\Core\ApiCallOptions $options */
        $options = $arguments[0];
        $requestInterface = ApiRequestInterface::class;

        // Invalid request class argument.
        if (! $arguments[1] instanceof AbstractApiRequest) {
            $class = get_class($arguments[1]);
            self::throwBadMethodCall("Argument 2 should implement the interface [{$requestInterface}].", $name);
        }

        /** @var \TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface $request */
        $request = $arguments[1];

        // Create ApiCall static instance.
        if (self::$apiCall === null) {
            self::$apiCall = new ApiCall($options);
        }

        // Make API request.
        $response = self::$apiCall->sendRequest($request);

        return $response;
    }

    /**
     * Throws a {@link \BadMethodCallException} for a given error on a dynamic static method invocation.
     *
     * @param string $message Exception message
     * @param string $method  Method name
     *
     * @throws \BadMethodCallException
     *
     * @return void
     */
    private static function throwBadMethodCall(string $message, string $method): void
    {
        $class = __CLASS__;

        throw new BadMethodCallException("[{$class}::$method] $message");
    }
}
