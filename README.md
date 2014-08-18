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
            "hampel/validate": "~2.0"
        }
    }

Run Composer to update the new requirement.

	:::bash
    $ composer update

Note that running the `install`, `update` or `dump-autoload` Composer commands will generate a new version of the
`tlds.php` file using the latest data from IANA. You can also run the `pre-autoload-dump` script directly:

    :::bash
    $ composer run-script pre-autoload-dump

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

You can use `$validator->getTlds()` to return a complete list of valid TLDs from
http://data.iana.org/TLD/tlds-alpha-by-domain.txt

By default, this function uses a locally cached version of the data, which may not contain the most up-to-date
information, but avoids network traffic. Pass true to this function to fetch the latest version from the internet.

*Note that in v2.1, this behaviour has been reversed from prior versions. Previously, the default was to fetch the
TLD list from the internet. From v2.1, the default is to use the locally cached version by default.*

	:::php
    // the following evaluate to true
    $validator->isDomain("example.travel", $validator->getTlds());

    // use the latest version of the TLD file
    $validator->isDomain("example.travel", $validator->getTlds(true));

	// Simplified Chinese!!
    $validator->isDomain("example.xn--3e0b707e", $validator->getTlds());

Unit Testing
------------

To use local data only and ignore network tests, run: `phpunit --exclude-group network`
