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

/**
 * Stringable interface. Objects that implement this interface will
 * be able to be casted to a string or otherwise treated like a string
 * in PHP.
 *
 * **NOTE**:
 * This still doesn't allow for passing {@link \TrollAndToad\Sellbrite\Core\Contracts\Stringable}
 * objects into functions such as {@link is_string()}, however one could check for
 * a string or if the object implements stringable as an easy way to test whether
 * it can be treated as string.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 *
 * @see https://secure.php.net/language.oop5.magic#object.tostring
 */
interface Stringable
{
    /**
     * Obtain a string representation of object. This allows `Stringable`
     * objects to be casted to strings.
     *
     * @see https://secure.php.net/language.oop5.magic#object.tostring
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Obtain a string representation of object. This allows `Stringable`
     * objects to be casted to strings.
     *
     * @return string String representation of class
     */
    public function toString(): string;

    /**
     * Alias to {@link \TrollAndToad\Sellbrite\Core\Contracts\Stringable::toString}.
     *
     * @return string String representation of class
     */
    public function asString(): string;
}
