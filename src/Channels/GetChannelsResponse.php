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

use Throwable;
use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface;
use TrollAndToad\Sellbrite\Channels\Models\Channel;
use TrollAndToad\Sellbrite\Core\AbstractApiResponse;
use TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface;
use TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface;
use TrollAndToad\Sellbrite\Core\Contracts\ApiResponseInterface;
use TrollAndToad\Sellbrite\Core\Exceptions\CannotCreateResponseException;

/**
 * Response type for the {@link \TrollAndToad\Sellbrite\Channels\GetChannels} API call.
 *
 * Contains a list of channels with the following properties:
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
 * For more information on channel properties, see the {@link \TrollAndToad\Sellbrite\Channels\Channel} model.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
final class GetChannelsResponse extends AbstractApiResponse
{
    /**
     * Array of {@link TrollAndToad\Sellbrite\Channels\Models\Channel}'s.
     *
     * @psalm-var array<int, \TrollAndToad\Sellbrite\Channels\Models\Channel>
     * @var \TrollAndToad\Sellbrite\Channels\Models\Channel[]
     */
    private $channels;

    /**
     * Creates a new {@link \TrollAndToad\Sellbrite\Channels\GetChannelsResponse} instance.
     *
     * @param \Psr\Http\Message\ResponseInterface                        $response PSR-7 response
     * @param \TrollAndToad\Sellbrite\Core\Contracts\ApiCallInterface    $apiCall  Api call object
     * @param \TrollAndToad\Sellbrite\Core\Contracts\ApiRequestInterface $request  Api request object
     * @param \Psr\Log\LoggerInterface|null                              $logger   Optional PSR-3 logger implementation
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\CannotCreateResponseException
     *
     * @return void
     */
    protected function __construct(
        ResponseInterface $response,
        ApiCallInterface $apiCall,
        ApiRequestInterface $request,
        ?LoggerInterface $logger = null
    ) {
        parent::__construct($response, $apiCall, $request, $logger);

        $this->channels = [];

        // Create Channel classes for each channel returned.
        foreach ($this->content as $channel) {
            try {
                $this->log("Creating new channel model from channel [{$channel['uuid']}].", LogLevel::INFO, ['channel' => $channel]);

                // Add Channel to list of Channels.
                $this->channels[] = Channel::create([
                    'uuid' => (string) $channel['uuid'],
                    'name' => (string) $channel['name'],
                    'state' => (string) $channel['state'],
                    'channel_type_display_name' => (string) $channel['channel_type_display_name'],
                    'created_at' => (string) $channel['created_at'],
                    'site_id' => (string) $channel['site_id'],
                    'channel_site_region' => isset($channel['channel_site_region']) ? (string) $channel['channel_site_region'] : null
                ]);
            } catch (Throwable $t) {
                // Encode $channel array as JSON for neat logging.
                $serializedChannel = $this->jsonEncode($channel);
                $message = "Unable to create Channel from response content [$serializedChannel]. Raw response: [{$this->rawContent}]";

                $this->log($message, LogLevel::ERROR, ['channel' => $channel]);

                throw CannotCreateResponseException::create(static::class, $message, $t->getCode(), $t);
            }
        }
    }

    /**
     * {@inheritdoc}
     *
     * @return \TrollAndToad\Sellbrite\Channels\GetChannelsResponse
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
     * Gets array of all channels returned.
     *
     * @psalm-return array<int, \TrollAndToad\Sellbrite\Channels\Channel>
     * @return \TrollAndToad\Sellbrite\Channels\Models\Channel[] Array of channels
     */
    public function getChannels(): array
    {
        return $this->channels;
    }

    /**
     * Gets a channel by its uuid.
     *
     * @param string $uuid Uuid
     *
     * @return \TrollAndToad\Sellbrite\Channels\Models\Channel|null Channel, or null if none matches {@link $uuid}
     */
    public function getChannelByUuid(string $uuid): ?Channel
    {
        foreach ($this->channels as $channel) {
            if ($channel->getUuid() === $uuid) {
                return $channel;
            }
        }

        return null;
    }

    /**
     * Gets channel by its index.
     *
     * @param int $index Index
     *
     * @return \TrollAndToad\Sellbrite\Channels\Models\Channel|null Channel, or null if no {@link $index} exists
     */
    public function getChannelByIndex(int $index): ?Channel
    {
        return $this->channels[$index] ?? null;
    }

    /**
     * {@inheritdoc}
     *
     * This adds index 'channels' with array where each value is the array of channel data.
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        $channels = [];

        // Convert each model instance into array since it implements toArray.
        foreach ($this->channels as $channel) {
            $channels[] = $channel->toArray();
        }

        return array_merge($array, [
            'channels' => $channels,
        ]);
    }
}
