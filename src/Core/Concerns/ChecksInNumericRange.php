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
 * TODO: Undocumented trait.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
trait ChecksInNumericRange
{
    /**
     * TODO: Undocumented method.
     *
     * @param float $min
     * @param float $max
     * @param float $val
     * @param bool  $inclusiveMin
     * @param bool  $inclusiveMax
     *
     * @return bool
     */
    private function checkInFloatRange(
        float $min,
        float $max,
        float $val,
        bool $inclusiveMin = true,
        bool $inclusiveMax = true
    ): bool {
        return $this->checkInNumericRange($min, $max, $val, $inclusiveMin, $inclusiveMax);
    }

    /**
     * TODO: Undocumented method.
     *
     * @param int $min
     * @param int $max
     * @param int $val
     * @param bool  $inclusiveMin
     * @param bool  $inclusiveMax
     *
     * @return bool
     */
    private function checkInIntRange(
        int $min,
        int $max,
        int $val,
        bool $inclusiveMin = true,
        bool $inclusiveMax = true
    ): bool {
        return $this->checkInNumericRange($min, $max, $val, $inclusiveMin, $inclusiveMax);
    }

    /**
     * TODO: Undocumented method.
     *
     * @param int|float $min
     * @param int|float $max
     * @param int|float $val
     * @param bool      $inclusiveMin
     * @param bool      $inclusiveMax
     *
     * @return bool
     */
    private function checkInNumericRange(
        $min,
        $max,
        $val,
        bool $inclusiveMin = true,
        bool $inclusiveMax = true
    ): bool {
        $lowCheck = $inclusiveMin ? $val >= $min : $val > $min;
        $highCheck = $inclusiveMax ? $val <= $max : $val < $max;

        return $lowCheck && $highCheck;
    }
}
