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

namespace TrollAndToad\Sellbrite\Orders;

use TrollAndToad\Sellbrite\Core\AbstractApiCall;

class GetOrder extends AbstractApiCall
{
    // /**
    //  * @param string $sb_order_sequence Sellbrite Order Number sequence
    //  *
    //  * @return string
    //  */
    // public function sendRequest(string $sb_order_seq = null) {
    //
    //     if (is_null($sb_order_seq) === true)
    //         throw new \Exception('You failed to supply a Sellbrite Order Sequence number.');
    //
    //     // Build the API endpoint
    //     $url = self::BASE_URI . 'orders/' . $sb_order_seq;
    //
    //     // Build the API headers
    //     $apiHeaders = $this->baseApiHeaders;
    //     $apiHeaders['headers']['Content-Type'] = 'application/json';
    //
    //     // Send the HTTP request to the API endpoint and get the response stream
    //     $response = $this->httpClient->request('GET', $url, $apiHeaders);
    //
    //     // Get the status code returned with the response
    //     $statusCode = $response->getStatusCode();
    //
    //     // Check status code for success or failure
    //     switch ($statusCode)
    //     {
    //         case 200:
    //             return (string) $response->getBody();
    //             break;
    //         case 401:
    //             throw new \Exception("401 Unauthorized - HTTP Basic: Access denied.");
    //             break;
    //         default:
    //             throw new \Exception('Unknown error.');
    //     }
    // }
}
