CHANGELOG
=========

2.0.3 (2014-06-06)
------------------

* updated tlds-alpha-by-domain.txt to most recent version

2.0.2 (2014-06-01)
------------------

* removed dev dependency on phpunit

2.0.1 (2013-12-15)
------------------

* changed method names to be more camel-case-ish - shouldn't break functionality (methods are case-insensitive)
* updated to latest http://data.iana.org/TLD/tlds-alpha-by-domain.txt
* updated unit tests to use changed method names, changed test punycode TLD to xn--3e0b707e, since the previously used
  TLD was an IANA test and disappeared from the list
* updated README with new method names and example punycode TLD

2.0.0 (2013-10-11)
------------------

* rewrote class to not use static methods
* updated tlds-alpha-by-domain.txt to most recent version

1.1.0 (2013-10-10)
------------------

* added new function isEmail

1.0.0 (2013-08-29)
------------------

* updated composer.json
* updated README
* added CHANGELOG

0.1.0 (2013-07-25)
------------------

* initial release
* added functions isBool, isIPv4, isPublicIPv4, isIPv6, isPublicIPv6, isIP, isPublicIP, isDomain, isTLD, getTLDs
