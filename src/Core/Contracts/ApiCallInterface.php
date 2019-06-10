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

namespace TrollAndToad\Sellbrite\Core\Contracts;

use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerAwareInterface;

/**
 * Interface for all API call objects. These objects are what communicate with the
 * Sellbrite API. They take a {@link \TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface}
 * request and return an instance of {@link \TrollAndToad\Sellbrite\Core\Contracts\ApiResponseInterface}
 * response. The API call is invoked via the {@link \TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface::sendRequest}
 * method.
 *
 * This interface also extends {@link \JsonSerializable} and {@link \Psr\Log\LoggerAwareInterface} so it can easily
 * be serialized as a JSON string for logging and debugging, adn can be outfitted with a PSR-3 compliant logger
 * implementation to log what is going on inside.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
interface ApiCallInterface extends Arrayable, Jsonable, LoggerAwareInterface
{
    /**
     * Set Sellbrite account token.
     *
     * @param string $token Account token
     *
     * @return \TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface
     */
    public function setAccountToken(string $token): ApiCallInterface;

    /**
     * Set Sellbrite account secret key.
     *
     * @param string $secretKey Secret key
     *
     * @return \TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface
     */
    public function setSecretKey(string $secretKey): ApiCallInterface;

    /**
     * Set {@link \GuzzleHttp\ClientInterface} instance to use.
     *
     * @param \GuzzleHttp\ClientInterface $client HTTP client interface
     *
     * @return \TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface
     */
    public function setHttpClient(ClientInterface $client): ApiCallInterface;

    /**
     * Set applications names.
     *
     * @param string $applicationName App name
     *
     * @return \TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface
     */
    public function setApplicationName(string $applicationName = ''): ApiCallInterface;

    /**
     * Send Sellbrite API request.
     *
     * @param ApiRequestInterface $request API Request type
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ApiCallException
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\InvalidRequestTypeException
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\CannotCreateResponseException
     *
     * @return \TrollAndToad\Sellbrite\Core\Contracts\ApiResponseInterface API response type
     */
    public function sendRequest(ApiRequestInterface $request): ApiResponseInterface;
}
