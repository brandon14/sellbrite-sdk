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

namespace TrollAndToad\Sellbrite\Inventory\Models;

use function array_merge;
use Assert\Assert;

class PostInventory extends InventoryBase
{
    /**
     * TODO: Undocumented property.
     *
     * @var int
     */
    private $onHand;

    protected function __construct(array $properties)
    {
        parent::__construct($properties);

        // Validate properties.
        Assert::that($properties['on_hand'] ?? null, 'on_hand')->integer()->greaterOrEqualThan(0);

        $this->onHand = (int) $properties['on_hand'];
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return int
     */
    public function getOnHand(): int
    {
        return $this->onHand ?? 0;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $parent = parent::toArray();

        return array_merge($parent, ['on_hand' => $this->getOnHand()]);
    }
}
