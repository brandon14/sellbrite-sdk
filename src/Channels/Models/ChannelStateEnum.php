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

/** Properties will show as unused due to how MyCLabs Enum's work. */
/** @noinspection PhpUnusedPrivateFieldInspection */

namespace TrollAndToad\Sellbrite\Channels\Models;

use MyCLabs\Enum\Enum;

/**
 * Enum for the channel states available from Sellbrite's channels API.
 *
 * @method static ChannelStateEnum ACTIVE()       Channel is active
 * @method static ChannelStateEnum INACTIVE()     Channel has been deactivated by the merchant
 * @method static ChannelStateEnum DISCONNECTED() Channel has been disconnected as a result of an invalid token
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
class ChannelStateEnum extends Enum
{
    /**
     * Channel is active.
     *
     * @var string
     */
    private const ACTIVE = 'active';
    /**
     * Channel has been deactivated by the merchant.
     *
     * @var string
     */
    private const INACTIVE = 'inactive';
    /**
     * Channel has been disconnected as a result of an invalid token.
     *
     * @var string
     */
    private const DISCONNECTED = 'disconnected';
}
