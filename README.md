Hampel Validator
================

Simple validator library composer package

By [Simon Hampel](http://hampelgroup.com/).

Installation
------------

The recommended way of installing Hampel Validator is through [Composer](http://getcomposer.org):

Require the package via Composer in your `composer.json`

    {
        "require": {
            "hampel/validate": "1.0.*"
        }
    }

Run Composer to update the new requirement.

    $ composer update

Usage
-----

__isEmail__ returns true for validly formed email addresses

__isBool__ returns true for "1", "true", "on" and "yes", "0", "false", "off", "no", and "", and NULL ... and returns false for any other value

    // the following all evaluate to boolean true
    Validator::isBool(true);
    Validator::isBool(1);
    Validator::isBool("on");
    Validator::isBool("yes");
    Validator::isBool(false);
    Validator::isBool(0);
    Validator::isBool("off");
    Validator::isBool("no");
    Validator::isBool("");
    Validator::isBool(null);

    // the following will evaluate to boolean false (ie not valid boolean values)
    Validator::isBool("foo"));
    Validator::isBool(2);

__isIPv4__ returns true for any valid IPv4 address, including private and reserved addresses

     // the following all evaluate to true
    Validator::isIPv4("0.0.0.0");
    Validator::isIPv4("1.1.1.1");
    Validator::isIPv4("10.0.0.1");
    Validator::isIPv4("192.168.0.1");
    Validator::isIPv4("255.255.255.255");

__isPublicIPv4__ returns true for valid IPv4 addresses which are not in the private or reserved ranges

    // the following evaluate to true
    Validator::isPublicIPv4("1.1.1.1");
    Validator::isPublicIPv4("74.125.237.2");

    // the following evaluate to false
    Validator::isPublicIPv4("0.0.0.0");
    Validator::isPublicIPv4("10.0.0.1");
    Validator::isPublicIPv4("192.168.0.1");

__isIPv6__ returns true for any valid IPv6 address, including private and reserved addresses

__isPublicIPv6__ returns true for valid IPv6 addresses which are not considered non-routable

__isIP__ returns true for any valid IPv4 or IPv6 address

__isPublicIP__ returns true for any public IPv4 or IPv6 address

__isDomain__ returns true for any validly constructed domain name, including internationalisation in punycode notation

    // the following evaluate to true
    Validator::isDomain("example.com");
    Validator::isDomain("www.example.com.au");
    Validator::isDomain("www-2.example.com");
    Validator::isDomain("example.foo"); // valid because we don't perform strict checking of TLDs

    // the following evaluate to false
    Validator::isDomain("example_1.com"); // underscores not allowed
    Validator::isDomain("example."); // no TLD
    Validator::isDomain("example"); // no TLD

    // Supply an array of TLDs to validate against for more strict validation
    $tlds = array('com', 'au', 'travel', 'xn--0zwm56d');

    Validator::isDomain('example.com', $tlds)); // true
    Validator::isDomain('example.foo', $tlds)); // false

__isTLD__ returns true for any valid TLD when compared to the list of TLDs passed to the function in an array

You may pass a full domain and `isTLD` will check that the TLD extension is valid (but will not validate the domain itself)

    // Supply an array of TLDs to validate against for more strict validation
    $tlds = array('com', 'au', 'travel', 'xn--0zwm56d');

    Validator::isTLD('com', $tlds)); // true
    Validator::isTLD('.com', $tlds)); // true
    Validator::isTLD('example.com', $tlds)); // true
    Validator::isTLD('---.com', $tlds)); // true, since we don't validate the domain itself

    Validator::isDomain('---.com', $tlds)); // false, validates both domain and TLD
    Validator::isDomain('foo', $tlds)); // false
    Validator::isDomain('example.foo', $tlds)); // false

You can use `Validator::getTLDs()` to return a complete list of valid TLDs from http://data.iana.org/TLD/tlds-alpha-by-domain.txt

Pass true to this function to use a locally stored copy of the file, which may not contain the most up-to-date information, but avoids network traffic

    // the following evaluate to true
    Validator::isDomain("example.travel", Validator::getTLDs());

    // use local copy of TLD file
    Validator::isDomain("example.travel", Validator::getTLDs(true));

	// Simplified Chinese!!
    Validator::isDomain("example.xn--0zwm56d", Validator::getTLDs());

Unit Testing
------------

To use local data only and ignore network tests, run: `phpunit --exclude-group network`
