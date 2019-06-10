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
use Psr\Log\LoggerAwareInterface;

/**
 * Interface to define common functionality of all API request objects. All requests are
 * composed of query params and body params, which will be sent through the {@link \GuzzleHttp\ClientInterface}
 * instance. Some API's may not require query or body params or either. Additionally, specific
 * request types will add additional methods to make configuring the API params easier.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
interface ApiRequestInterface extends ArrayAccess, Arrayable, Jsonable, LoggerAwareInterface
{
    /**
     * Get request HTTP method as an uppercased string.
     *
     * @return string Request method
     */
    public function getMethod(): string;

    /**
     * Get request content type. Returns it as a lower cased string.
     *
     * @return string Content type
     */
    public function getContentType(): string;

    /**
     * Get array of request query params.
     *
     * @return array Query params
     */
    public function getQuery(): array;

    /**
     * Get request body params.
     *
     * @return array Body params
     */
    public function getBody(): array;

    /**
     * Get request headers.
     *
     * @return array Headers
     */
    public function getHeaders(): array;

    /**
     * Gets request URI.
     *
     * @return string URI
     */
    public function getUri(): string;

    /**
     * Get the associated response class for a given API request.
     *
     * @return string Response class
     */
    public function getResponseClass(): string;

    /**
     * Get the successful response codes appropriate to the specific API request.
     *
     * @return array
     */
    public function getSuccessCodes(): array;

    /**
     * Transform the query parameters to be used by the {@link \GuzzleHttp\ClientInterface}
     * to make the HTTP request.
     *
     * @return string|array
     */
    public function handleQuery();
}
