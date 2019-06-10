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

namespace TrollAndToad\Sellbrite\Core\Exceptions;

use Throwable;

/**
 * Exception thrown when the API returns a 403 for API throttling. This exception can be used to
 * determine whether to wait soem period of time and resend the request.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
class RateLimitExceededException extends ApiCallException
{
    /**
     * Create new {@link \TrollAndToad\Sellbrite\Core\RateLimitExceededException}.
     *
     * @param string          $apiClass API class to create exception for
     * @param string          $message  error message contents
     * @param int             $code     Exception code
     * @param \Throwable|null $previous Previous Throwable
     *
     * @return self Exception
     */
    public static function create(
        string $apiClass,
        string $message = '403 Rate limit exceeded. Please try again.',
        int $code = 403,
        ?Throwable $previous = null
    ): ApiCallException {
        return new self("[$apiClass] $message", $code, $previous);
    }
}
