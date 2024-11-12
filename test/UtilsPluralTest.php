<?php

use
	PHPUnit\Framework\TestCase,
	Motus\Utils;

final class UtilsPluralTest extends TestCase {
	public function testPlural(): void {
		$this->assertEquals(Utils::plural(1), "");
		$this->assertEquals(Utils::plural(2), "s");
	}
}
