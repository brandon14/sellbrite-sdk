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
use RuntimeException;

/**
 * Generic API call exception. Most SDK exceptions will extend this exception.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
class ApiCallException extends RuntimeException
{
    /**
     * Create new {@link \TrollAndToad\Sellbrite\Core\Exceptions\ApiCallException}.
     *
     * @param string          $apiClass API class to create exception for
     * @param string          $message  Error message contents
     * @param int             $code     Exception code
     * @param \Throwable|null $previous Previous Throwable
     *
     * @return self Exception
     */
    public static function create(
        string $apiClass,
        string $message = 'Unknown error occurred. Please try again.',
        int $code = 0,
        ?Throwable $previous = null
    ): self {
        return new self("[$apiClass] $message", $code, $previous);
    }
}
