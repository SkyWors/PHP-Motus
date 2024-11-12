<?php

use
	PHPUnit\Framework\TestCase,
	Motus\Motus;

final class MotusCheckFirstLetterTest extends TestCase {
	public function testCheckFirstLetter(): void {
		$motus = new Motus("test");

		$this->assertEquals($motus->checkFirstLetter("test"), true);
		$this->assertEquals($motus->checkFirstLetter("nottest"), false);
	}
}
