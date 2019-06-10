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

use function gettype;
use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface;
use TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface;
use TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface;
use TrollAndToad\Sellbrite\Core\Exceptions\PageOutOfRangeException;
use TrollAndToad\Sellbrite\Core\Exceptions\InvalidRequestTypeException;
use TrollAndToad\Sellbrite\Core\Contracts\PaginatedApiResponseInterface;

/**
 * Some API calls will return paginated result lists, and as such, you have to fetch
 * multiple pages in order to get all the data. This class should be used as the base
 * API response object on such API calls.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
abstract class PaginatedAbstractApiResponse extends AbstractApiResponse implements PaginatedApiResponseInterface
{
    /**
     * Name of header to check for total number of pages available.
     *
     * @var string
     */
    protected const PAGE_HEADER_NAME = 'Total-Pages';

    /**
     * API request object.
     *
     * @var \TrollAndToad\Sellbrite\Core\Contracts\PaginatedApiRequestInterface
     */
    protected $request;

    /**
     * Total number of pages available from the API.
     *
     * @var int
     */
    protected $pageCount;

    /**
     * PaginatedAbstractApiResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface                                                                                            $response HTTP response
     * @param \TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface                                                                        $apiCall  API call instance
     * @param \TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface|\TrollAndToad\Sellbrite\Core\Contracts\PaginatedApiRequestInterface $request  Sellbrite request object
     * @param \Psr\Log\LoggerInterface|null                                                                                                  $logger   Optional PSR-3 logger implementation
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\InvalidRequestTypeException
     *
     * @return void
     */
    protected function __construct(
        ResponseInterface $response,
        ApiCallInterface $apiCall,
        ApiRequestInterface $request,
        ?LoggerInterface $logger
    ) {
        // Guard against invalid request types being passed to a PaginatedAbstractApiResponse object.
        if (! $request instanceof PaginatedApiResponseInterface) {
            $type = gettype($request);
            $message = 'Request must be of type ['.PaginatedApiResponseInterface::class."] received [{$type}].";

            $this->log($message);

            throw InvalidRequestTypeException::create(static::class, $message);
        }

        parent::__construct($response, $apiCall, $request, $logger);

        $this->pageCount = $response->hasHeader(static::PAGE_HEADER_NAME)
            ? (int) $response->getHeader(static::PAGE_HEADER_NAME)[0]
            : 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentPage(): int
    {
        return $this->request->getPage();
    }

    /**
     * {@inheritdoc}
     */
    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    /**
     * {@inheritdoc}
     */
    public function hasMorePages(): bool
    {
        return $this->getCurrentPage() < $this->pageCount;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchNextPage(): self
    {
        // If no more page, throw exception.
        if (! $this->hasMorePages()) {
            $page = $this->getCurrentPage();
            $totalPages = $this->getPageCount();

            $this->log("Error attempting to access invalid page [{$page}] with total page count [{$totalPages}].");

            throw PageOutOfRangeException::createForPagination(static::class, $page, $totalPages);
        }

        // Set request to fetch next page.
        $this->request->setPage($this->request->getPage() + 1);

        $this->log("Fetching next page [{$this->getCurrentPage()}].", LogLevel::INFO);

        // Fetch the next page.
        return $this->caller->sendRequest($this->request);
    }
}
