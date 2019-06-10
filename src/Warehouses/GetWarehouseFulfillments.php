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

namespace TrollAndToad\Sellbrite\Warehouses;

use TrollAndToad\Sellbrite\Core\AbstractApiCall;

class GetWarehouseFulfillments extends AbstractApiCall
{
    // use DateFieldsTrait;
    // use TextFieldsTrait;

    // /**
    //  * @param string $warehouseUuid The unique identifier for the warehouse
    //  * @param integer $page Page number
    //  * @param integer $limit Number of results per page
    //  * @param string $min_ordered_at Filters orders ordered after date (ISO 8601)
    //  * @param string $max_ordered_at Filters orders ordered before date (ISO 8601)
    //  * @param string $sb_status Filters by order status. Accepts: "completed", "canceled", or "open"
    //  * @param string $sb_payment_status Filters orders by payment status. Accepts: "all", "partial", or "none"
    //  * @param string $shipment_status Filters by shipment status. Accepts: "all", "partial", or "none"
    //  *
    //  * @return object|string
    //  */
    // public function sendRequest(
    //     string $warehouseUuid = null,
    //     int $page = null,
    //     int $limit = null,
    //     string $min_ordered_at = null,
    //     string $max_ordered_at = null,
    //     string $sb_status = null,
    //     string $sb_payment_status = null,
    //     string $shipment_status = null
    // ) {
    //     if (is_null($warehouseUuid) === true || empty($warehouseUuid) === true)
    //         throw new \Exception('You have to supply a warehouse uuid for this API request');
    //
    //     // Build the API endpoint
    //     $url = self::BASE_URI . 'warehouses/' . $warehouseUuid;
    //
    //     // Build the API headers
    //     $apiHeaders = $this->baseApiHeaders;
    //     $apiHeaders['headers']['Content-Type'] = 'application/json';
    //
    //     // Add the page query string if necessary
    //     if (is_null($page) === false && intval($page) > 0)
    //     {
    //         $apiHeaders['query']['page'] = $page;
    //     }
    //
    //     // Add the limit query string is necessary. NOTE: The API limits returned order count
    //     // to 100. The API will -not- allow more to be fetched by a single request.
    //     if (is_null($limit) === false)
    //     {
    //         if (intval($limit) > 100) {
    //             $apiHeaders['query']['limit'] = 100;
    //         } else {
    //             $apiHeaders['query']['limit'] = $limit;
    //         }
    //     }
    //
    //     // Add the min_ordered_at datetime query string (ISO 8601)
    //     if (is_null($min_ordered_at) === false && $this->isDateValid($min_ordered_at))
    //     {
    //         $apiHeaders['query']['min_ordered_at'] = $min_ordered_at;
    //     }
    //
    //     // Add the max_ordered_at datetime query string (ISO 8601)
    //     if (is_null($max_ordered_at) === false && $this->isDateValid($max_ordered_at))
    //     {
    //         $apiHeaders['query']['max_ordered_at'] = $max_ordered_at;
    //     }
    //
    //     // Add the sb_status query string
    //     if (is_null($sb_status) === false && $this->isTextFieldValid($sb_status))
    //     {
    //         $apiHeaders['query']['sb_status'] = $sb_status;
    //     }
    //
    //     // Add the sb_payment_status query string
    //     if (is_null($sb_payment_status) === false && $this->isTextFieldValid($sb_payment_status))
    //     {
    //         $apiHeaders['query']['sb_payment_status'] = $sb_payment_status;
    //     }
    //
    //     // Add the shipment_status query string
    //     if (is_null($shipment_status) === false && $this->isTextFieldValid($shipment_status))
    //     {
    //         $apiHeaders['query']['shipment_status'] = $shipment_status;
    //     }
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
    //             // Returning the PSR7 response object because of the Total-Pages header. Will handle the
    //             // total pages logic outside of this class
    //             return $response;
    //             break;
    //         case 401:
    //             throw new \Exception("401 Unauthorized - HTTP Basic: Access denied.");
    //             break;
    //         default:
    //             throw new \Exception('This is the default error.');
    //     }
    // }
}
