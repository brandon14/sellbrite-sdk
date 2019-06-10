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

namespace TrollAndToad\Sellbrite\Channels;

use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;
use TrollAndToad\Sellbrite\Core\AbstractApiRequest;

/**
 * Request object for the {@link \TrollAndToad\Sellbrite\Channels\GetChannel} API call. Since this API endpoint
 * requires no parameters, this object requires no configuring.
 *
 * @see https://developer.sellbrite.com/v1.0/reference#channels
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
final class GetChannelsRequest extends AbstractApiRequest
{
    /**
     * Constructs a new GetChannelsRequest.
     *
     * @param \Psr\Log\LoggerInterface|null $logger Optiona PSR logger
     *
     * @return void
     */
    public function __construct(?LoggerInterface $logger = null)
    {
        // Don't pass query and body to parent. This request doesn't take
        // any params.
        parent::__construct([], [], [], $logger);
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery(): array
    {
        $this->log(
            'GetChannelsRequest does not require any query params, returning empty array.',
            LogLevel::INFO
        );

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getBody(): array
    {
        $this->log(
            'GetChannelsRequest does not require any body params, returning empty array.',
            LogLevel::INFO
        );

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getUri(): string
    {
        return 'channels';
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseClass(): string
    {
        return GetChannelsResponse::class;
    }
}
