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

use Throwable;
use const PHP_OS;
use function key;
use function is_a;
use function count;
use Psr\Log\LogLevel;
use const PHP_VERSION;
use function in_array;
use function is_array;
use function get_class;
use function php_uname;
use function mb_strpos;
use function mb_strtoupper;
use Teapot\StatusCode\Http;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\BadResponseException;
use TrollAndToad\Sellbrite\Core\Concerns\IsJsonable;
use TrollAndToad\Sellbrite\Core\Concerns\HandlesLogging;
use TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface;
use TrollAndToad\Sellbrite\Core\Exceptions\ApiCallException;
use TrollAndToad\Sellbrite\Core\Exceptions\ConflictException;
use TrollAndToad\Sellbrite\Core\Exceptions\NotFoundException;
use TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface;
use TrollAndToad\Sellbrite\Core\Exceptions\BadRequestException;
use TrollAndToad\Sellbrite\Core\Contracts\ApiResponseInterface;
use TrollAndToad\Sellbrite\Core\Exceptions\BadGatewayException;
use TrollAndToad\Sellbrite\Core\Exceptions\UnauthorizedException;
use TrollAndToad\Sellbrite\Core\Exceptions\RateLimitExceededException;
use TrollAndToad\Sellbrite\Core\Exceptions\InternalServerErrorException;
use TrollAndToad\Sellbrite\Core\Exceptions\UnprocessableEntityException;
use TrollAndToad\Sellbrite\Core\Exceptions\CannotCreateResponseException;

