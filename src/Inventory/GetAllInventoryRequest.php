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

use DateTime;
use Carbon\Carbon;
use function is_int;
use function gettype;
use Ramsey\Uuid\Uuid;
use function is_array;
use function is_string;
use function preg_replace;
use InvalidArgumentException;
use function http_build_query;
use TrollAndToad\Sellbrite\Core\PaginatedAbstractApiRequest;

/**
 * TODO: Undocumented class.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
final class GetAllInventoryRequest extends PaginatedAbstractApiRequest
{
    /**
     * Constructs a new GetAllInventoryRequest.
     *
     * @param array                         $query  Query params
     * @param \Psr\Log\LoggerInterface|null $logger Optional PSR-3 logger implementation
     *
     * @throws \Throwable
     *
     * @return void
     */
    public function __construct(array $query = [], ?LoggerInterface $logger = null)
    {
        parent::__construct([], [], [], $logger);

        // Normalize query params for inventory API.
        if (isset($query[self::PAGE_QUERY_PARAM]) && is_int($query[self::PAGE_QUERY_PARAM])) {
            $this->setPage($query[static::PAGE_QUERY_PARAM]);
        }

        if (isset($query['limit']) && is_int($query['limit'])) {
            $this->setLimit($query['limit']);
        }

        if (isset($query['warehouse_uuid']) && is_string($query['warehouse_uuid'])) {
            $this->setWarehouse($query['warehouse_uuid']);
        }

        if (isset($query['sku']) && (is_string($query['sku']) || is_array($query['sku']))) {
            $this->setSku($query['sku']);
        }

        if (isset($query['created_at_min'])) {
            $this->setCreatedAtMin($query['created_at_min']);
        }

        if (isset($query['created_at_max'])) {
            $this->setCreatedAtMax($query['created_at_max']);
        }

        if (isset($query['updated_at_min'])) {
            $this->setUpdatedAtMin($query['updated_at_min']);
        }

        if (isset($query['updated_at_max'])) {
            $this->setUpdatedAtMax($query['updated_at_max']);
        }
    }

    /**
     * TODO: Undocumented method.
     *
     * @param int $limit Limit. Set to 0 to use default
     *
     * @return \TrollAndToad\Sellbrite\Inventory\GetAllInventoryRequest
     */
    public function setLimit(int $limit = 0): self
    {
        if ($limit <= 0) {
            unset($this->query['limit']);

            return $this;
        }

        $this->query['limit'] = $limit > 100 ? 100 : $limit;

        return $this;
    }

    /**
     * TODO: Undocumented method.
     *
     * @param string|null $warehouseUuid Warehouse Uuid. Set to null to remove param
     *
     * @return \TrollAndToad\Sellbrite\Inventory\GetAllInventoryRequest
     */
    public function setWarehouse(?string $warehouseUuid = null): self
    {
        if ($warehouseUuid === null) {
            unset($this->query['warehouse_uuid']);

            return $this;
        }

        if (Uuid::isValid($warehouseUuid)) {
            $this->query['warehouse_uuid'] = $warehouseUuid;
        }

        return $this;
    }

    /**
     * TODO: Undocumented method.
     *
     * @param string|string[]|null $skus SKU's. Set to null to remove param
     *
     * @throws \InvalidArgumentException
     *
     * @return \TrollAndToad\Sellbrite\Inventory\GetAllInventoryRequest
     */
    public function setSkus($skus = null): self
    {
        if ($skus === null) {
            unset($this->query['sku']);

            return $this;
        }

        // Handle string arg.
        if (is_string($sksu)) {
            $this->query['sku'] = $skus;

            return $this;
        }

        // Handle array arg.
        if (is_array($skus)) {
            // Ensure we only process skus that are strings.
            $filteredSkus = array_filter($skus, 'is_string');

            $this->query['sku'] = $filteredSkus;

            return $this;
        }

        $type = gettype($skus);

        throw new InvalidArgumentException('['.static::class."] Invalid argument type for skus. Expected ['string', 'array'], got ['{$type}'].");
    }

    /**
     * TODO: Undocumented method.
     *
     * @param string|\DateTime|null $createdAtMin Created at min Carbon parseable string or {@link \DateTime} instance.
     *                                            Set to null to remove param
     *
     * @throws \Exception
     *
     * @return \TrollAndToad\Sellbrite\Inventory\GetAllInventoryRequest
     */
    public function setCreatedAtMin($createdAtMin = null): self
    {
        // Unset on null or invalid values.
        if ($createdAtMin === null || (! is_string($createdAtMin) && ! $createdAtMin instanceof DateTime)) {
            unset($this->query['created_at_min']);

            return $this;
        }

        $time = Carbon::make($createdAtMin);

        if ($time === null) {
            unset($this->query['created_at_min']);

            return $this;
        }

        $this->query['created_at_min'] = $time->toIso8601String();

        return $this;
    }

    /**
     * TODO: Undocumented method.
     *
     * @param string|\DateTime|null $createdAtMax Created at max Carbon parseable string or {@link \DateTime} instance.
     *                                            Set to null to remove param
     *
     * @throws \Exception
     *
     * @return \TrollAndToad\Sellbrite\Inventory\GetAllInventoryRequest
     */
    public function setCreatedAtMax($createdAtMax = null): self
    {
        // Unset on null or invalid values.
        if ($createdAtMax === null || (! is_string($createdAtMax) && ! $createdAtMax instanceof DateTime)) {
            unset($this->query['created_at_max']);

            return $this;
        }

        $time = Carbon::make($createdAtMax);

        if ($time === null) {
            unset($this->query['created_at_max']);

            return $this;
        }

        $this->query['created_at_max'] = $time->toIso8601String();

        return $this;
    }

    /**
     * TODO: Undocumented method.
     *
     * @param string|\DateTime|null $updatedAtMin Updated at min Carbon parseable string or {@link \DateTime} instance.
     *                                            Set to null to remove param
     *
     * @throws \Exception
     *
     * @return \TrollAndToad\Sellbrite\Inventory\GetAllInventoryRequest
     */
    public function setUpdatedAtMin($updatedAtMin = null): self
    {
        // Unset on null or invalid values.
        if ($updatedAtMin === null || (! is_string($updatedAtMin) && ! $updatedAtMin instanceof DateTime)) {
            unset($this->query['updated_at_min']);

            return $this;
        }

        $time = Carbon::make($updatedAtMin);

        if ($time === null) {
            unset($this->query['updated_at_min']);

            return $this;
        }

        $this->query['updated_at_min'] = $time->toIso8601String();

        return $this;
    }

    /**
     * TODO: Undocumented method.
     *
     * @param string|\DateTime|null $updatedAtMax Updated at max Carbon parseable string or {@link \DateTime} instance.
     *                                            Set to null to remove param
     *
     * @throws \Exception
     *
     * @return \TrollAndToad\Sellbrite\Inventory\GetAllInventoryRequest
     */
    public function setUpdatedAtMax($updatedAtMax = null): self
    {
        // Unset on null or invalid values.
        if ($updatedAtMax === null || (! is_string($updatedAtMax) && ! $updatedAtMax instanceof DateTime)) {
            unset($this->query['updated_at_max']);

            return $this;
        }

        $time = Carbon::make($updatedAtMax);

        if ($time === null) {
            unset($this->query['updated_at_max']);

            return $this;
        }

        $this->query['updated_at_max'] = $time->toIso8601String();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody(): array
    {
        return [];
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
        return GetInventoryResponse::class;
    }

    /**
     * {@inheritdoc}
     */
    public function handleQuery(array $query)
    {
        // Transform query params into string and strip out array indexes because it is possible to
        // send multiple skus under the skus param, and Guzzle/PHP handles this in a manner that
        // does not work with Sellbrite's API.
        return preg_replace(
            '/%5B(?:[0-9]|[1-9][0-9]+)%5D=/',
            '=',
            http_build_query($query, null, '&', PHP_QUERY_RFC3986)
        );
    }
}
