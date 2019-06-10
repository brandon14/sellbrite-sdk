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

use function json_decode;
use function json_encode;
use const JSON_ERROR_NONE;
use function json_last_error;
use function json_last_error_msg;
use TrollAndToad\Sellbrite\Core\Exceptions\JsonParsingException;

/**
 * Trait to consolidate JSON handling for encoding and decoding, and throwing exceptions in error
 * cases.
 *
 * @author Brandon Clothier <brclothier@trollandtoad.com>
 */
trait SerializesJson
{
    /**
     * Returns the JSON representation of a value.
     *
     * @param mixed   $value   Value to JSON encode
     * @param integer $options JSON encode options
     * @param integer $depth   JSON encode depth
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\JsonParsingException
     *
     * @return string JSON representation of {@link $value}
     */
    protected function jsonEncode($value, int $options = 0, int $depth = 512): string
    {
        $encoded = json_encode($value, $options, $depth);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonParsingException::create(static::class, json_last_error_msg());
        }

        return $encoded;
    }

    /**
     * Decodes a JSON string.
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * @param string  $json    JSON string
     * @param boolean $assoc   Whether to decode as associative array or PHP std object
     * @param integer $depth   JSON decode depth
     * @param integer $options JSON decode options
     *
     * @throws \TrollAndToad\Sellbrite\Core\Exceptions\JsonParsingException
     *
     * @return mixed Values that were encoded in JSON
     */
    protected function jsonDecode(string $json, bool $assoc = false, int $depth = 512, int $options = 0)
    {
        $decoded = json_decode($json, $assoc, $depth, $options);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonParsingException::create(static::class, json_last_error_msg());
        }

        return $decoded;
    }
}
