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

interface PaginatedApiResponseInterface extends ApiResponseInterface
{
    /**
     * Get the current page from the request object.
     *
     * @return int Current page number
     */
    public function getCurrentPage(): int;

    /**
     * Get total page count available from the API.
     *
     * @return int Total number of pages available
     */
    public function getPageCount(): int;

    /**
     * Whether there are more pages available from the API.
     *
     * @return bool True iff there are more pages left, false otherwise
     */
    public function hasMorePages(): bool;

    /**
     * Fetches the next page as a new API response object. If no more pages are available, it will throw
     * an exception.
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\PageOutOfRangeException
     *
     * @return \TrollAndToad\Sellbrite\Core\Contracts\ApiResponseInterface API response object
     */
    public function fetchNextPage(): self;
}
