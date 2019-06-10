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

use Psr\Log\LoggerInterface;
use TrollAndToad\Sellbrite\Core\Contracts\PaginatedApiRequestInterface;

/**
 * Some API calls will return paginated result lists, and as such, you have to fetch
 * multiple pages in order to get all the data. This class should be used as the base
 * API request object on such API calls.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
abstract class PaginatedAbstractApiRequest extends AbstractApiRequest implements PaginatedApiRequestInterface
{
    /**
     * Name of query page to fetch a certain page of data from Sellbrite.
     *
     * @var string
     */
    protected const PAGE_QUERY_PARAM = 'page';

    /**
     * {@inheritdoc}
     */
    public function __construct(
        array $query = [],
        array $body = [],
        array $headers = [],
        ?LoggerInterface $logger = null
    ) {
        if (! isset($query[static::PAGE_QUERY_PARAM])) {
            $query[static::PAGE_QUERY_PARAM] = 1;
        }

        parent::__construct($query, $body, $headers, $logger);
    }

    /**
     * {@inheritdoc}
     */
    public function setPage(int $page = 0): self
    {
        if ($page <= 0) {
            unset($this->query[static::PAGE_QUERY_PARAM]);

            return $this;
        }

        $this->query[static::PAGE_QUERY_PARAM] = $page;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPage(): int
    {
        // Check for page in request query params.
        if (isset($this->query[static::PAGE_QUERY_PARAM])) {
            $page = (int) $this->query[static::PAGE_QUERY_PARAM];

            return $page > 0 ? $page : 1;
        }

        return 1;
    }
}
