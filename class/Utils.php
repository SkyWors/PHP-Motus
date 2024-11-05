<?php

namespace Motus;

class Utils {

	/**
	 * Clear game CLI
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return void
	 */
	public static function clear() : void {
		for ($i = 0; $i < 10; $i++) {
			echo "\n";
		}
	}

	/**
	 * Return plural syntax if needed
	 *
	 * @param int $number Plural quantity
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return string
	 */
	public static function plural(int $number) : string {
		if ($number === 1) {
			return "";
		} else {
			return "s";
		}
	}
}
