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

use function trim;
use function ucfirst;
use function get_class;
use function mb_strtolower;
use function mb_strtoupper;
use function method_exists;
use Teapot\StatusCode\Http;
use Psr\Log\LoggerInterface;
use TrollAndToad\Sellbrite\Core\Concerns\IsJsonable;
use TrollAndToad\Sellbrite\Core\Concerns\HandlesLogging;
use TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface;
use TrollAndToad\Sellbrite\Core\Exceptions\CannotUnsetRequestPropertyException;

/**
 * Abstract class to group up all common functionality of {@link \TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface}
 * objects. Implements the methods found in the interface. This class should be used as the parent of any API request class
 * created.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
abstract class AbstractApiRequest implements ApiRequestInterface
{
    use HandlesLogging;
    use IsJsonable;

    /**
     * Request content type.
     *
     * @var string
     */
    protected const CONTENT_TYPE = 'application/json; charset=utf-8';

    /**
     * HTTP request method.
     *
     * @var string
     */
    protected const REQUEST_METHOD = 'GET';

    /**
     * Array of query params.
     *
     * @var array
     */
    protected $query = [];

    /**
     * Array of body params.
     *
     * @var array
     */
    protected $body = [];

    /**
     * Array of request headers.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Constructs a new AbstractApiRequest.
     *
     * **NOTE:**
     * Body and query param arrays should be an array of 'param_name' => 'param_value' pairs.
     * Headers should be array of 'header_name' => 'header_value' pairs.
     *
     * @param array                         $query   Array of query params
     * @param array                         $body    Array of post body params
     * @param array                         $headers Array of request headers
     * @param \Psr\Log\LoggerInterface|null $logger  Optional PSR-3 logger implementation
     *
     * @return void
     */
    public function __construct(
        array $query = [],
        array $body = [],
        array $headers = [],
        ?LoggerInterface $logger = null
    ) {
        $this->query = $query;
        $this->body = $body;
        $this->headers = $headers;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod(): string
    {
        return mb_strtoupper(trim(static::REQUEST_METHOD));
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType(): string
    {
        return mb_strtolower(trim(static::CONTENT_TYPE));
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody(): array
    {
        $method = $this->getMethod();

        // GET and OPTIONS methods should not have body.
        if ($method === 'GET' || $method === 'OPTIONS') {
            return [];
        }

        return $this->body;
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
    public function handleQuery()
    {
        return $this->getQuery();
    }

    /**
     * {@inheritdoc}
     */
    public function getSuccessCodes(): array
    {
        return [Http::OK];
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        // Force query, body and headers to be primitive types.
        $query = $this->jsonDecode($this->jsonEncode($this->getQuery()), true);
        $body = $this->jsonDecode($this->jsonEncode($this->getBody()), true);
        $headers = $this->jsonDecode($this->jsonEncode($this->getHeaders()), true);

        // Return array of request data.
        return [
            'class'          => static::class,
            'content_type'   => $this->getContentType(),
            'method'         => $this->getMethod(),
            'query'          => $query,
            'body'           => $body,
            'headers'        => $headers,
            'logger'         => $this->logger === null ? null : get_class($this->logger),
            'success_codes'  => $this->getSuccessCodes(),
            'response_class' => $this->getResponseClass(),
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
        // Proxy to public getter.
        $functionName = 'get'.ucfirst($offset);

        if (method_exists($this, $functionName)) {
            return $this->$functionName();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void
    {
        // Proxy to public setter.
        $functionName = 'set'.ucfirst($offset);

        if (method_exists($this, $functionName)) {
            $this->$functionName($value);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\CannotUnsetRequestPropertyException
     */
    public function offsetUnset($offset): void
    {
        throw CannotUnsetRequestPropertyException::createForProperty(static::class, $offset);
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
     */
    public function __unset($key): void
    {
        $this->offsetUnset($key);
    }
}