/**
 * Base ApiCall class. Most of the SDK logic resides here, and this class is tasked with taking
 * an {@link \TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface} and making the HTTP
 * request and transforming the data into an {@link \TrollAndToad\Sellbrite\Core\Contracts\ApiResponseInterface}.
 * The response will is determined by the request type.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
final class ApiCall implements ApiCallInterface
{
    use HandlesLogging;
    use IsJsonable;

    /**
     * API SDK version.
     *
     * @var string
     */
    private const SDK_VERSION = '2.0.0';

    /**
     * Base URI for Sellbrite API v1.
     *
     * @var string
     */
    private const BASE_URI = 'https://api.sellbrite.com';

    /**
     * Default Sellbrite API version.
     *
     * @var string
     */
    private const API_VERSION = '1';

    /**
     * API account token.
     *
     * @var string
     */
    private $accountToken;

    /**
     * API secret key.
     *
     * @var string
     */
    private $secretKey;

    /**
     * Base headers to send with every API request.
     *
     * @var array
     */
    private $baseHeaders;

    /**
     * Guzzle client implementation.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    private $httpClient;

    /**
     * Constructor for an abstract API call class.
     *
     * @param \TrollAndToad\Sellbrite\Core\ApiCallOptions $options Api options
     *
     * @return void
     */
    public function __construct(ApiCallOptions $options)
    {
        $this->setAccountToken($options->getAccountToken())
            ->setSecretKey($options->getSecretKey())
            ->setApplicationName($options->getApplicationName())
            ->setHttpClient($options->getHttpClient());

        $this->logger = $options->getLogger();
    }

    /**
     * {@inheritdoc}
     */
    public function setAccountToken(string $token): ApiCallInterface
    {
        $this->accountToken = $token;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSecretKey(string $secretKey): ApiCallInterface
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setHttpClient(ClientInterface $client): ApiCallInterface
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setApplicationName(string $applicationName = ''): ApiCallInterface
    {
        // Build user agent header.
        $this->baseHeaders = [
            'user-agent' => $this->buildUserAgent($applicationName),
        ];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(ApiRequestInterface $request): ApiResponseInterface
    {
        // Build the API endpoint.
        $url = $this->getApiUri($request);

        $query = $request->getQuery();
        $body = $request->getBody();
        $headers = $request->getHeaders();

        // Set up request headers.
        $requestParams = [
            'headers' => array_merge($this->baseHeaders, $headers),
            // Set up basic auth with token and secret.
            'auth' => [
                $this->accountToken,
                $this->secretKey,
                'basic',
            ],
        ];

        // Handle query params if present.
        if (count($query) > 0) {
            $requestParams['query'] = $request->handleQuery($query);
        }

        // Handle body params if present.
        if (count($body) > 0) {
            $requestParams = $this->handleBody($body, $requestParams, $request->getContentType());
        }

        // Make HTTP request to API.
        $response = $this->makeApiCall($url, $requestParams, $request->getMethod());

        $this->log(
            'API response received.',
            LogLevel::INFO,
            ['request' => $request->toArray(), 'psr7_response' => $response]
        );

        // Get the status code returned with the response
        $statusCode = (int) $response->getStatusCode();

        // Check that the response code is one of the API endpoints successful codes.
        if (! in_array($statusCode, $request->getSuccessCodes(), true)) {
            $this->handleErrorResponse($response);
        }

        /** @var \TrollAndToad\Sellbrite\Core\AbstractApiResponse $class */
        $class = $request->getResponseClass();

        // Return specific api response type.
        if (is_a($class, AbstractApiResponse::class, true)) {
            $this->log("Creating response object of type [{$class}].", LogLevel::DEBUG);

            return $class::create($response, $this, $request, $this->logger);
        }

        $message = "Unable to create response of type [{$class}].";

        $this->log(
            $message,
            LogLevel::ERROR,
            ['request' => $request->toArray(), 'response' => $response, 'class' => $class]
        );

        throw CannotCreateResponseException::create(static::class, $message);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        // Return array representing API call object.
        return [
            'class'                  => static::class,
            'sdk_version'            => self::SDK_VERSION,
            'base_uri'               => self::BASE_URI,
            'api_version'            => 'v'.self::API_VERSION,
            'user_agent'             => $this->baseHeaders['user-agent'] ?? 'Unknown.',
            'http_client'            => get_class($this->httpClient),
            'logger'                 => $this->logger === null ? null : get_class($this->logger),
            'account_token'          => $this->accountToken,
            'secret_key'             => $this->secretKey,
            'base_headers'           => $this->baseHeaders,
        ];
    }

    /**
     * Build user agent header string for SDK.
     *
     * @param string $applicationName Optional user-supplied application name
     *
     * @return string User agent string
     */
    private function buildUserAgent(string $applicationName = ''): string
    {
        $sdkVersion = self::SDK_VERSION;
        $phpVersion = 'PHP/'.PHP_VERSION.'; '.PHP_OS.'/'.php_uname('m').'/'.php_uname('r');

        return "trollandtoad/sellbrite v{$sdkVersion} ("
            .($applicationName !== ''? "{$applicationName}; " : '')
            ."{$phpVersion})";
    }

    /**
     * Get the full URI to a Sellbrite endpoint.
     *
     * @param \TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface $request API request instance
     *
     * @return string Full API URI
     */
    private function getApiUri(ApiRequestInterface $request): string
    {
        return self::BASE_URI.'/v'.self::API_VERSION."/{$request->getUri()}";
    }

    /**
     * Wrapper function to make Guzzle HTTP call and catch any exception to rethrow as
     * a {@link \TrollAndToad\Sellbrite\Core\ApiCallException}.
     *
     * @param string $url           URL to request
     * @param array  $requestParams Array of request params
     * @param string $method        Request method
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ApiCallException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function makeApiCall(string $url, array $requestParams, string $method = 'GET'): ResponseInterface
    {
        try {
            $method = mb_strtoupper($method);
            $this->log(
                "Making Sellbrite API call to [{$method}: {$url}].",
                LogLevel::DEBUG,
                [
                    'method' => $method,
                    'uri' => $url,
                    'request_params' => $requestParams,
                ]
            );

            // Send the HTTP request to the API endpoint and get the PSR-7 response.
            return $this->httpClient->request($method, $url, $requestParams);
        } catch (BadResponseException $br) {
            // Treat Guzzle BadResponse exceptions as failed requests (i.e. a 500 response, 400, 401, etc).
            $response = $br->getResponse();
            $summary = BadResponseException::getResponseBodySummary($response);

            $this->log("Handling Guzzle HTTP exception [{$summary}].", LogLevel::ERROR, ['exception' => $br]);

            $this->handleErrorResponse($response);
        } catch (Throwable $t) {
            // Some other exception was thrown during the HTTP call. Treat it as a generic ApiCallException.
            $message = "Caught exception during HTTP request [{$t->getMessage()}].";

            $this->log($message, LogLevel::ERROR, ['exception' => $t]);

            // Rethrow as ApiCallException.
            throw ApiCallException::create(static::class, $message, (int) $t->getCode(), $t);
        }
    }

    /**
     * Handle a non-successful API response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response PSR-7 response
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ApiCallException
     *
     * @return void
     */
    private function handleErrorResponse(ResponseInterface $response): void
    {
        $code = (int) $response->getStatusCode();
        $contentType = $response->hasHeader('content-type') ? $response->getHeader('content-type')[0] : null;

        $this->log(
            "Handling error response from Sellbrite API, returned status code [{$code}].",
            LogLevel::WARNING,
            ['response' => $response]
        );

        // Parse JSON if content-type is JSON, otherwise use raw body string as error message.
        // Some Sellbrite API calls can return a plain text response (i.e. 403 for rate limiting).
        $body = mb_strpos($contentType, '/json') !== false
            ? $this->jsonDecode($response->getBody()->getContents(), true)
            : ['error' => $response->getBody()->getContents()];

        $this->handleErrorResponseCode($code, $body);
    }

    /**
     * Handle which exception to throw based on the HTTP response code from the API.
     *
     * @param int   $code HTTP code
     * @param array $body HTTP request body parsed as array
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ApiCallException
     *
     * @return void
     */
    private function handleErrorResponseCode(int $code, array $body): void
    {
        // Handle response code specific exceptions.
        switch ($code) {
            case Http::BAD_REQUEST:
                throw BadRequestException::create(static::class, $body['error'] ?? '400 Bad request.');
            case Http::UNAUTHORIZED:
                throw UnauthorizedException::create(static::class);
            case Http::FORBIDDEN:
                throw RateLimitExceededException::create(static::class);
            case Http::NOT_FOUND:
                throw NotFoundException::create(static::class, $body['error'] ?? '404 Not found.');
            case Http::CONFLICT:
                throw ConflictException::create(static::class, $body['error'] ?? '409 Conflict.');
            case Http::UNPROCESSABLE_ENTITY:
                // Some Sellbrite API calls can return a 422 on a specific field, where the field is the key in
                // the error object and the validation message is the value.
                if (is_array($body['error'])) {
                    $field = key($body['error']) ?? 'Unknown field';
                    $message = isset($body['error'][$field]) ? "{$field} {$body['error'][$field]}" : ' is invalid.';
                }

                throw UnprocessableEntityException::create(
                    static::class,
                    $message ?? $body['error'] ?? '422 Unprocessable entity.'
                );
            case Http::INTERNAL_SERVER_ERROR:
                throw InternalServerErrorException::create(
                    static::class,
                    $body['error'] ?? '500 Internal server error.'
                );
            case Http::BAD_GATEWAY:
                throw BadGatewayException::create(static::class, $body['error'] ?? '502 Bad gateway.');
            default:
                // Default to generic ApiCallException.
                throw ApiCallException::create(static::class, $body['error'] ?? 'Unknown error occurred.');
        }
    }

    /**
     * Handle body params depending on the request content type.
     *
     * @param array  $body          Body params
     * @param array  $requestParams Original Guzzle request params array
     * @param string $contentType   Request content type
     *
     * @return array Guzzle request params array
     */
    private function handleBody(array $body, array $requestParams, string $contentType): array
    {
        // Handle request params based on the content type of the body.
        if (mb_strpos($contentType, '/json') !== false) {
            $requestParams['json'] = $body;

            return $requestParams;
        }

        if ($contentType === 'application/x-www-form-urlencoded') {
            $requestParams['form_params'] = $body;

            return $requestParams;
        }

        if ($contentType === 'multipart/form-data') {
            $requestParams['multipart'] = $body;

            return $requestParams;
        }

        $requestParams['body'] = [];

        return $requestParams;
    }
}
