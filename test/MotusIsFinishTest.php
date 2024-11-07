<?php

use
	PHPUnit\Framework\TestCase,
	Motus\Motus;

final class MotusIsFinishTest extends TestCase
{
	public function testIsFinish(): void
	{
		$motus = new Motus("test");

		$this->assertEquals($motus->isFinish(), false);

		$motus->input("test");

		$this->assertEquals($motus->isFinish(), true);
	}
}
