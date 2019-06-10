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

use Assert\Assert;
use function array_merge;
use Assert\InvalidArgumentException;

class UpdateInventory extends InventoryBase
{
    /**
     * TODO: Undocumented property.
     *
     * @var int|null
     */
    private $onHand;

    /**
     * TODO: Undocumented property.
     *
     * @var int|null
     */
    private $available;

    /**
     * TODO: Undocumented property.
     *
     * @var string|null
     */
    private $description;

    /**
     * TODO: Undocumented property.
     *
     * @var string
     */
    private $binLocation;

    protected function __construct(array $properties)
    {
        // TODO: Rework logic here. Need exactly one or the other. Not both, not none.
        if (isset($properties['available'], $properties['on_hand'])) {
            throw new InvalidArgumentException(
                'Exactly one of "on_hand" or "available" field must exist for each individual inventory payload',
                0,
                null,
                null
            );
        }

        parent::__construct($properties);

        $onHand = $properties['on_hand'] ?? null;
        $available = $properties['available'] ?? null;

        Assert::lazy()
            ->that($onHand, 'on_hand')->nullOr()->integer()->greaterOrEqualThan(0)
            ->that($available, 'available')->nullOr()->integer()->greaterOrEqualThan(0)
            ->that($properties['bin_location'] ?? null, 'string')->string()
            ->that($properties['description'] ?? null, 'description')->nullOr()->string()
            ->verifyNow();

        $this->onHand = $onHand;
        $this->available = $available;
        $this->description = $properties['description'] ?? null;
        $this->binLocation = $properties['bin_location'];
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return int|null
     */
    public function getOnHand(): ?int
    {
        return $this->onHand;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return int|null
     */
    public function getAvailable(): ?int
    {
        return $this->available;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string
     */
    public function getBinLocation(): string
    {
        return $this->binLocation;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $parent = parent::toArray();

        $child = [
            'description'  => $this->getDescription(),
            'bin_location' => $this->getBinLocation(),
        ];

        if ($this->onHand !== null) {
            $child['on_hand'] = $this->getOnHand();
        } elseif ($this->available !== null) {
            $child['available'] = $this->getAvailable();
        }

        return array_merge($parent, $child);
    }
}
