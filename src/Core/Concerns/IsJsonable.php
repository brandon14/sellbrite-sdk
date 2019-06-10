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

namespace TrollAndToad\Sellbrite\Core\Concerns;

/**
 * Trait to provide functionality to convert objects into to JSON strings. This can be used
 * alongside the {@link \TrollAndToad\Sellbrite\Core\Contracts\Jsonable} and
 * {@link \TrollAndToad\Sellbrite\Core\Contracts\Arrayable} interfaces. Classes that use this trait
 * must implement the {@link \TrollAndToad\Sellbrite\Core\Concerns\IsJsonable::toArray} method in order
 * for this functionality to work.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 *
 * @see \TrollAndToad\Sellbrite\Core\Contracts\Jsonable
 * @see \TrollAndToad\Sellbrite\Core\Contracts\Stringable
 * @see \TrollAndToad\Sellbrite\Core\Contracts\Arrayable
 */
trait IsJsonable
{
    use SerializesJson;

    // NOTE: This needs to remain the same contract as in the ArrayableInterface. PHP doesn't allow
    // traits to require an interface.
    /**
     * Get the object data as an associative array. This function will return all object
     * data as primitive types (i.e. strings, arrays, bools, ints, etc).
     *
     * @return array Array representation of object
     * @psalm-return array<string, int|float|bool|string|array>
     */
    abstract public function toArray(): array;

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->toJson();
    }

    /**
     * {@inheritdoc}
     */
    public function asString(): string
    {
        return $this->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function toJson(int $options = 0): string
    {
        return $this->jsonEncode($this->jsonSerialize(), $options);
    }
}
