<?php namespace Hampel\Validate;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->validator = new Validator;
	}

	public function testIsEmail()
	{
		$this->assertTrue($this->validator->isEmail('foo@gmail.com'));
		$this->assertFalse($this->validator->isEmail('foo@gmail'));
		$this->assertFalse($this->validator->isEmail('foo'));
	}

	public function testIsBool()
	{
		$this->assertTrue($this->validator->isBool(true));
		$this->assertTrue($this->validator->isBool(1));
		$this->assertTrue($this->validator->isBool('on'));
		$this->assertTrue($this->validator->isBool('yes'));
		$this->assertTrue($this->validator->isBool(false));
		$this->assertTrue($this->validator->isBool(0));
		$this->assertTrue($this->validator->isBool('off'));
		$this->assertTrue($this->validator->isBool('no'));
		$this->assertTrue($this->validator->isBool(''));
		$this->assertTrue($this->validator->isBool(null));

		$this->assertFalse($this->validator->isBool('foo'));
		$this->assertFalse($this->validator->isBool(2));
	}

	public function testIsIPv4()
	{
		$this->assertTrue($this->validator->isIPv4('0.0.0.0'));
		$this->assertTrue($this->validator->isIPv4('1.1.1.1'));
		$this->assertTrue($this->validator->isIPv4('10.0.0.1'));
		$this->assertTrue($this->validator->isIPv4('192.168.0.1'));
		$this->assertTrue($this->validator->isIPv4('255.255.255.255'));

		$this->assertFalse($this->validator->isIPv4('foo'));
		$this->assertFalse($this->validator->isIPv4('1.0.0.256'));
	}

	public function testIsPublicIPv4()
	{
		$this->assertTrue($this->validator->isPublicIPv4('1.1.1.1'));
		$this->assertTrue($this->validator->isPublicIPv4('74.125.237.2'));

		$this->assertFalse($this->validator->isPublicIPv4('foo'));
		$this->assertFalse($this->validator->isPublicIPv4('0.0.0.0'));
		$this->assertFalse($this->validator->isPublicIPv4('1.0.0.256'));
		$this->assertFalse($this->validator->isPublicIPv4('10.0.0.1'));
		$this->assertFalse($this->validator->isPublicIPv4('192.168.0.1'));
	}

	public function testIsIPv6()
	{
		$this->assertTrue($this->validator->isIPv6('2001:0db8:0000:0000:0000:ff00:0042:8329'));
		$this->assertTrue($this->validator->isIPv6('2001:db8:0:0:0:ff00:42:8329'));
		$this->assertTrue($this->validator->isIPv6('2001:db8::ff00:42:8329'));
		$this->assertTrue($this->validator->isIPv6('0000:0000:0000:0000:0000:0000:0000:0001'));
		$this->assertTrue($this->validator->isIPv6('::1'));

		$this->assertFalse($this->validator->isIPv6('foo'));
		$this->assertFalse($this->validator->isIPv6('0.0.0.0'));
		$this->assertFalse($this->validator->isIPv6('1.1.1.1'));
		$this->assertFalse($this->validator->isIPv6('10.0.0.1'));
	}

	public function testIsPublicIPv6()
	{
		$this->assertTrue($this->validator->isPublicIPv6('2001:db8:0:0:0:ff00:42:8329'));
		$this->assertTrue($this->validator->isPublicIPv6('2001:db8::ff00:42:8329'));
		$this->assertTrue($this->validator->isPublicIPv6('0000:0000:0000:0000:0000:0000:0000:0001'));

		$this->assertFalse($this->validator->isPublicIPv6('::1'));
		$this->assertFalse($this->validator->isPublicIPv6('fd01:db8:0:0:0:ff00:42:8329'));
		$this->assertFalse($this->validator->isPublicIPv6('foo'));
		$this->assertFalse($this->validator->isPublicIPv6('0.0.0.0'));
		$this->assertFalse($this->validator->isPublicIPv6('1.1.1.1'));
		$this->assertFalse($this->validator->isPublicIPv6('10.0.0.1'));
	}

	public function testIsIP()
	{
		$this->assertTrue($this->validator->isIP('0.0.0.0'));
		$this->assertTrue($this->validator->isIP('1.1.1.1'));
		$this->assertTrue($this->validator->isIP('10.0.0.1'));
		$this->assertTrue($this->validator->isIP('192.168.0.1'));
		$this->assertTrue($this->validator->isIP('255.255.255.255'));
		$this->assertTrue($this->validator->isIP('2001:0db8:0000:0000:0000:ff00:0042:8329'));
		$this->assertTrue($this->validator->isIP('2001:db8:0:0:0:ff00:42:8329'));
		$this->assertTrue($this->validator->isIP('2001:db8::ff00:42:8329'));
		$this->assertTrue($this->validator->isIP('0000:0000:0000:0000:0000:0000:0000:0001'));
		$this->assertTrue($this->validator->isIP('::1'));

		$this->assertFalse($this->validator->isIP('foo'));
		$this->assertFalse($this->validator->isIP('1.0.0.256'));
	}

	public function testIsPublicIP()
	{
		$this->assertTrue($this->validator->isPublicIP('1.1.1.1'));
		$this->assertTrue($this->validator->isPublicIP('74.125.237.2'));
		$this->assertTrue($this->validator->isPublicIP('2001:db8:0:0:0:ff00:42:8329'));
		$this->assertTrue($this->validator->isPublicIP('2001:db8::ff00:42:8329'));
		$this->assertTrue($this->validator->isPublicIP('0000:0000:0000:0000:0000:0000:0000:0001'));

		$this->assertFalse($this->validator->isPublicIP('foo'));
		$this->assertFalse($this->validator->isPublicIP('0.0.0.0'));
		$this->assertFalse($this->validator->isPublicIP('1.0.0.256'));
		$this->assertFalse($this->validator->isPublicIP('10.0.0.1'));
		$this->assertFalse($this->validator->isPublicIP('192.168.0.1'));
		$this->assertFalse($this->validator->isPublicIP('::1'));
		$this->assertFalse($this->validator->isPublicIP('fd01:db8:0:0:0:ff00:42:8329'));
	}

	public function testGetTLDs()
	{
		$tlds = $this->validator->getTLDs(true); // use local copy

		$this->assertTrue(in_array('com', $tlds));
		$this->assertTrue(in_array('au', $tlds));
		$this->assertTrue(in_array('travel', $tlds));
		$this->assertTrue(in_array('xn--0zwm56d', $tlds));
	}

	/**
	 * @group network
	 */
	public function testGetTLDsNetwork()
	{
		$tlds = $this->validator->getTLDs(); // use network copy

		$this->assertTrue(in_array('com', $tlds));
		$this->assertTrue(in_array('au', $tlds));
		$this->assertTrue(in_array('travel', $tlds));
		$this->assertTrue(in_array('xn--0zwm56d', $tlds));

	}

	public function testisTLD()
	{
		$tlds = array('com', 'au', 'travel', 'xn--0zwm56d'); // use mock data

		$this->assertTrue($this->validator->isTLD('com', $tlds));
		$this->assertTrue($this->validator->isTLD('au', $tlds));
		$this->assertTrue($this->validator->isTLD('travel', $tlds));
		$this->assertTrue($this->validator->isTLD('xn--0zwm56d', $tlds));

		$this->assertTrue($this->validator->isTLD('example.com', $tlds));
		$this->assertTrue($this->validator->isTLD('example.com.au', $tlds));
		$this->assertTrue($this->validator->isTLD('example.travel', $tlds));
		$this->assertTrue($this->validator->isTLD('example.xn--0zwm56d', $tlds));

		$this->assertTrue($this->validator->isTLD('.com', $tlds));
		$this->assertTrue($this->validator->isTLD('.travel', $tlds));
		$this->assertTrue($this->validator->isTLD('.xn--0zwm56d', $tlds));

		$this->assertTrue($this->validator->isTLD('---.com', $tlds)); // true because it doesn't validate domains

		$this->assertFalse($this->validator->isTLD('', $tlds));
		$this->assertFalse($this->validator->isTLD('', array()));
		$this->assertFalse($this->validator->isTLD('foo', $tlds));
		$this->assertFalse($this->validator->isTLD('0', $tlds));
		$this->assertFalse($this->validator->isTLD('example.foo', $tlds));
	}

	public function testIsDomain()
	{
		$tlds = array('com', 'au', 'travel', 'xn--0zwm56d'); // use mock data

		$this->assertTrue($this->validator->isDomain('example.com'));
		$this->assertTrue($this->validator->isDomain('www.example.com.au'));
		$this->assertTrue($this->validator->isDomain('www-2.example.com'));
		$this->assertTrue($this->validator->isDomain('example.foo')); // true because it doesn't validate TLD

		$this->assertFalse($this->validator->isDomain('example_1.com'));
		$this->assertFalse($this->validator->isDomain('example.'));
		$this->assertFalse($this->validator->isDomain('example'));
		$this->assertFalse($this->validator->isDomain('e'));
		$this->assertFalse($this->validator->isDomain('0'));

		$this->assertTrue($this->validator->isDomain('example.com', $tlds));
		$this->assertTrue($this->validator->isDomain('www.example.com.au', $tlds));
		$this->assertTrue($this->validator->isDomain('www-2.example.com', $tlds));
		$this->assertTrue($this->validator->isDomain('example.travel', $tlds));
		$this->assertTrue($this->validator->isDomain('example.xn--0zwm56d', $tlds));

		$this->assertFalse($this->validator->isDomain('---.com', $tlds)); // false because we validate both domain and TLD

		$this->assertFalse($this->validator->isDomain('', $tlds));
		$this->assertFalse($this->validator->isDomain('example.com', array("net")));
		$this->assertFalse($this->validator->isDomain('example.foo', $tlds)); // false because we validated the TLD this time
		$this->assertFalse($this->validator->isDomain('example.travelx', $tlds));
		$this->assertFalse($this->validator->isDomain('example_1.com', $tlds)); // invalid domain portion
		$this->assertFalse($this->validator->isDomain('example.', $tlds));
		$this->assertFalse($this->validator->isDomain('example', $tlds));
		$this->assertFalse($this->validator->isDomain('e', $tlds));
		$this->assertFalse($this->validator->isDomain('0', $tlds));
	}

}

?>