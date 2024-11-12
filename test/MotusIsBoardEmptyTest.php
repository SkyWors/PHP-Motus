<?php

use
	PHPUnit\Framework\TestCase,
	Motus\Motus;

final class MotusIsBoardEmptyTest extends TestCase {
	public function testIsBoardEmpty(): void {
		$motus = new Motus("test");

		$this->assertEquals($motus->isBoardEmpty(), true);

		$motus->input("test");

		$this->assertEquals($motus->isBoardEmpty(), false);
	}
}
