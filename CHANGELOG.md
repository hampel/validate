CHANGELOG
=========

2.2.0 (2014-10-03)
------------------

* validation functionality has not changed from previous versions, but we have removed the Validator::getTlds() method
and the ManageTlds class and instead leave it up to the implementer to supply a list of valid TLDs to use in the
relevant validation functions.

2.1.3 (2014-10-02)
------------------

* logic bugfix where we weren't actually getting the latest TLDs in Validator::getTlds()

2.1.2 (2014-10-02)
------------------

* updated to latest http://data.iana.org/TLD/tlds-alpha-by-domain.txt

2.1.1 (2014-08-18)
------------------

* added additional check to ignore any badly formatted strings from the downloaded TLD source file for security reasons

2.1.0 (2014-08-18)
------------------

* convert to psr-4 autoloading; added phpunit back in to require-dev in composer.json
* new script to generate the local TLD list - invokeable via Composer
* modified default behaviour of getTlds to use local version by default - uses new pre-built file rather than parsing
downloaded text file

2.0.5 (2014-08-18)
------------------

* updated to latest http://data.iana.org/TLD/tlds-alpha-by-domain.txt

2.0.4 (2014-08-07)
------------------

* updated tlds-alpha-by-domain.txt to most recent version

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
