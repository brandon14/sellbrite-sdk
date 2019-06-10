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
 * Arrayable object interface. Objects implementing this interface will provide a method to convert
 * the object into an associative array representation.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
interface Arrayable
{
    // NOTE: There is a definition in the IsJsonable trait that matches this since PHP does not
    // allow traits to require an interface on the class that uses it. So those definitions need
    // to stay the same.
    /**
     * Get the object data as an associative array. This function will return all object
     * data as primitive types (i.e. strings, arrays, bools, ints, etc).
     *
     * @return array Array representation of object
     * @psalm-return array<string, int|float|bool|string|array>
     */
    public function toArray(): array;
}
