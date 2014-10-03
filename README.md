Hampel Validator
================

Simple validator library composer package

By [Simon Hampel](http://hampelgroup.com/).

Installation
------------

The recommended way of installing Hampel Validator is through [Composer](http://getcomposer.org):

Require the package via Composer in your `composer.json`

	:::json
    {
        "require": {
            "hampel/validate": "~2.2"
        }
    }

Run Composer to update the new requirement.

	:::bash
    $ composer update

Notes
-----

Version 2.2 of this library removes the Validator::getTlds() method and the ManageTlds class. We leave it up to the
implementer to source their own list of valid TLDs.

If using Laravel, we recommend installing the "hampel/tlds" package which uses this package and also supplies a simple
mechanism for retrieving (and optionally caching) the TLD list directly from IANA or other sources. The TLDs package
also extends the Laravel validation service with additional rules for validating domain names and TLDs.

Again, if using Laravel, we also recommend installing the "hampel/validate-laravel" package which extends the Laravel
validation service with additional rules based on the validation rules in this package (excluding the TLD validation
provided by "hampel/tlds".

Usage
-----

_Example_:

	:::php
	$value = "1";
	$validator = new Validator;
	dd($validator->isBool($value));

__isEmail__ returns true for validly formed email addresses

__isBool__ returns true for "1", "true", "on" and "yes", "0", "false", "off", "no", and "", and NULL ... and returns
false for any other value

	:::php
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
    $validator->isBool("foo"));
    $validator->isBool(2);

__isIpv4__ returns true for any valid IPv4 address, including private and reserved addresses

	:::php
     // the following all evaluate to true
    $validator->isIpv4("0.0.0.0");
    $validator->isIpv4("1.1.1.1");
    $validator->isIpv4("10.0.0.1");
    $validator->isIpv4("192.168.0.1");
    $validator->isIpv4("255.255.255.255");

__isPublicIpv4__ returns true for valid IPv4 addresses which are not in the private or reserved ranges

	:::php
    // the following evaluate to true
    $validator->isPublicIpv4("1.1.1.1");
    $validator->isPublicIpv4("74.125.237.2");

    // the following evaluate to false
    $validator->isPublicIpv4("0.0.0.0");
    $validator->isPublicIpv4("10.0.0.1");
    $validator->isPublicIpv4("192.168.0.1");

__isIpv6__ returns true for any valid IPv6 address, including private and reserved addresses

__isPublicIpv6__ returns true for valid IPv6 addresses which are not considered non-routable

__isIp__ returns true for any valid IPv4 or IPv6 address

__isPublicIP__ returns true for any public IPv4 or IPv6 address

__isDomain__ returns true for any validly constructed domain name, including internationalisation in punycode notation

	:::php
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
    $tlds = array('com', 'au', 'travel', 'xn--3e0b707e');

    $validator->isDomain('example.com', $tlds)); // true
    $validator->isDomain('example.foo', $tlds)); // false

__isTld__ returns true for any valid TLD when compared to the list of TLDs passed to the function in an array

You may pass a full domain and `isTld` will check that the TLD extension is valid (but will not validate the domain
itself)

	:::php
    // Supply an array of TLDs to validate against for more strict validation
    $tlds = array('com', 'au', 'travel', 'xn--3e0b707e');

    $validator->isTld('com', $tlds)); // true
    $validator->isTld('.com', $tlds)); // true
    $validator->isTld('example.com', $tlds)); // true
    $validator->isTld('---.com', $tlds)); // true, since we don't validate the domain itself

    $validator->isDomain('---.com', $tlds)); // false, validates both domain and TLD
    $validator->isDomain('foo', $tlds)); // false
    $validator->isDomain('example.foo', $tlds)); // false
