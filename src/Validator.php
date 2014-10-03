<?php namespace Hampel\Validate;

class Validator
{
	public function isEmail($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_EMAIL);

		if ($filtered === false) return false;
		else return true;
	}

	public function isBool($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
		if (is_null($filtered)) return false;
		else return true;
	}

	public function isIpv4($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);

		if ($filtered === false) return false;
		else return true;
	}

	public function isPublicIpv4($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);

		if ($filtered === false) return false;
		else return true;
	}

	public function isIpv6($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);

		if ($filtered === false) return false;
		else return true;
	}

	public function isPublicIpv6($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);

		if ($filtered === false) return false;
		else return true;
	}

	public function isIp($value)
	{
		return $this->isIpv4($value) OR $this->isIpv6($value);
	}

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
	 * @param $value string		the value to check
	 * @param $tlds array		optional array of TLDs to validate against (must be lowercase)
	 *
	 * @return bool
	 */
	public function isDomain($value, array $tlds = array())
	{
		if (!preg_match('/\b((?=[a-z0-9-]{1,63}\.)(xn--)?[a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,63}\b/ix', $value)) return false;

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
	 * @param $value
	 * @param array $tlds
	 *
	 * @return bool
	 */
	public function isTld($value, array $tlds)
	{
		if (empty($value) OR empty($tlds)) return false; // don't bother if no data passed

		if (strrpos($value, ".") === false) $tld = $value; // no . found in supplied value - assume it is already a TLD
		else $tld = substr(strrchr(strtolower($value), "."), 1); // extract the TLD from the supplied domain

		if (empty($tld)) return false; // didn't end up with anything usable

		return in_array($tld, $tlds);
	}
}

?>
