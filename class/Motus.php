<?php

class Motus {

	public $word = null;
	public $board = array();

	/**
	 * Main motus object class
	 *
	 * @param string $word Motus's word
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return void
	 */
	public function __construct($word) {
		$this->word = $word;

		$temp = array();
		array_push($temp, substr($word, 0, 1));

		for ($i = 1; $i < strlen($word); $i++) {
			array_push($temp, "0");
		}

		$this->addBoard($temp);
	}

	/**
	 * Check input with word
	 *
	 * @param string $input User's input word
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return void
	 */
	public function check($input) {
		$result = array();
		$wordArray = str_split($this->word);
		$inputArray = str_split($input);

		for ($i = 0; $i < count($wordArray); $i++) {
			array_push($result, 0);
		}

		for ($i = 0; $i < count($wordArray); $i++) {
			if (str_contains($this->word, $inputArray[$i])) {
				$result[$i] = 1;
			}

			if ($wordArray[$i] == $inputArray[$i]) {
				$result[$i] = 2;
			}
		}

		$this->addBoard($result);
	}

	/**
	 * Check user's input word length
	 *
	 * @param string $input User's input word
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return boolean
	 */
	public function checkLength($input) {
		return strlen($input) == strlen($this->word) ? true : false;
	}

	/**
	 * Display game's board
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return void
	 */
	public function display() {
		foreach ($this->board as $value) {
			foreach ($value as $char) {
				echo "$char";
			}
			echo "\n";
		}
	}

	/**
	 * Add formatted word to game's board
	 *
	 * @param array $value Input word
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return void
	 */
	private function addBoard($value) {
		array_push($this->board, $this->translate($value));
	}

	/**
	 * Translate to humain readeable word
	 *
	 * @param array $input Input word
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return array
	 */
	private function translate($input) {
		$result = array();
		$wordArray = str_split($this->word);
		$lastWord = end($this->board);
		$i = 0;

		foreach ($input as $value) {
			foreach (str_split($value) as $char) {
				if ($char == 0) {
					array_push($result, "_");
				}
				elseif ($char == 1) {
					array_push($result, ".");
				} else {
					array_push($result, $wordArray[$i]);
				}
				$i++;
			}
		}

		if ($lastWord != null) {
			for ($j = 0; $j < count($lastWord); $j++) {
				if (ctype_alpha($lastWord[$j])) {
					$result[$j] = $lastWord[$j];
				}
			}
		}

		return $result;
	}

	/**
	 * Check for game end
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return boolean
	 */
	public function isFinish() {
		if (join("", end($this->board)) == $this->word) {
			return true;
		}
		return false;
	}
}
