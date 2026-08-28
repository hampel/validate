Hampel Validator
================

[![Tests](https://github.com/hampel/validate/actions/workflows/tests.yml/badge.svg)](https://github.com/hampel/validate/actions/workflows/tests.yml)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/hampel/validate.svg?style=flat-square)](https://packagist.org/packages/hampel/validate)
[![Total Downloads](https://img.shields.io/packagist/dt/hampel/validate.svg?style=flat-square)](https://packagist.org/packages/hampel/validate)
[![Open Issues](https://img.shields.io/github/issues/hampel/validate.svg?style=flat-square)](https://github.com/hampel/validate/issues)
[![License](https://img.shields.io/packagist/l/hampel/validate.svg?style=flat-square)](https://packagist.org/packages/hampel/validate)

Simple validator library composer package

By [Simon Hampel](mailto:simon@hampelgroup.com)

Requirements
------------

PHP 8.3 or later, and the `filter` extension. No framework, and no runtime dependencies.

Installation
------------

The recommended way of installing Hampel Validator is through [Composer](https://getcomposer.org):

```bash
composer require hampel/validate
```

Usage
-----

Every method takes any value — `null`, an integer and a `Stringable` object are all accepted — and
returns a strict boolean.

```php
use Hampel\Validate\Validator;

$validator = new Validator();

var_dump($validator->isBool("1")); // bool(true)
```

__isEmail__ returns true for validly formed email addresses

__isBool__ returns true for "1", "true", "on" and "yes", "0", "false", "off", "no", and "", and NULL ... and returns
false for any other value

```php
// the following all evaluate to boolean true
$validator->isBool(true);
$validator->isBool(1);
$validator->isBool("on");
$validator->isBool("yes");
$validator->isBool(false);
$validator->isBool(0);
$validator->isBool("off");
$validator->isBool("no");
$validator->isBool("");
$validator->isBool(null);

// the following will evaluate to boolean false (ie not valid boolean values)
$validator->isBool("foo");
$validator->isBool(2);
```

__isIpv4__ returns true for any valid IPv4 address, including private and reserved addresses

```php
// the following all evaluate to true
$validator->isIpv4("0.0.0.0");
$validator->isIpv4("1.1.1.1");
$validator->isIpv4("10.0.0.1");
$validator->isIpv4("192.168.0.1");
$validator->isIpv4("255.255.255.255");
```

__isPublicIpv4__ returns true for valid IPv4 addresses which are not in the private or reserved ranges

```php
// the following evaluate to true
$validator->isPublicIpv4("1.1.1.1");
$validator->isPublicIpv4("74.125.237.2");

// the following evaluate to false
$validator->isPublicIpv4("0.0.0.0");
$validator->isPublicIpv4("10.0.0.1");
$validator->isPublicIpv4("192.168.0.1");
```

__isIpv6__ returns true for any valid IPv6 address, including private and reserved addresses

__isPublicIpv6__ returns true for valid IPv6 addresses which are not considered non-routable

```php
// the following evaluate to true
$validator->isPublicIpv6("2606:4700:4700::1111");

// the following evaluate to false
$validator->isPublicIpv6("::1"); // reserved
$validator->isPublicIpv6("fd01:db8::ff00:42:8329"); // private range
$validator->isPublicIpv6("2001:db8::ff00:42:8329"); // reserved for documentation
```

The documentation range `2001:db8::/32` is rejected by this library rather than by `filter_var`,
which stopped treating it as reserved in PHP 8.3. The answer is therefore the same on every
supported PHP version.

__isIp__ returns true for any valid IPv4 or IPv6 address

__isPublicIp__ returns true for any public IPv4 or IPv6 address

__isDomain__ returns true for any validly constructed domain name, including internationalisation in punycode notation

```php
// the following evaluate to true
$validator->isDomain("example.com");
$validator->isDomain("www.example.com.au");
$validator->isDomain("www-2.example.com");
$validator->isDomain("example.foo"); // valid because we don't perform strict checking of TLDs

// the following evaluate to false
$validator->isDomain("example_1.com"); // underscores not allowed
$validator->isDomain("example."); // no TLD
$validator->isDomain("example"); // no TLD

// Supply an array of TLDs to validate against for more strict validation
$tlds = ['com', 'au', 'travel', 'xn--3e0b707e'];

$validator->isDomain('example.com', $tlds); // true
$validator->isDomain('example.foo', $tlds); // false
```

__isTld__ returns true for any valid TLD when compared to the list of TLDs passed to the function in an array

You may pass a full domain and `isTld` will check that the TLD extension is valid (but will not validate the domain
itself)

```php
// Supply an array of TLDs to validate against for more strict validation
$tlds = ['com', 'au', 'travel', 'xn--3e0b707e'];

$validator->isTld('com', $tlds); // true
$validator->isTld('.com', $tlds); // true
$validator->isTld('example.com', $tlds); // true
$validator->isTld('---.com', $tlds); // true, since we don't validate the domain itself

$validator->isDomain('---.com', $tlds); // false, validates both domain and TLD
$validator->isDomain('foo', $tlds); // false
$validator->isDomain('example.foo', $tlds); // false
```

Notes
-----

No TLD list ships with this package. Pass your own array of lowercase TLDs to `isDomain()` and
`isTld()`, or pass nothing and get structural validation only.

If using Laravel, we recommend installing the "hampel/tlds" package, which uses this package and
also supplies a simple mechanism for retrieving (and optionally caching) the TLD list directly from
IANA or other sources. The TLDs package also extends the Laravel validation service with additional
rules for validating domain names and TLDs.
