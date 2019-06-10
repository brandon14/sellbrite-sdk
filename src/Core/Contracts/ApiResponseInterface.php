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

use ArrayAccess;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface for all API response objects. Response's represent the HTTP response of a Sellbrite
 * API call and this interface defines the common methods that will exists on every API response,
 * while each API response object may add other additional methods to help retrieve and interact
 * with the API response data.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
interface ApiResponseInterface extends ArrayAccess, Arrayable, Jsonable, LoggerAwareInterface
{
    /**
     * Get response status code.
     *
     * @return int response status code
     */
    public function getStatusCode(): int;

    /**
     * Get response content type.
     *
     * @return string Content type
     */
    public function getContentType(): string;

    /**
     * Get response headers.
     *
     * @return array Response headers
     */
    public function getHeaders(): array;

    /**
     * Get parsed response content.
     *
     * @return array Parsed content
     */
    public function getContent(): array;

    /**
     * Get raw response string.
     *
     * @return string Raw response
     */
    public function getRawContent(): string;

    /**
     * Create a new {@link \TrollAndToad\Sellbrite\Core\AbstractApiResponse} instance from the PSR-7 response.
     *
     * @param \Psr\Http\Message\ResponseInterface                        $response PSR-7 response instance
     * @param \TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface    $apiCall  Api call object
     * @param \TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface $request  Api request object
     * @param \Psr\Log\LoggerInterface|null                              $logger   Optional PSR-3 logger implementation
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\CannotCreateResponseException
     *
     * @return \TrollAndToad\Sellbrite\Core\Contracts\ApiResponseInterface Response instance
     */
    public static function create(
        ResponseInterface $response,
        ApiCallInterface $apiCall,
        ApiRequestInterface $request,
        ?LoggerInterface $logger = null
    ): ApiResponseInterface;
}
