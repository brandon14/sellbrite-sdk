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

use const INF;
use Throwable;
use Psr\Log\LogLevel;
use function in_array;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface;
use TrollAndToad\Sellbrite\Inventory\Models\Inventory;
use TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface;
use TrollAndToad\Sellbrite\Core\PaginatedAbstractApiRequest;
use TrollAndToad\Sellbrite\Core\PaginatedAbstractApiResponse;
use TrollAndToad\Sellbrite\Core\Concerns\ChecksInNumericRange;
use TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface;
use TrollAndToad\Sellbrite\Core\Contracts\ApiResponseInterface;
use TrollAndToad\Sellbrite\Core\Exceptions\CannotCreateResponseException;

/**
 * TODO: Undocumented class.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
final class GetAllInventoryResponse extends PaginatedAbstractApiResponse
{
    use ChecksInNumericRange;

    /**
     * Array of inventory items.
     *
     * @psalm-var array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @var \TrollAndToad\Sellbrite\Inventory\Models\Inventory[]
     */
    private $inventory;

    /**
     * Creates a new {@link \TrollAndToad\Sellbrite\Inventory\GetAllInventoryResponse} instance.
     *
     * @param \Psr\Http\Message\ResponseInterface                      $response PSR-7 response
     * @param \TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface  $apiCall  Api call object
     * @param \TrollAndToad\Sellbrite\Core\PaginatedAbstractApiRequest $request  Api request object
     * @param \Psr\Log\LoggerInterface|null                            $logger   PSR-3 logger instance
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\CannotCreateResponseException
     *
     * @return void
     */
    protected function __construct(
        ResponseInterface $response,
        ApiCallInterface $apiCall,
        PaginatedAbstractApiRequest $request,
        ?LoggerInterface $logger
    ) {
        parent::__construct($response, $apiCall, $request, $logger);

        $this->inventory = [];

        // Create Inventory classes for each inventory item returned.
        foreach ($this->content as $inventory) {
            try {
                $this->log(
                    "Creating new inventory model from inventory [{$inventory['sku']}].",
                    LogLevel::INFO,
                    ['inventory' => $inventory]
                );

                // Add Inventory to list of inventory items.
                $this->inventory[] = Inventory::create([
                    'sku' => isset($inventory['sku']) ? (string) $inventory['sku'] : null,
                    'warehouse_uuid' => isset($inventory['warehouse_uuid']) ? (string) $inventory['warehouse_uuid'] : null,
                    'on_hand' => isset($inventory['on_hand']) ? (int) $inventory['on_hand'] : 0,
                    'available' => isset($inventory['available']) ? (int) $inventory['available'] : 0,
                    'reserved' => isset($inventory['reserved']) ? (int) $inventory['reserved'] : 0,
                    'product_name' => $inventory['product_name'] ?? null,
                    'package_length' => isset($inventory['package_length']) ? (float) $inventory['package_length'] : null,
                    'package_width' => isset($inventory['package_width']) ? (float) $inventory['package_width'] : null,
                    'package_height' => isset($inventory['package_height']) ? (float) $inventory['package_height'] : null,
                    'package_weight' => isset($inventory['package_weight']) ? (float) $inventory['package_weight'] : null,
                    'cost' => isset($inventory['cost']) ? (float) $inventory['cost'] : null,
                    'upc' => $inventory['upc'] ?? null,
                    'ean' => $inventory['ean'] ?? null,
                    'isbn' => $inventory['isbn'] ?? null,
                    'gtin' => $inventory['gtin'] ?? null,
                    'gcid' => $inventory['gcid'] ?? null,
                    'epid' => $inventory['epid'] ?? null,
                    'asin' => $inventory['asin'] ?? null,
                    'fnsku' => $inventory['fnsku'] ?? null,
                    'bin_location' => $inventory['bin_location'] ?? null,
                ]);
            } catch (Throwable $t) {
                // Encode $inventory array as JSON for neat logging.
                $serializedInventory = $this->jsonEncode($inventory);
                $message = "Unable to create Inventory from response content [$serializedInventory]. Raw response: [{$this->rawContent}]";

                $this->log($message, LogLevel::ERROR, ['inventory' => $inventory]);

                throw CannotCreateResponseException::create(static::class, $message, $t->getCode(), $t);
            }
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param \TrollAndToad\Sellbrite\Core\PaginatedAbstractApiRequest $request GetAllInventoryRequest
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\CannotCreateResponseException
     *
     * @return \TrollAndToad\Sellbrite\Channels\GetAllInventoryResponse
     */
    public static function create(
        ResponseInterface $response,
        ApiCallInterface $apiCall,
        ApiRequestInterface $request,
        ?LoggerInterface $logger = null
    ): ApiResponseInterface {
        return new self($response, $apiCall, $request, $logger);
    }

    /**
     * Gets array of all inventory returned.
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Array of channels
     */
    public function getInventory(): array
    {
        return $this->inventory;
    }

    /**
     * Gets all inventory objects in a list of skus.
     *
     * @param string[] $skus SKU's
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $skus}
     */
    public function getInventoryBySku(array $skus): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if (in_array($inventory->getSku(), $skus, true)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects in a list of names.
     *
     * @param string[] $names Names
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $names}
     */
    public function getInventoryByName(array $names): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if (in_array($inventory->getGetName(), $names, true)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects in a list of isbns.
     *
     * @param string[] $isbns ISBN's
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $isbns}
     */
    public function getInventoryByIsbn(array $isbns): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if (in_array($inventory->getIsbn(), $isbns, true)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects in a list of asins.
     *
     * @param string[] $asins ASINS's
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $asins}
     */
    public function getInventoryByAsin(array $asins): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if (in_array($inventory->getAsin(), $asins, true)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects in a list of upcs.
     *
     * @param string[] $upcs UPC's
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $upcs}
     */
    public function getInventoryByUpc(array $upcs): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if (in_array($inventory->getUpc(), $upcs, true)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects in a list of eans.
     *
     * @param string[] $eans EAN's
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $eans}
     */
    public function getInventoryByEan(array $eans): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if (in_array($inventory->getEan(), $eans, true)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects in a list of gtins.
     *
     * @param string[] $gtins GTIN's
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $gtins}
     */
    public function getInventoryByGtin(array $gtins): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if (in_array($inventory->getGtin(), $gtins, true)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects in a list of gcids.
     *
     * @param string[] $gcids GCID's
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $gcids}
     */
    public function getInventoryByGcid(array $gcids): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if (in_array($inventory->getGcid(), $gcids, true)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects in a list of epids.
     *
     * @param string[] $epids EPID's
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $epids}
     */
    public function getInventoryByEpid(array $epids): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if (in_array($inventory->getEpid(), $epids, true)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects in a list of fnskus.
     *
     * @param string[] $fnskus FNSKU's
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $fnskus}
     */
    public function getInventoryByFnsku(array $fnskus): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if (in_array($inventory->getFnsku(), $fnskus, true)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects in a list of bin locations.
     *
     * @param string[] $binLocations Bin locations
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $binLocations}
     */
    public function getInventoryByBinLocation(array $binLocations): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if (in_array($inventory->getBinLocation(), $binLocations, true)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects that match a cost.
     *
     * @param float $cost Cost of the inventory item
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $cost}
     */
    public function getInventoryByCost(float $cost): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if ($inventory->getCost() === $cost) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects in a list of eans.
     *
     * @param float $minCost
     * @param float $maxCost
     * @param bool  $inclusiveMin
     * @param bool  $inclusiveMax
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches provided range
     */
    public function getInventoryByCostRange(
        float $minCost,
        float $maxCost = INF,
        bool $inclusiveMin = true,
        bool $inclusiveMax = true
    ): array {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if ($this->checkInFloatRange($minCost, $maxCost, $inventory->getCost(), $inclusiveMin, $inclusiveMax)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects that match a weight.
     *
     * @param float $weight Weight of the inventory item
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches {@link $weight}
     */
    public function getInventoryByWeight(float $weight): array
    {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if ($inventory->getPackageWeight() === $weight) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    /**
     * Gets all inventory objects in a given package weight range.
     *
     * @param float $minWeight
     * @param float $maxWeight
     * @param bool  $inclusiveMin
     * @param bool  $inclusiveMax
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Inventory\Inventory>
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory[] Inventory, or empty array if none matches weight range
     */
    public function getInventoryByWeightRange(
        float $minWeight,
        float $maxWeight = INF,
        bool $inclusiveMin = true,
        bool $inclusiveMax = true
    ): array {
        $inventoryList = [];

        foreach ($this->inventory as $inventory) {
            if ($this->checkInFloatRange($minWeight, $maxWeight, $inventory->getPackageWeight(), $inclusiveMin, $inclusiveMax)) {
                $inventoryList[] = $inventory;
            }
        }

        return $inventoryList;
    }

    // TODO: Add functions to get inventory by other properties.

    /**
     * Gets inventory by its index.
     *
     * @param int $index Index
     *
     * @return \TrollAndToad\Sellbrite\Inventory\Models\Inventory|null Inventory, or null if no {@link $index} exists
     */
    public function getInventoryByIndex(int $index): ?Inventory
    {
        return $this->inventory[$index] ?? null;
    }

    /**
     * {@inheritdoc}
     *
     * This adds index 'inventory' with array where each value is the array of inventory data.
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $inventoryList = [];

        // Convert each model instance into array since it implements toArray.
        foreach ($this->inventory as $inventory) {
            $inventoryList[] = $inventory->toArray();
        }

        return array_merge($array, [
            'inventory' => $inventoryList,
        ]);
    }
}
