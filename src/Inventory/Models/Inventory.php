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

/**
 * TODO: Undocumented class.
 *
 * @SuppressWarnings(PHPMD.TooManyFields)
 *
 * @see https://developer.sellbrite.com/v1.0/reference#inventory
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
final class Inventory extends InventoryBase
{
    /**
     * TODO: Undocumented property.
     *
     * @var int
     */
    private $onHand;

    /**
     * TODO: Undocumented property.
     *
     * @var int
     */
    private $available;

    /**
     * TODO: Undocumented property.
     *
     * @var int
     */
    private $reserved;

    /**
     * TODO: Undocumented property.
     *
     * @var string|null
     */
    private $productName;

    /**
     * TODO: Undocumented property.
     *
     * @var float
     */
    private $packageLength;

    /**
     * TODO: Undocumented property.
     *
     * @var float
     */
    private $packageWidth;

    /**
     * TODO: Undocumented property.
     *
     * @var float
     */
    private $packageHeight;

    /**
     * TODO: Undocumented property.
     *
     * @var float
     */
    private $packageWeight;

    /**
     * TODO: Undocumented property.
     *
     * @var float
     */
    private $cost;

    /**
     * TODO: Undocumented property.
     *
     * @var string|null
     */
    private $upc;

    /**
     * TODO: Undocumented property.
     *
     * @var string|null
     */
    private $ean;

    /**
     * TODO: Undocumented property.
     *
     * @var string|null
     */
    private $isbn;

    /**
     * TODO: Undocumented property.
     *
     * @var string|null
     */
    private $gtin;

    /**
     * TODO: Undocumented property.
     *
     * @var string|null
     */
    private $gcid;

    /**
     * TODO: Undocumented property.
     *
     * @var string|null
     */
    private $epid;

    /**
     * TODO: Undocumented property.
     *
     * @var string|null
     */
    private $asin;

    /**
     * TODO: Undocumented property.
     *
     * @var string|null
     */
    private $fnsku;

    /**
     * TODO: Undocumented property.
     *
     * @var string|null
     */
    private $binLocation;

    protected function __construct(array $properties)
    {
        parent::__construct($properties);

        // Validate properties.
        Assert::lazy()
            ->that($properties['on_hand'] ?? null, 'on_hand')->integer()->greaterOrEqualThan(0)
            ->that($properties['available'] ?? null, 'on_hand')->integer()->greaterOrEqualThan(0)
            ->that($properties['reserved'] ?? null, 'on_hand')->integer()->greaterOrEqualThan(0)
            ->that($properties['cost'] ?? null, 'cost')->float()->greaterThan(0)
            ->that($properties['product_name'] ?? null, 'product_name')->string()
            ->that($properties['package_length'] ?? null, 'package_length')->float()->greaterOrEqualThan(0)
            ->that($properties['package_width'] ?? null, 'package_width')->float()->greaterOrEqualThan(0)
            ->that($properties['package_height'] ?? null, 'package_height')->float()->greaterOrEqualThan(0)
            ->that($properties['package_weight'] ?? null, 'package_weight')->float()->greaterOrEqualThan(0)
            ->that($properties['upc'] ?? null, 'upc')->nullOr()->string()
            ->that($properties['ean'] ?? null, 'ean')->nullOr()->string()
            ->that($properties['isbn'] ?? null, 'isbn')->nullOr()->string()
            ->that($properties['gtin'] ?? null, 'gtin')->nullOr()->string()
            ->that($properties['gcid'] ?? null, 'gciid')->nullOr()->string()
            ->that($properties['epid'] ?? null, 'epid')->nullOr()->string()
            ->that($properties['asin'] ?? null, 'asin')->nullOr()->string()
            ->that($properties['fnsku'] ?? null, 'fnsku')->nullOr()->string()
            ->that($properties['bin_location'] ?? null, 'bin_location')->string()
            ->verifyNow();

        $this->onHand = (int) $properties['on_hand'];
        $this->available = (int) $properties['available'];
        $this->reserved = (int) $properties['reserved'];
        $this->cost = (float) $properties['cost'];
        $this->productName = $properties['product_name'] ?? null;
        $this->packageLength = (float) $properties['package_length'];
        $this->packageWidth = (float) $properties['package_width'];
        $this->packageHeight = (float) $properties['package_height'];
        $this->packageWeight = (float) $properties['package_weight'];
        $this->upc = $properties['upc'] ?? null;
        $this->ean = $properties['ean'] ?? null;
        $this->isbn = $properties['isbn'] ?? null;
        $this->gtin = $properties['gtin'] ?? null;
        $this->gcid = $properties['gcid'] ?? null;
        $this->epid = $properties['epid'] ?? null;
        $this->asin = $properties['asin'] ?? null;
        $this->fnsku = $properties['fnsku'] ?? null;
        $this->binLocation = $properties['bin_location'] ?? null;
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
     * TODO: Undocumented getter.
     *
     * @return int
     */
    public function getAvailable(): int
    {
        return $this->available ?? 0;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return int
     */
    public function getReserved(): int
    {
        return $this->reserved ?? 0;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return float
     */
    public function getPackageLength(): float
    {
        return $this->packageLength ?? 0.00;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return float
     */
    public function getPackageWidth(): float
    {
        return $this->packageWidth ?? 0.00;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return float
     */
    public function getPackageHeight(): float
    {
        return $this->packageHeight ?? 0.00;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return float
     */
    public function getPackageWeight(): float
    {
        return $this->packageWeight ?? 0.00;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return float
     */
    public function getCost(): float
    {
        return $this->cost ?? 0.00;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string|null
     */
    public function getUpc(): ?string
    {
        return $this->upc;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string|null
     */
    public function getEan(): ?string
    {
        return $this->ean;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string|null
     */
    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string|null
     */
    public function getGtin(): ?string
    {
        return $this->gtin;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string|null
     */
    public function getGcid(): ?string
    {
        return $this->gcid;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string|null
     */
    public function getEpid(): ?string
    {
        return $this->epid;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string|null
     */
    public function getAsin(): ?string
    {
        return $this->asin;
    }

    /**
     * TODO: Undocumented getter.
     *
     * @return string|null
     */
    public function getFnsku(): ?string
    {
        return $this->fnsku;
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

        return array_merge($parent, [
            'on_hand'        => $this->getOnHand(),
            'available'      => $this->getAvailable(),
            'reserved'       => $this->getReserved(),
            'product_name'   => $this->getProductName(),
            'package_length' => $this->getPackageLength(),
            'package_width'  => $this->getPackageWidth(),
            'package_height' => $this->getPackageHeight(),
            'package_weight' => $this->getPackageWeight(),
            'cost'           => $this->getCost(),
            'upc'            => $this->getUpc(),
            'ean'            => $this->getEan(),
            'isbn'           => $this->getIsbn(),
            'gtin'           => $this->getGtin(),
            'gcid'           => $this->getGcid(),
            'epid'           => $this->getEpid(),
            'asin'           => $this->getAsin(),
            'fnsku'          => $this->getFnsku(),
            'bin_location'   => $this->getBinLocation(),
        ]);
    }
}
