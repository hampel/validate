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

	public function testIsIpv4()
	{
		$this->assertTrue($this->validator->isIpv4('0.0.0.0'));
		$this->assertTrue($this->validator->isIpv4('1.1.1.1'));
		$this->assertTrue($this->validator->isIpv4('10.0.0.1'));
		$this->assertTrue($this->validator->isIpv4('192.168.0.1'));
		$this->assertTrue($this->validator->isIpv4('255.255.255.255'));

		$this->assertFalse($this->validator->isIpv4('foo'));
		$this->assertFalse($this->validator->isIpv4('1.0.0.256'));
	}

	public function testIsPublicIpv4()
	{
		$this->assertTrue($this->validator->isPublicIpv4('1.1.1.1'));
		$this->assertTrue($this->validator->isPublicIpv4('74.125.237.2'));

		$this->assertFalse($this->validator->isPublicIpv4('foo'));
		$this->assertFalse($this->validator->isPublicIpv4('0.0.0.0'));
		$this->assertFalse($this->validator->isPublicIpv4('1.0.0.256'));
		$this->assertFalse($this->validator->isPublicIpv4('10.0.0.1'));
		$this->assertFalse($this->validator->isPublicIpv4('192.168.0.1'));
	}

	public function testIsIpv6()
	{
		$this->assertTrue($this->validator->isIpv6('2001:0db8:0000:0000:0000:ff00:0042:8329'));
		$this->assertTrue($this->validator->isIpv6('2001:db8:0:0:0:ff00:42:8329'));
		$this->assertTrue($this->validator->isIpv6('2001:db8::ff00:42:8329'));
		$this->assertTrue($this->validator->isIpv6('0000:0000:0000:0000:0000:0000:0000:0001'));
		$this->assertTrue($this->validator->isIpv6('::1'));

		$this->assertFalse($this->validator->isIpv6('foo'));
		$this->assertFalse($this->validator->isIpv6('0.0.0.0'));
		$this->assertFalse($this->validator->isIpv6('1.1.1.1'));
		$this->assertFalse($this->validator->isIpv6('10.0.0.1'));
	}

	public function testIsPublicIpv6()
	{
		$this->assertTrue($this->validator->isPublicIpv6('2001:db8:0:0:0:ff00:42:8329'));
		$this->assertTrue($this->validator->isPublicIpv6('2001:db8::ff00:42:8329'));
		$this->assertTrue($this->validator->isPublicIpv6('0000:0000:0000:0000:0000:0000:0000:0001'));

		$this->assertFalse($this->validator->isPublicIpv6('::1'));
		$this->assertFalse($this->validator->isPublicIpv6('fd01:db8:0:0:0:ff00:42:8329'));
		$this->assertFalse($this->validator->isPublicIpv6('foo'));
		$this->assertFalse($this->validator->isPublicIpv6('0.0.0.0'));
		$this->assertFalse($this->validator->isPublicIpv6('1.1.1.1'));
		$this->assertFalse($this->validator->isPublicIpv6('10.0.0.1'));
	}

	public function testIsIp()
	{
		$this->assertTrue($this->validator->isIp('0.0.0.0'));
		$this->assertTrue($this->validator->isIp('1.1.1.1'));
		$this->assertTrue($this->validator->isIp('10.0.0.1'));
		$this->assertTrue($this->validator->isIp('192.168.0.1'));
		$this->assertTrue($this->validator->isIp('255.255.255.255'));
		$this->assertTrue($this->validator->isIp('2001:0db8:0000:0000:0000:ff00:0042:8329'));
		$this->assertTrue($this->validator->isIp('2001:db8:0:0:0:ff00:42:8329'));
		$this->assertTrue($this->validator->isIp('2001:db8::ff00:42:8329'));
		$this->assertTrue($this->validator->isIp('0000:0000:0000:0000:0000:0000:0000:0001'));
		$this->assertTrue($this->validator->isIp('::1'));

		$this->assertFalse($this->validator->isIp('foo'));
		$this->assertFalse($this->validator->isIp('1.0.0.256'));
	}

	public function testIsPublicIp()
	{
		$this->assertTrue($this->validator->isPublicIp('1.1.1.1'));
		$this->assertTrue($this->validator->isPublicIp('74.125.237.2'));
		$this->assertTrue($this->validator->isPublicIp('2001:db8:0:0:0:ff00:42:8329'));
		$this->assertTrue($this->validator->isPublicIp('2001:db8::ff00:42:8329'));
		$this->assertTrue($this->validator->isPublicIp('0000:0000:0000:0000:0000:0000:0000:0001'));

		$this->assertFalse($this->validator->isPublicIp('foo'));
		$this->assertFalse($this->validator->isPublicIp('0.0.0.0'));
		$this->assertFalse($this->validator->isPublicIp('1.0.0.256'));
		$this->assertFalse($this->validator->isPublicIp('10.0.0.1'));
		$this->assertFalse($this->validator->isPublicIp('192.168.0.1'));
		$this->assertFalse($this->validator->isPublicIp('::1'));
		$this->assertFalse($this->validator->isPublicIp('fd01:db8:0:0:0:ff00:42:8329'));
	}

	public function testisTld()
	{
		$tlds = array('com', 'au', 'travel', 'xn--3e0b707e'); // use mock data

		$this->assertTrue($this->validator->isTld('com', $tlds));
		$this->assertTrue($this->validator->isTld('au', $tlds));
		$this->assertTrue($this->validator->isTld('travel', $tlds));
		$this->assertTrue($this->validator->isTld('xn--3e0b707e', $tlds));

		$this->assertTrue($this->validator->isTld('example.com', $tlds));
		$this->assertTrue($this->validator->isTld('example.com.au', $tlds));
		$this->assertTrue($this->validator->isTld('example.travel', $tlds));
		$this->assertTrue($this->validator->isTld('example.xn--3e0b707e', $tlds));

		$this->assertTrue($this->validator->isTld('.com', $tlds));
		$this->assertTrue($this->validator->isTld('.travel', $tlds));
		$this->assertTrue($this->validator->isTld('.xn--3e0b707e', $tlds));

		$this->assertTrue($this->validator->isTld('---.com', $tlds)); // true because it doesn't validate domains

		$this->assertFalse($this->validator->isTld('', $tlds));
		$this->assertFalse($this->validator->isTld('', array()));
		$this->assertFalse($this->validator->isTld('foo', $tlds));
		$this->assertFalse($this->validator->isTld('0', $tlds));
		$this->assertFalse($this->validator->isTld('example.foo', $tlds));
	}

	public function testIsDomain()
	{
		$tlds = array('com', 'au', 'travel', 'xn--3e0b707e'); // use mock data

		$this->assertTrue($this->validator->isDomain('example.com'));
		$this->assertTrue($this->validator->isDomain('www.example.com.au'));
		$this->assertTrue($this->validator->isDomain('www-2.example.com'));
		$this->assertTrue($this->validator->isDomain('example.foo')); // true because it doesn't validate Tld

		$this->assertFalse($this->validator->isDomain('example_1.com'));
		$this->assertFalse($this->validator->isDomain('example.'));
		$this->assertFalse($this->validator->isDomain('example'));
		$this->assertFalse($this->validator->isDomain('e'));
		$this->assertFalse($this->validator->isDomain('0'));

		$this->assertTrue($this->validator->isDomain('example.com', $tlds));
		$this->assertTrue($this->validator->isDomain('www.example.com.au', $tlds));
		$this->assertTrue($this->validator->isDomain('www-2.example.com', $tlds));
		$this->assertTrue($this->validator->isDomain('example.travel', $tlds));
		$this->assertTrue($this->validator->isDomain('example.xn--3e0b707e', $tlds));

		$this->assertFalse($this->validator->isDomain('---.com', $tlds)); // false because we validate both domain and Tld

		$this->assertFalse($this->validator->isDomain('', $tlds));
		$this->assertFalse($this->validator->isDomain('example.com', array("net")));
		$this->assertFalse($this->validator->isDomain('example.foo', $tlds)); // false because we validated the Tld this time
		$this->assertFalse($this->validator->isDomain('example.travelx', $tlds));
		$this->assertFalse($this->validator->isDomain('example_1.com', $tlds)); // invalid domain portion
		$this->assertFalse($this->validator->isDomain('example.', $tlds));
		$this->assertFalse($this->validator->isDomain('example', $tlds));
		$this->assertFalse($this->validator->isDomain('e', $tlds));
		$this->assertFalse($this->validator->isDomain('0', $tlds));
	}

}

?>