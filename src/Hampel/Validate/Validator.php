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
	 */
	public static function isDomain($value)
	{
		if (preg_match("/\b((?=[a-z0-9-]{1,63}\.)(xn--)?[a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,63}\b/ix", $value)) return true;
		else return false;
	}

	/**
	 * Uses data from http://data.iana.org/TLD/tlds-alpha-by-domain.txt
	 *
	 * @param $value
	 *
	 * @return bool
	 */
	public static function isDomainWithValidTLD($value, $local_copy_only = false)
	{
		if (!self::isDomain($value)) return false; // fail quickly if it isn't a valid domain to start with

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

		if ($tld_file === false) return false;

		$tld_array = explode("\n", $tld_file);
		foreach ($tld_array as $tld)
		{
			$tld = trim($tld);
			if (empty($tld)) continue; // skip blank lines
			if (substr($tld, 0, 1) == "#") continue; // skip # comments

			$tlds[] = strtolower($tld);
		}

		$value_tld = substr(strrchr(strtolower($value), "."), 1);

		if (in_array($value_tld, $tlds)) return true;
		else return false;
	}
}

?>
