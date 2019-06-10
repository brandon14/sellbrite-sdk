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
use TrollAndToad\Sellbrite\Core\AbstractModel;

/**
 * TODO: Undocumented class.
 *
 * @SuppressWarnings(PHPMD.TooManyFields)
 *
 * @see https://developer.sellbrite.com/v1.0/reference#inventory
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
abstract class InventoryBase extends AbstractModel
{
    /**
     * TODO: Undocumented property.
     *
     * @var string
     */
    private $sku;

    /**
     * TODO: Undocumented property.
     *
     * @var string
     */
    private $warehouseUuid;

    protected function __construct(array $properties)
    {
        // Validate properties.
        Assert::lazy()
            ->that($properties['sku'] ?? null, 'sku')->string()
            ->that($properties['warehouse_uuid'] ?? null, 'warehouse_uuid')->string()
            ->verifyNow();

        $this->sku = $properties['sku'];
        $this->warehouseUuid = $properties['warehouse_uuid'];
    }

    public static function create(array $properties): self
    {
        return new static($properties);
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string
     */
    public function getWarehouseUuid(): string
    {
        return $this->warehouseUuid;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'sku'            => $this->getSku(),
            'warehouse_uuid' => $this->getWarehouseUuid(),
        ];
    }
}
