<?php namespace Hampel\Validate;

class Validator
{
	/**
	 * is the supplied value a validly formed email address?
	 *
	 * @param mixed $value	the value to check
	 *
	 * @return bool
	 */
	public function isEmail($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_EMAIL);

		if ($filtered === false) return false;
		else return true;
	}

	/**
	 * is the supplied value one PHP recognises as a boolean - "1", "true", "on", "yes",
	 * "0", "false", "off", "no", "" or null?
	 *
	 * @param mixed $value	the value to check
	 *
	 * @return bool
	 */
	public function isBool($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
		if (is_null($filtered)) return false;
		else return true;
	}

	/**
	 * is the supplied value an IPv4 address, including private and reserved ranges?
	 *
	 * @param mixed $value	the value to check
	 *
	 * @return bool
	 */
	public function isIpv4($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);

		if ($filtered === false) return false;
		else return true;
	}

	/**
	 * is the supplied value an IPv4 address outside the private and reserved ranges?
	 *
	 * @param mixed $value	the value to check
	 *
	 * @return bool
	 */
	public function isPublicIpv4($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);

		if ($filtered === false) return false;
		else return true;
	}

	/**
	 * is the supplied value an IPv6 address, including private and reserved ranges?
	 *
	 * @param mixed $value	the value to check
	 *
	 * @return bool
	 */
	public function isIpv6($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);

		if ($filtered === false) return false;
		else return true;
	}

	/**
	 * is the supplied value a public IPv6 address - ie not private, reserved or otherwise non-routable?
	 *
	 * We reject the RFC 3849 documentation range (2001:db8::/32) ourselves: PHP excluded it via
	 * FILTER_FLAG_NO_RES_RANGE up to 8.2, but 8.3 rebuilt its reserved-range table without it, so
	 * relying on the filter alone would give a different answer depending on the PHP version.
	 *
	 * @param mixed $value	the value to check
	 *
	 * @return bool
	 */
	public function isPublicIpv6($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);

		if ($filtered === false) return false;

		$packed = inet_pton($filtered);

		if ($packed === false) return false; // not addressable, so not public

		if (strncmp($packed, "\x20\x01\x0d\xb8", 4) === 0) return false; // 2001:db8::/32

		return true;
	}

	/**
	 * is the supplied value an IPv4 or IPv6 address?
	 *
	 * @param mixed $value	the value to check
	 *
	 * @return bool
	 */
	public function isIp($value)
	{
		return $this->isIpv4($value) OR $this->isIpv6($value);
	}

	/**
	 * is the supplied value a public IPv4 or IPv6 address?
	 *
	 * @param mixed $value	the value to check
	 *
	 * @return bool
	 */
	public function isPublicIp($value)
	{
		return $this->isPublicIpv4($value) OR $this->isPublicIpv6($value);
	}

	/**
	 * From RegexBuddy - http://www.regexbuddy.com/
	 * Domain name (internationalized, strict)
	 * Allow internationalized domains using punycode notation, as well as regular domain names
	 * Use lookahead to check that each part of the domain name is 63 characters or less"
	 *
	 * Pass in the array returned by getTlds() to the $tlds parameter to validate the domain against a list of valid TLDs
	 *
	 * @param mixed $value			the value to check
	 * @param string[] $tlds		optional array of TLDs to validate against (must be lowercase)
	 *
	 * @return bool
	 */
	public function isDomain($value, array $tlds = array())
	{
		if (!is_scalar($value) AND !$value instanceof \Stringable) return false;

		if (!preg_match('/\b((?=[a-z0-9-]{1,63}\.)(xn--)?[a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,63}\b/ix', (string) $value)) return false;

		if (!empty($tlds))
		{
			return $this->isTld($value, $tlds);
		}
		else return true;
	}

	/**
	 * is the supplied TLD valid according to the supplied list of TLDs?
	 * Note that this will also return true for any string with a valid TLD on the end - but does not validate the domain itself
	 *
	 * @param mixed $value			the value to check
	 * @param string[] $tlds		array of TLDs to validate against (must be lowercase)
	 *
	 * @return bool
	 */
	public function isTld($value, array $tlds)
	{
		if (empty($value) OR empty($tlds)) return false; // don't bother if no data passed

		if (!is_scalar($value) AND !$value instanceof \Stringable) return false;

		$value = (string) $value;

		$position = strrpos($value, ".");

		if ($position === false) $tld = $value; // no . found in supplied value - assume it is already a TLD
		else $tld = substr(strtolower($value), $position + 1); // extract the TLD from the supplied domain

		if (empty($tld)) return false; // didn't end up with anything usable

		return in_array($tld, $tlds);
	}
}
