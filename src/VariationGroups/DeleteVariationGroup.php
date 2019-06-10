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

namespace TrollAndToad\Sellbrite\VariationGroups;

use TrollAndToad\Sellbrite\Core\AbstractApiCall;

/**
 * The Product API isn't documented enough. Will not use until it is.
 */
class DeleteVariationGroup extends AbstractApiCall
{
    // /**
    //  * @param integer $page Page number
    //  * @param integer $limit Number of results per page
    //  * @param array   $skuArr An array of SKUs
    //  */
    // public function sendRequest(string $sku = null)
    // {
    //     if (is_null($sku) === true || empty($sku) === true || is_string($sku) === false)
    //         throw new \Exception('You failed to supply a SKU.');
    //
    //     // Build the API endpoint
    //     $url = self::BASE_URI . 'variation_groups/' . $sku;
    //
    //     // Build the API headers
    //     $apiHeaders = $this->baseApiHeaders;
    //     $apiHeaders['headers']['Content-Type'] = 'application/json';
    //
    //     // Send the HTTP request to the API endpoint and get the response stream
    //     $response = $this->httpClient->request('DELETE', $url, $apiHeaders);
    //
    //     // Get the status code returned with the response
    //     $statusCode = $response->getStatusCode();
    //
    //     // Check status code for success or failure
    //     switch ($statusCode)
    //     {
    //         case 200:
    //             // Returning the PSR7 response object because of the Total-Pages header. Will handle the
    //             // total pages logic outside of this class
    //             return 'Succesfully deleted a variation group.';
    //             break;
    //         case 401:
    //             throw new \Exception("401 Unauthorized - HTTP Basic: Access denied.");
    //             break;
    //         default:
    //             throw new \Exception('This is the default error.');
    //     }
    // }
}
