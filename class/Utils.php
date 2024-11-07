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


	/**
	 * Return random word
	 *
	 * @param string $lang Word language
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return string
	 */
	public static function randomWord(string $lang) : string {
		$get = curl_init("https://random-word-api.herokuapp.com/word?lang=$lang");
		curl_setopt($get, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($get);
		if (curl_errno($get)) {
			echo "API error: " . curl_error($get) . "\n";
		}
		curl_close($get);

		$result = json_decode($response, true);

		return $result[0] ?? null;
	}
}
