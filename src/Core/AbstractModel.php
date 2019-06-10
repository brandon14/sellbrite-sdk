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

namespace TrollAndToad\Sellbrite\Core;

use ArrayAccess;
use function ucfirst;
use JsonSerializable;
use function method_exists;
use TrollAndToad\Sellbrite\Core\Concerns\IsJsonable;
use TrollAndToad\Sellbrite\Core\Exceptions\ImmutableModelPropertyException;

/**
 * Abstract class to group up common logic for data models that represent entities returned from
 * Sellbrite's API's. Mainly contains common serialization and array access logic.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
abstract class AbstractModel implements ArrayAccess, JsonSerializable
{
    use IsJsonable;

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset): bool
    {
        return method_exists($this, 'get'.ucfirst($offset))
            && $this->$offset !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        $functionName = 'get'.ucfirst($offset);

        if (method_exists($this, $functionName)) {
            return $this->$functionName();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ImmutableModelPropertyException
     */
    public function offsetSet($offset, $value): void
    {
        throw ImmutableModelPropertyException::create($offset);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ImmutableModelPropertyException
     */
    public function offsetUnset($offset): void
    {
        throw ImmutableModelPropertyException::create($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ImmutableModelPropertyException
     */
    public function __set($key, $value): void
    {
        $this->offsetSet($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function __isset($key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\ImmutableModelPropertyException
     */
    public function __unset($key): void
    {
        $this->offsetUnset($key);
    }
}
