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

namespace TrollAndToad\Sellbrite\Core;

use function ucfirst;
use function get_class;
use function mb_strpos;
use function method_exists;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface;
use TrollAndToad\Sellbrite\Core\Concerns\IsJsonable;
use TrollAndToad\Sellbrite\Core\Concerns\HandlesLogging;
use TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface;
use TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface;
use TrollAndToad\Sellbrite\Core\Contracts\ApiResponseInterface;
use TrollAndToad\Sellbrite\Core\Exceptions\ImmutableResponsePropertyException;

/**
 * Abstract class to group together all common functionality for {@link \TrollAndToad\Sellbrite\Core\Contracts\ApiResponseInterface}
 * objects. All API response objects should extend this class. Each specific API response class will have to implement the
 * {@link \TrollAndToad\Sellbrite\Core\AbstractApiResponse::create()} method and can add additional methods to make interacting
 * with the response data easier.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
abstract class AbstractApiResponse implements ApiResponseInterface
{
    use HandlesLogging;
    use IsJsonable;

    /**
     * API call instance.
     *
     * @var \TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface
     */
    protected $caller;

    /**
     * API request object.
     *
     * @var \TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface
     */
    protected $request;

    /**
     * Response status code.
     *
     * @var int
     */
    protected $statusCode;

    /**
     * Response content type.
     *
     * @var string
     */
    protected $contentType;

    /**
     * Response headers.
     *
     * @var array
     */
    protected $headers;

    /**
     * Decoded response content.
     *
     * @var array
     */
    protected $content;

    /**
     * Raw response body.
     *
     * @var string
     */
    protected $rawContent;

    /**
     * Constructs a new AbstractApiResponse.
     *
     * @param \Psr\Http\Message\ResponseInterface                        $response PSR-7 response interface
     * @param \TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface    $apiCall  Api call object
     * @param \TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface $request  Api request object
     * @param \Psr\Log\LoggerInterface|null                              $logger   Optional PSR-3 logger implementation
     *
     * @return void
     */
    protected function __construct(
        ResponseInterface $response,
        ApiCallInterface $apiCall,
        ApiRequestInterface $request,
        ?LoggerInterface $logger = null
    ) {
        $this->caller = $apiCall;
        $this->request = $request;
        $this->logger = $logger;

        // Get response data applicable to all API calls.
        $this->statusCode = (int) $response->getStatusCode();
        $this->contentType = $response->hasHeader('content-type')
            ? (string) $response->getHeader('content-type')[0] // First content-type header entry
            : 'text/plain';
        $this->headers = $response->getHeaders();
        // Set raw string HTTP response.
        $this->rawContent = (string) $response->getBody();

        // Check for JSON content in response and parse it, otherwise treat as a plain text response.
        $this->content = mb_strpos($this->contentType, '/json') !== false
            ? $this->jsonDecode($this->rawContent, true)
            // Wrap string/non-JSON content in a content key so we always set content to an array.
            : ['content' => $this->rawContent];
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function getRawContent(): string
    {
        return $this->rawContent;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        // Return array of response data.
        return [
            'class'        => static::class,
            'status_code'  => $this->getStatusCode(),
            'content_type' => $this->getContentType(),
            'headers'      => $this->getHeaders(),
            'content'      => $this->getContent(),
            'raw_content'  => $this->getRawContent(),
            'logger'       => $this->logger === null ? null : get_class($this->logger),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset): bool
    {
        return method_exists($this, 'get'.ucfirst($offset))
            && $this->$offset !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        $functionName = 'get'.ucfirst($offset);

        if (method_exists($this, $functionName)) {
            return $this->$functionName();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ImmutableResponsePropertyException
     */
    public function offsetSet($offset, $value): void
    {
        throw new ImmutableResponsePropertyException($offset);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ImmutableResponsePropertyException
     */
    public function offsetUnset($offset): void
    {
        throw new ImmutableResponsePropertyException($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ImmutableResponsePropertyException
     */
    public function __set($key, $value): void
    {
        $this->offsetSet($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function __isset($key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ImmutableResponsePropertyException
     */
    public function __unset($key): void
    {
        $this->offsetUnset($key);
    }
}
