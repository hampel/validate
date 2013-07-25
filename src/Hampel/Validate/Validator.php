<?php namespace Hampel\Validate;
/**
 * 
 */

class Validator
{
	public static function isBool($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
		if (is_null($filtered)) return false;
		else return true;
	}

	public static function isIPv4($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);

		if ($filtered === false) return false;
		else return true;
	}

	public static function isPublicIPv4($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);

		if ($filtered === false) return false;
		else return true;
	}

	public static function isIPv6($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);

		if ($filtered === false) return false;
		else return true;
	}

	public static function isPublicIPv6($value)
	{
		$filtered = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);

		if ($filtered === false) return false;
		else return true;
	}

	public static function isIP($value)
	{
		return self::isIPv4($value) OR self::isIPv6($value);
	}

	public static function isPublicIP($value)
	{
		return self::isPublicIPv4($value) OR self::isPublicIPv6($value);
	}

	/**
	 * From RegexBuddy - http://www.regexbuddy.com/
	 * Domain name (internationalized, strict)
	 * Allow internationalized domains using punycode notation, as well as regular domain names
	 * Use lookahead to check that each part of the domain name is 63 characters or less"
	 *
	 * Pass in the array returned by getTLDs() to the $tlds parameter to validate the domain against a list of valid TLDs
	 *
	 * @param $value string		the value to check
	 * @param $tlds array		optional array of TLDs to validate against (must be lowercase)
	 *
	 * @return bool
	 */
	public static function isDomain($value, array $tlds = array())
	{
		if (!preg_match("/\b((?=[a-z0-9-]{1,63}\.)(xn--)?[a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,63}\b/ix", $value)) return false;

		if (!empty($tlds))
		{
			return self::isTLD($value, $tlds);
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
	public static function isTLD($value, array $tlds)
	{
		if (empty($value) OR empty($tlds)) return false; // don't bother if no data passed

		if (strrpos($value, ".") === false) $tld = $value; // no . found in supplied value - assume it is already a TLD
		else $tld = substr(strrchr(strtolower($value), "."), 1); // extract the TLD from the supplied domain

		if (empty($tld)) return false; // didn't end up with anything usable

		return in_array($tld, $tlds);
	}

	/**
	 * Uses data from http://data.iana.org/TLD/tlds-alpha-by-domain.txt
	 *
	 * @param $local_copy_only bool	use the locally stored version of the TLD file, which may not be as up to date, but avoids network traffic
	 *
	 * @return array of TLD strings
	 */
	public static function getTLDs($local_copy_only = false)
	{
		$tlds = array();
		$tld_file = false;

		// if we haven't been told to use the local copy only, try retrieving the TLD file from the web
		if (!$local_copy_only)
		{
			// read from IANA's list of TLDs in machine-readable format
			$tld_file = file_get_contents('http://data.iana.org/TLD/tlds-alpha-by-domain.txt');
		}

		// check if we have a valid $tld_file yet, if not, try getting the local copy
		if ($tld_file === false)
		{
			$tld_file = file_get_contents(__DIR__ . '/tlds-alpha-by-domain.txt');
		}

		if ($tld_file === false) return $tlds; // return an empty array on failure

		$tld_array = explode("\n", $tld_file);
		foreach ($tld_array as $tld)
		{
			$tld = trim($tld);
			if (empty($tld)) continue; // skip blank lines
			if (substr($tld, 0, 1) == "#") continue; // skip # comments

			$tlds[] = strtolower($tld);
		}

		return $tlds;
	}
}

?>
