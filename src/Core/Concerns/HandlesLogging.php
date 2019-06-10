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

namespace TrollAndToad\Sellbrite\Core\Concerns;

use Psr\Log\LogLevel;
use function array_merge;
use function method_exists;
use function call_user_func;
use Psr\Log\LoggerAwareTrait;

/**
 * Trait to consolidate PSR-3 logger handling to reduce duplicated code across
 * the SDK. Can be added to a class that implements the {@link Psr\Log\LoggerAwareInterface}
 * in order to cover the functionality require by that interface. The
 * {@link \TrollAndToad\Sellbrite\Core\Concerns\HandlesLoggger::log} method can be used
 * to do a null check on the logger, and then log a message using it at a desired level.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
trait HandlesLogging
{
    use LoggerAwareTrait;

    /**
     * Write out to PSR-3 logger instance if one was provided.
     *
     * @param string $message Log message
     * @param string $level   Log level
     * @param array  $context Logging context
     *
     * @return void
     */
    protected function log(string $message, string $level = LogLevel::ERROR, array $context = []): void
    {
        // Exit if no logger.
        if ($this->logger === null) {
            return;
        }

        // Add calling class tag to error message.
        $class = static::class;
        $message = "[{$class}] $message";
        // Add in array of class context if class has toArray method.
        $context = method_exists($this, 'toArray')
            ? array_merge(call_user_func([$this, 'toArray']), $context)
            : $context;

        // Log message.
        $this->logger->log($level, $message, $context);
    }
}
