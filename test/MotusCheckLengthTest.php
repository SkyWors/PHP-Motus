<?php

use
	PHPUnit\Framework\TestCase,
	Motus\Motus;

final class MotusCheckLengthTest extends TestCase
{
	public function testCheckLength(): void
	{
		$motus = new Motus("test");

		$this->assertEquals($motus->checkLength("test"), true);
		$this->assertEquals($motus->checkLength("nottest"), false);
	}
}
