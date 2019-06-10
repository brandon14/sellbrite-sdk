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

namespace TrollAndToad\Sellbrite\Core\Contracts;

use JsonSerializable;

/**
 * Jsonable object interface. Implementing this interface means that your object will
 * be able to be represented as a JSON string and also be JSON serializable. This
 * interface implies it is also stringable via {@link \TrollAndToad\Sellbrite\Core\Contracts\Stringable}.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
interface Jsonable extends JsonSerializable, Stringable
{
    /**
     * Convert object to JSON string. This can be used for easy data serialization for logging or
     * debugging.
     *
     * @param int $options JSON encode options
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\JsonParsingException
     *
     * @return string JSON string
     */
    public function toJson(int $options = 0): string;
}
