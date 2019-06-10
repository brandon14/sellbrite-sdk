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

namespace TrollAndToad\Sellbrite\Inventory;

use Psr\Log\LoggerInterface;
use TrollAndToad\Sellbrite\Core\AbstractApiRequest;

/**
 * TODO: Undocumented class.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
class PatchInventoryRequest extends AbstractApiRequest
{
    /**
     * {@inheritdoc}
     */
    protected const REQUEST_METHOD = 'PATCH';

    /**
     * Constructs a new PatchInventoryRequest.
     *
     * @param array                         $body   Array of post body params
     * @param \Psr\Log\LoggerInterface|null $logger Optional PSR-3 logger implementation
     *
     * @return void
     */
    public function __construct(array $body, ?LoggerInterface $logger = null)
    {
        if (! isset($body['inventory'])) {
            // TODO: Throw exception.
        }

        // Filter out non inventory array elements.
        // $body = array_filter($body, function ($product) {
        //     return $product instanceof Inventory;
        // });

        // Handle body validation.

        parent::__construct([], [], $body, $logger);
    }

    public static function createFromInventory(array $inventory, ?LoggerInterface $logger): self
    {
        // TODO: Convert inventory objects to primitives
    }

    public function setInventory(array $inventory): self
    {
        return $this;
    }

    public function addInventory(Inventory $inventory): self
    {
        return $this;
    }

    public function getBody(): array
    {
        // TODO: Convert inventory items into arrays.

        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function getUri(): string
    {
        return 'inventory';
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseClass(): string
    {
        return PatchInventoryResponse::class;
    }
}
