<?php  namespace Hampel\Validate;

use Composer\Script\Event;

class ManageTlds
{
	static $source = "http://data.iana.org/TLD/tlds-alpha-by-domain.txt";

	private static $destination = 'src/tlds.php';

	public static function updateTlds(Event $event)
	{
		$args = $event->getArguments();

		$source = isset($args[0]) ? $args[0] : static::$source;

		if (empty($source)) return; // can't do anything without source data

		$tld_file = file_get_contents($source);
		if ($tld_file === false) return; // data retrieval failed, abort

		$tlds = array();
		$comments = array();

		$tld_array = explode("\n", $tld_file);
		foreach ($tld_array as $tld)
		{
			$tld = trim($tld);
			if (empty($tld)) continue; // skip blank lines
			if (substr($tld, 0, 1) == "#")
			{
				$comments[] = trim(substr($tld, 1));
				continue;// skip # comments
			}

			if (!preg_match('/^(?:[a-z]{2,63}|xn--[a-z0-9]+)$/i', $tld)) continue; // skip any invalid lines

			$tlds[] = strtolower($tld);
		}

		$output = '<?php' . PHP_EOL . '// From ' . $source . PHP_EOL;

		foreach ($comments as $comment)
		{
			$output .= "// {$comment}" . PHP_EOL;
		}
		$output .= 'return array(' . PHP_EOL;
		foreach ($tlds as $tld)
		{
			$output .= "\t'{$tld}'," . PHP_EOL;
		}
		$output .= ');' . PHP_EOL;

		file_put_contents(static::$destination, $output);

		$count = count($tlds);
		echo "{$count} TLDs written to " . static::$destination . PHP_EOL;
	}
}

?>
