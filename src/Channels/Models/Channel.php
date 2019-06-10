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

namespace TrollAndToad\Sellbrite\Channels\Models;

use Assert\Assert;
use Carbon\Carbon;
use function mb_strtoupper;
use TrollAndToad\Sellbrite\Core\AbstractModel;

/**
 * Class representing a channel object from Sellbrite.
 *
 * Each Channel object contains the following properties:
 *
 * # Properties:
 * | Property Name             | Property Description                                                                                                | Property Type    |
 * | ------------------------- | ------------------------------------------------------------------------------------------------------------------- | ---------------- |
 * | uuid                      | Channel identifier.                                                                                                 | string           |
 * | name                      | Merchant provided name of the channel.                                                                              | string           |
 * | state                     | Connection status of the channel.                                                                                   | ChannelStateEnum |
 * | channel_type_display_name | Channel type display name ("eBay", "Amazon", "Etsy", etc).                                                          | string           |
 * | created_at                | When channel was created in Sellbrite (ISO 8601).                                                                   | Carbon           |
 * | site_id                   | Marketplace region id.                                                                                              | string           |
 * | channel_site_region       | Name of the site region of the channel ("Amazon.co.uk (United Kingdom)", "eBay UK") **for international channels.** | string | null    |
 *
 * @see https://developer.sellbrite.com/v1.0/reference#section-channel-properties
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
final class Channel extends AbstractModel
{
    /**
     * Channel identifier.
     *
     * @var string
     */
    private $uuid;

    /**
     * Merchant provided name of the channel.
     *
     * @var string
     */
    private $name;

    /**
     * Connection status of the channel.
     *
     * "active": Channel is active
     * "inactive": Channel has been deactivated by the merchant
     * "disconnected": Channel has been disconnected as a result of an invalid token.
     *
     * @var \TrollAndToad\Sellbrite\Channels\Models\ChannelStateEnum
     */
    private $state;

    /**
     * Channel type display name ("eBay", "Amazon", "Etsy", etc.).
     *
     * @var string
     */
    private $channelTypeDisplayName;

    /**
     * When channel was created in Sellbrite.
     *
     * @var \Carbon\Carbon
     */
    private $createdAt;

    /**
     * Marketplace region id.
     *
     * @var string
     */
    private $siteId;

    /**
     * Name of the site region of the channel ("Amazon.co.uk (United Kingdom)", "eBay UK").
     * **For international channels.**.
     *
     * @var string|null
     */
    private $channelSiteRegion;

    /**
     * Constructs a new Channel.
     * Constructs a new Channel.
     *
     * @param array $properties Array of channel properties. Contains the following properties:
     *                          [
     *                            'uuid' => string,
     *                            'name' => string,
     *                            'state' => string,
     *                            'channel_type_display_name' => string,
     *                            'created_at' => string,
     *                            'site_id' => string,
     *                            'channel_site_region' => string|null,
     *                          ]
     * @psalm-param array<string, ?string> $properties
     *
     * @throws \Exception
     * @throws \BadMethodCallException
     * @throws \UnexpectedValueException
     * @throws \Assert\AssertionFailedException
     *
     * @return void
     */
    private function __construct(array $properties = [])
    {
        // Validate input properties.
        Assert::lazy()
            ->that($properties['uuid'] ?? null, 'uuid')->string()
            ->that($properties['name'] ?? null, 'name')->string()
            ->that($properties['state'] ?? null, 'state')->string()
            ->that($properties['channel_type_display_name'] ?? null, 'channel_type_display_name')->string()
            ->that($properties['created_at'] ?? null, 'created_at')->string()
            ->that($properties['site_id'] ?? null, 'site_id')->string()
            ->that($properties['channel_site_region'] ?? null, 'channel_site_region')->nullOr()->string()
            ->verifyNow();

        $this->uuid = $properties['uuid'];
        $this->name = $properties['name'];

        // Get channel state enum value.
        $stateName = mb_strtoupper($properties['state']);
        $this->state = ChannelStateEnum::$stateName();

        $this->channelTypeDisplayName = $properties['channel_type_display_name'];
        $this->createdAt = Carbon::parse($properties['created_at']);
        $this->siteId = $properties['site_id'];
        $this->channelSiteRegion = $properties['channel_site_region'] ?? null;
    }

    /**
     * Create a new Channel model.
     *
     * @param array $properties Array of channel properties. Contains the following properties:
     *                          [
     *                              'uuid' => string,
     *                              'name' => string,
     *                              'state' => string,
     *                              'channel_type_display_name' => string,
     *                              'created_at' => string,
     *                              'site_id' => string,
     *                              'channel_site_region' => string|null,
     *                          ]
     * @psalm-param array<string, ?string> $properties
     *
     * @throws \Exception
     * @throws \BadMethodCallException
     * @throws \UnexpectedValueException
     * @throws \Assert\AssertionFailedException
     *
     * @return self
     */
    public static function create(array $properties): self
    {
        return new self($properties);
    }

    /**
     * Get channel uuid (v4).
     *
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Get channel name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get channel connection status.
     *
     * @return string
     */
    public function getState(): string
    {
        return (string) $this->state;
    }

    /**
     * Get channel type display name.
     *
     * @return string
     */
    public function getChannelTypeDisplayName(): string
    {
        return $this->channelTypeDisplayName;
    }

    /**
     * Get channel created at time.
     *
     * @return \Carbon\Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * Get channel marketplace region ID.
     *
     * @return string
     */
    public function getSiteId(): string
    {
        return $this->siteId;
    }

    /**
     * Get name of the site region of the channel.
     *
     * @return string|null
     */
    public function getChannelSiteRegion(): ?string
    {
        return $this->channelSiteRegion;
    }

    /**
     * {@inheritdoc}
     *
     * @psalm-return array<string, string|null>
     */
    public function toArray(): array
    {
        // Represent Channel data as associative array.
        return [
            'uuid'                      => $this->getUuid(),
            'name'                      => $this->getName(),
            'state'                     => $this->getState(), // Cast enum to string value.
            'channel_type_display_name' => $this->getChannelSiteRegion(),
            'created_at'                => $this->getCreatedAt()->toIso8601String(),
            'site_id'                   => $this->getSiteId(),
            'channel_site_region'       => $this->getChannelSiteRegion(),
        ];
    }
}
