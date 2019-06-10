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

use ArrayAccess;
use function trim;
use GuzzleHttp\Client;
use function strip_tags;
use function preg_replace;
use Psr\Log\LoggerInterface;
use GuzzleHttp\ClientInterface;
use TrollAndToad\Sellbrite\Core\Contracts\Jsonable;
use TrollAndToad\Sellbrite\Core\Concerns\IsJsonable;
use TrollAndToad\Sellbrite\Core\Contracts\Arrayable;
use TrollAndToad\Sellbrite\Core\Exceptions\ImmutableApiCallOptionsException;

/**
 * Options for the Sellbrite SDK api calls. Used to configure the Sellbrite SDK.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
final class ApiCallOptions implements ArrayAccess, Arrayable, Jsonable
{
    use IsJsonable;

    /**
     * Guzzle client implementation.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    private $httpClient;

    /**
     * PSR-3 logger instance.
     *
     * @var \Psr\Log\LoggerInterface|null
     */
    private $logger;

    /**
     * Sellbrite API account token.
     *
     * @var string
     */
    private $accountToken;

    /**
     * Sellbrite API secret key.
     *
     * @var string
     */
    private $secretKey;

    /**
     * Optional application name to send in useragent.
     *
     * @var string
     */
    private $applicationName;

    /**
     * Constructor for an Api call options.
     *
     * @param string                           $accountToken    Sellbrite account API token
     * @param string                           $secretKey       Sellbrite account API secrete key
     * @param \GuzzleHttp\ClientInterface|null $httpClient      Guzzle client implementation
     * @param \Psr\Log\LoggerInterface|null    $logger          PSR-3 logger implementation
     * @param string                           $applicationName Optional application name
     *
     * @return void
     */
    public function __construct(
        string $accountToken,
        string $secretKey,
        ?ClientInterface $httpClient = null,
        ?LoggerInterface $logger = null,
        string $applicationName = ''
    ) {
        $this->accountToken = $accountToken;
        $this->secretKey = $secretKey;

        // Set up provided Guzzle client or use a default Guzzle client if not provided.
        $this->httpClient = $httpClient ?? new Client();

        // Set up logger if provided.
        if ($logger !== null) {
            $this->logger = $logger;
        }

        // Trim and escape user-supplied application name.
        if ($applicationName !== '') {
            $applicationName = strip_tags(trim($applicationName, " \t"));
            $applicationName = preg_replace('/ {2,}|\s/', ' ', $applicationName);
            $applicationName = preg_replace('/\\\\/', '\\\\\\\\', $applicationName);
            $applicationName = preg_replace('/\//', '\\/', $applicationName);
        }

        $this->applicationName = $applicationName;
    }

    /**
     * Get Sellbrite account token.
     *
     * @return string Account token
     */
    public function getAccountToken(): string
    {
        return $this->accountToken;
    }

    /**
     * Get Sellbrite secret key.
     *
     * @return string Secret key
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * Get HTTP client instance.
     *
     * @return \GuzzleHttp\ClientInterface HTTP client instance
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * Get PSR-3 logger instance.
     *
     * @return \Psr\Log\LoggerInterface|null Logger instance, or null
     */
    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Get application name.
     *
     * @return string Application name
     */
    public function getApplicationName(): string
    {
        return $this->applicationName;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        // Return array of options data.
        return [
            'application_name' => $this->getApplicationName(),
            'account_token'    => $this->getAccountToken(),
            'secret_key'       => $this->getSecretKey(),
            'http_client'      => get_class($this->getHttpClient()),
            'logger'           => $this->logger === null ? null : get_class($this->logger),
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
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ImmutableApiCallOptionsException
     */
    public function offsetSet($offset, $value): void
    {
        // Cannot mutate ApiCallOptions.
        throw ImmutableApiCallOptionsException::create($offset);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ImmutableApiCallOptionsException
     */
    public function offsetUnset($offset): void
    {
        // Cannot mutate ApiCallOptions.
        throw ImmutableApiCallOptionsException::create($offset);
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
