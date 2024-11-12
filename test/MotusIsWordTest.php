<?php

use
	PHPUnit\Framework\TestCase,
	Motus\Motus;

final class MotusIsWordTest extends TestCase {
	public function testIsWord(): void {
		$motus = new Motus("test");

		$this->assertEquals($motus->isWord("mot"), true);
		$this->assertEquals($motus->isWord("pasunmot"), false);
	}
}
