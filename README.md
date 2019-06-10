<p align="center">
  <a href="https://travis-ci.org/trollandtoad/sellbrite-sdk"><img src="https://img.shields.io/travis/trollandtoad/sellbrite-sdk/master.svg?style=flat-square" alt="Build Status"></a>
  <a href="https://codeclimate.com/github/trollandtoad/sellbrite-sdk/maintainability"><img src="https://img.shields.io/codeclimate/maintainability/trollandtoad/sellbrite-sdk.svg?style=flat-square" alt="Code Climate Maintainability"></a>
  <a href="https://codecov.io/gh/trollandtoad/sellbrite-sdk"><img src="https://img.shields.io/codecov/c/github/trollandtoad/sellbrite-sdk.svg?style=flat-square" alt="CodeCov"></a>
  <a href="https://github.com/trollandtoad/sellbrite-sdk/blob/master/LICENSE"><img src="https://img.shields.io/github/license/trollandtoad/sellbrite-sdk.svg?style=flat-square" alt="License"></a>
</p>
<p align="center">
  <a href="https://github.com/trollandtoad/sellbrite-sdk/issues"><img src="https://img.shields.io/github/issues/trollandtoad/sellbrite-sdk.svg?style=flat-square" alt="Issues"></a>
  <a href="https://github.com/trollandtoad/sellbrite-sdk/issues?q=is%3Aissue+is%3Aclosed"><img src="https://img.shields.io/github/issues-closed/trollandtoad/sellbrite-sdk.svg?style=flat-square" alt="Issues Closed"></a>
  <a href="https://github.com/trollandtoad/sellbrite-sdk/pulls"><img src="https://img.shields.io/github/issues-pr/trollandtoad/sellbrite-sdk.svg?style=flat-square" alt="Pull Requests"></a>
  <a href="https://github.com/trollandtoad/sellbrite-sdk/pulls?q=is%3Apr+is%3Aclosed"><img src="https://img.shields.io/github/issues-pr-closed/trollandtoad/sellbrite-sdk.svg?style=flat-square" alt="Pull Requests Closed"></a>
</p>

# Sellbrite SDK

This is a PHP library to interface with Sellbrite's API.

## System Requirements

TODO: Finish README.md

## Installation

```bash
$ composer require trollandtoad/sellbrite-sdk
```

### Usage

TODO: Finish README.md

## Covered API Calls

### Channels

- GET **/channels** - 3 Tests

### Inventory

 - GET **/inventory**
 - PATCH **/inventory**
 - POST **/inventory**
 - PUT **/inventory**

### Orders

 - GET **/orders**
 - GET **/orders/:sb_order_seq**

### Shipments

 - POST **/shipments**

### Warehouses

 - GET **/warehouses**
 - POST **/warehouses**
 - PUT **/warehouses**
 - GET **/warehouses/fulfillments/:uuid**

### Products

 - GET **/products**
 - POST **/products/{sku}**
 - DELETE **/products/{sku}**

### Variation Groups

 - GET **/variation_groups** - 4 Tests
 - DELETE **/variation_groups/{sku}** - 4 Tests
 - PUT **/variation_groups/{sku}** - 7 Tests

### Total - 87 Unit Tests

## Report Bugs

Please report bugs to [brclothier@trollandtoad.com](mailto:brclothier@trollandtoad.com) or open an issue [here](https://github.com/trollandtoad/sellbrite-sdk/issues).

## Security Vulnerabilities

If you discover a security vulnerability within this Sellbrite SDK, please send an e-mail to Brandon Clothier via [brclothier@trollandtoad.com](mailto:brclothier@trollandtoad.com). All security vulnerabilities will be promptly addressed.

## License

The Sellbrite SDK framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
