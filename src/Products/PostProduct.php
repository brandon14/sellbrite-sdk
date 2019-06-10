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

namespace TrollAndToad\Sellbrite\Products;

use TrollAndToad\Sellbrite\Core\AbstractApiCall;

/**
 * The Product API isn't documented enough. Will not use until it is.
 */
class PostProduct extends AbstractApiCall
{
    // /**
    //  * @param string $sku The SKU of the product
    //  * @param array $productInfoArr An array containing all the info related to the product
    //  */
    // public function sendRequest(string $sku = null, array $productInfoArr = null)
    // {
    //     if (is_null($sku) === true || empty($sku) === true || is_string($sku) === false)
    //         throw new \Exception('You failed to supply a SKU.');
    //
    //     if (is_null($productInfoArr) === true || (is_array($productInfoArr) && empty($productInfoArr)))
    //         throw new \Exception('You failed to supply a product information array.');
    //
    //     // Build the API endpoint
    //     $url = self::BASE_URI . 'products/' . $sku;
    //
    //     // Build the API headers
    //     $apiHeaders = $this->baseApiHeaders;
    //     $apiHeaders['headers']['Content-Type'] = 'application/json';
    //
    //     // Create the body
    //     $apiHeaders['body'] = json_encode($productInfoArr);
    //
    //     // Send the HTTP request to the API endpoint and get the response stream
    //     $response = $this->httpClient->request('POST', $url, $apiHeaders);
    //
    //     // Get the status code returned with the response
    //     $statusCode = $response->getStatusCode();
    //
    //     // Check status code for success or failure
    //     switch ($statusCode)
    //     {
    //         case 200:
    //             return $response;
    //         case 401:
    //             throw new \Exception("401 Unauthorized - HTTP Basic: Access denied.");
    //             break;
    //         default:
    //             throw new \Exception('This is the default error.');
    //     }
    // }
}
