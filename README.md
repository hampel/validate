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
            "hampel/validate": "dev-master"
        }
    }

Run Composer to update the new requirement.

    $ composer update

Usage
-----

__isBool__ returns true for "1", "true", "on" and "yes", "0", "false", "off", "no", and "", and NULL ... and returns false for any other value

    // the following all evaluate to boolean true
    Validator::isBool(true);
    Validator::isBool(1);
    Validator::isBool('on');
    Validator::isBool('yes');
    Validator::isBool(false);
    Validator::isBool(0);
    Validator::isBool('off');
    Validator::isBool('no');
    Validator::isBool('');
    Validator::isBool(null);

    // the following will evaluate to boolean false (ie not valid boolean values)
    Validator::isBool('foo'));
    Validator::isBool(2);

__isIPv4__ returns true for any valid IPv4 address, including private and reserved addresses

     // the following all evaluate to true
    Validator::isIPv4('0.0.0.0');
    Validator::isIPv4('1.1.1.1');
    Validator::isIPv4('10.0.0.1');
    Validator::isIPv4('192.168.0.1');
    Validator::isIPv4('255.255.255.255');

__isPublicIPv4__ returns true for valid IPv4 addresses which are not in the private or reserved ranges

    // the following evaluate to true
    Validator::isPublicIPv4('1.1.1.1');
    Validator::isPublicIPv4('74.125.237.2');

    // the following evaluate to false
    Validator::isPublicIPv4('0.0.0.0');
    Validator::isPublicIPv4('10.0.0.1');
    Validator::isPublicIPv4('192.168.0.1');

__isIPv6__ returns true for any valid IPv6 address, including private and reserved addresses
__isPublicIPv6__ returns true for valid IPv6 addresses which are not considered non-routable
__isIP__ returns true for any valid IPv4 or IPv6 address
__isPublicIP__ returns true for any public IPv4 or IPv6 address

__isDomain__ returns true for any validly constructed domain name, including internationalisation in punycode notation

    // the following evaluate to true
    Validator::isDomain('example.com');
    Validator::isDomain('www.example.com.au');
    Validator::isDomain('www-2.example.com');

    // the following evaluate to false
    Validator::isDomain('example_1.com'); // underscores not allowed
    Validator::isDomain('example.'); // no TLD
    Validator::isDomain('example'); // no TLD

__isDomainWithValidTLD__ returns true for any validly constructed domain name that also contains a valid Top Level Domain (TLD)
By default, isDomainWithValidTLD will retrieve a list of valid TLDs from http://data.iana.org/TLD/tlds-alpha-by-domain.txt
If retrieval fails, or if you manually override using the optional parrameter, the function will use a local version of the file, which may not contain the most up-to-date information

    // the following evaluate to true
    Validator::isDomainWithValidTLD('example.travel');
    Validator::isDomainWithValidTLD('example.travel', true); // check using local copy

    Validator::isDomainWithValidTLD('example.xn--0zwm56d'); // Simplified Chinese
    Validator::isDomainWithValidTLD('example.xn--0zwm56d', true); // check using local copy
