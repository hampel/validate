<?php namespace Hampel\Validate;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
	public function testIsBool()
	{
		$this->assertTrue(Validator::isBool(true));
		$this->assertTrue(Validator::isBool(1));
		$this->assertTrue(Validator::isBool('on'));
		$this->assertTrue(Validator::isBool('yes'));
		$this->assertTrue(Validator::isBool(false));
		$this->assertTrue(Validator::isBool(0));
		$this->assertTrue(Validator::isBool('off'));
		$this->assertTrue(Validator::isBool('no'));
		$this->assertTrue(Validator::isBool(''));
		$this->assertTrue(Validator::isBool(null));

		$this->assertFalse(Validator::isBool('foo'));
		$this->assertFalse(Validator::isBool(2));
	}

	public function testIsIPv4()
	{
		$this->assertTrue(Validator::isIPv4('0.0.0.0'));
		$this->assertTrue(Validator::isIPv4('1.1.1.1'));
		$this->assertTrue(Validator::isIPv4('10.0.0.1'));
		$this->assertTrue(Validator::isIPv4('192.168.0.1'));
		$this->assertTrue(Validator::isIPv4('255.255.255.255'));

		$this->assertFalse(Validator::isIPv4('foo'));
		$this->assertFalse(Validator::isIPv4('1.0.0.256'));
	}

	public function testIsPublicIPv4()
	{
		$this->assertTrue(Validator::isPublicIPv4('1.1.1.1'));
		$this->assertTrue(Validator::isPublicIPv4('74.125.237.2'));

		$this->assertFalse(Validator::isPublicIPv4('foo'));
		$this->assertFalse(Validator::isPublicIPv4('0.0.0.0'));
		$this->assertFalse(Validator::isPublicIPv4('1.0.0.256'));
		$this->assertFalse(Validator::isPublicIPv4('10.0.0.1'));
		$this->assertFalse(Validator::isPublicIPv4('192.168.0.1'));
	}

	public function testIsIPv6()
	{
		$this->assertTrue(Validator::isIPv6('2001:0db8:0000:0000:0000:ff00:0042:8329'));
		$this->assertTrue(Validator::isIPv6('2001:db8:0:0:0:ff00:42:8329'));
		$this->assertTrue(Validator::isIPv6('2001:db8::ff00:42:8329'));
		$this->assertTrue(Validator::isIPv6('0000:0000:0000:0000:0000:0000:0000:0001'));
		$this->assertTrue(Validator::isIPv6('::1'));

		$this->assertFalse(Validator::isIPv6('foo'));
		$this->assertFalse(Validator::isIPv6('0.0.0.0'));
		$this->assertFalse(Validator::isIPv6('1.1.1.1'));
		$this->assertFalse(Validator::isIPv6('10.0.0.1'));
	}

	public function testIsPublicIPv6()
	{
		$this->assertTrue(Validator::isPublicIPv6('2001:db8:0:0:0:ff00:42:8329'));
		$this->assertTrue(Validator::isPublicIPv6('2001:db8::ff00:42:8329'));
		$this->assertTrue(Validator::isPublicIPv6('0000:0000:0000:0000:0000:0000:0000:0001'));

		$this->assertFalse(Validator::isPublicIPv6('::1'));
		$this->assertFalse(Validator::isPublicIPv6('fd01:db8:0:0:0:ff00:42:8329'));
		$this->assertFalse(Validator::isPublicIPv6('foo'));
		$this->assertFalse(Validator::isPublicIPv6('0.0.0.0'));
		$this->assertFalse(Validator::isPublicIPv6('1.1.1.1'));
		$this->assertFalse(Validator::isPublicIPv6('10.0.0.1'));
	}

	public function testIsIP()
	{
		$this->assertTrue(Validator::isIP('0.0.0.0'));
		$this->assertTrue(Validator::isIP('1.1.1.1'));
		$this->assertTrue(Validator::isIP('10.0.0.1'));
		$this->assertTrue(Validator::isIP('192.168.0.1'));
		$this->assertTrue(Validator::isIP('255.255.255.255'));
		$this->assertTrue(Validator::isIP('2001:0db8:0000:0000:0000:ff00:0042:8329'));
		$this->assertTrue(Validator::isIP('2001:db8:0:0:0:ff00:42:8329'));
		$this->assertTrue(Validator::isIP('2001:db8::ff00:42:8329'));
		$this->assertTrue(Validator::isIP('0000:0000:0000:0000:0000:0000:0000:0001'));
		$this->assertTrue(Validator::isIP('::1'));

		$this->assertFalse(Validator::isIP('foo'));
		$this->assertFalse(Validator::isIP('1.0.0.256'));
	}

	public function testIsPublicIP()
	{
		$this->assertTrue(Validator::isPublicIP('1.1.1.1'));
		$this->assertTrue(Validator::isPublicIP('74.125.237.2'));
		$this->assertTrue(Validator::isPublicIP('2001:db8:0:0:0:ff00:42:8329'));
		$this->assertTrue(Validator::isPublicIP('2001:db8::ff00:42:8329'));
		$this->assertTrue(Validator::isPublicIP('0000:0000:0000:0000:0000:0000:0000:0001'));

		$this->assertFalse(Validator::isPublicIP('foo'));
		$this->assertFalse(Validator::isPublicIP('0.0.0.0'));
		$this->assertFalse(Validator::isPublicIP('1.0.0.256'));
		$this->assertFalse(Validator::isPublicIP('10.0.0.1'));
		$this->assertFalse(Validator::isPublicIP('192.168.0.1'));
		$this->assertFalse(Validator::isPublicIP('::1'));
		$this->assertFalse(Validator::isPublicIP('fd01:db8:0:0:0:ff00:42:8329'));
	}

	public function testIsDomain()
	{
		$this->assertTrue(Validator::isDomain('example.com'));
		$this->assertTrue(Validator::isDomain('www.example.com.au'));
		$this->assertTrue(Validator::isDomain('www-2.example.com'));

		$this->assertFalse(Validator::isDomain('example_1.com'));
		$this->assertFalse(Validator::isDomain('example.'));
		$this->assertFalse(Validator::isDomain('example'));
		$this->assertFalse(Validator::isDomain('e'));
		$this->assertFalse(Validator::isDomain('0'));

	}

	public function testIsDomainWithValidTLD()
	{
		$this->assertTrue(Validator::isDomainWithValidTLD('example.com'));
		$this->assertTrue(Validator::isDomainWithValidTLD('www.example.com.au'));
		$this->assertTrue(Validator::isDomainWithValidTLD('www-2.example.com'));
		$this->assertTrue(Validator::isDomainWithValidTLD('example.travel'));
		$this->assertTrue(Validator::isDomainWithValidTLD('example.xn--0zwm56d'));

		$this->assertFalse(Validator::isDomainWithValidTLD('example.travelx'));
		$this->assertFalse(Validator::isDomainWithValidTLD('example_1.com'));
		$this->assertFalse(Validator::isDomainWithValidTLD('example.'));
		$this->assertFalse(Validator::isDomainWithValidTLD('example'));
		$this->assertFalse(Validator::isDomainWithValidTLD('e'));
		$this->assertFalse(Validator::isDomainWithValidTLD('0'));

		$this->assertTrue(Validator::isDomainWithValidTLD('example.com', true));
		$this->assertTrue(Validator::isDomainWithValidTLD('www.example.com.au', true));
		$this->assertTrue(Validator::isDomainWithValidTLD('www-2.example.com', true));
		$this->assertTrue(Validator::isDomainWithValidTLD('example.travel', true));
		$this->assertTrue(Validator::isDomainWithValidTLD('example.xn--0zwm56d', true));

		$this->assertFalse(Validator::isDomainWithValidTLD('example.travelx', true));
		$this->assertFalse(Validator::isDomainWithValidTLD('example_1.com', true));
		$this->assertFalse(Validator::isDomainWithValidTLD('example.', true));
		$this->assertFalse(Validator::isDomainWithValidTLD('example', true));
		$this->assertFalse(Validator::isDomainWithValidTLD('e', true));
		$this->assertFalse(Validator::isDomainWithValidTLD('0', true));
	}
}

?>