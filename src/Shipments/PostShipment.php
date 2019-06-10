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

namespace TrollAndToad\Sellbrite\Shipments;

use TrollAndToad\Sellbrite\Core\AbstractApiCall;

class PostShipment extends AbstractApiCall
{
    // /**
    //  *
    //  */
    // public function sendRequest(array $shipmentArray = null)
    // {
    //     // Build the API endpoint
    //     $url = self::BASE_URI . 'shipments';
    //
    //     // Build the API headers
    //     $apiHeaders = $this->baseApiHeaders;
    //     $apiHeaders['headers']['Content-Type'] = 'application/json';
    //
    //     // Create the body
    //     $apiHeaders['body'] = json_encode($shipmentArray);
    //
    //     // Send the HTTP request to the API endpoint and get the response stream
    //     $response = $this->httpClient->request('POST', $url, $apiHeaders);
    //
    //     // Get the status code returned with the response
    //     $statusCode = $response->getStatusCode();
    //
    //     // Get the response body
    //     $messageArr = json_decode((string) $response->getBody(), true);
    //
    //     // Check status code for success or failure
    //     switch ($statusCode)
    //     {
    //         case 200:
    //         case 201:
    //             return $messageArr['body'];
    //         case 400:
    //             throw new \Exception('400 Bad Request - ' . $messageArr['error']);
    //             break;
    //         case 401:
    //             throw new \Exception("401 Unauthorized - HTTP Basic: Access denied.");
    //             break;
    //         case 404:
    //             throw new \Exception('404 Not Found - ' . $messageArr['error']);
    //             break;
    //         case 422:
    //             throw new \Exception('404 Unprocessable Entity - ' . $messageArr['error']);
    //             break;
    //         default:
    //             throw new \Exception('This is the default error.');
    //     }
    // }
}
