<?php

class Motus {

	private $word = null;
	private $board = array();

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
		array_push($temp, mb_substr($word, 0, 1));

		for ($i = 1; $i < mb_strlen($word); $i++) {
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
		$wordArray = mb_str_split($this->word);
		$inputArray = mb_str_split($input);

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
		return mb_strlen($input) == mb_strlen($this->word) ? true : false;
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
			$result = mb_strtoupper($value[0]);
			for ($i = 1; $i < count($value); $i++) {
				$result .= " " . $value[$i];
			}
			echo $result . "\n";
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
		$wordArray = mb_str_split($this->word);
		$lastWord = end($this->board);
		$i = 0;

		foreach ($input as $value) {
			foreach (mb_str_split($value) as $char) {
				if ($char == 0) {
					array_push($result, "_");
				} elseif ($char == 1) {
					array_push($result, ".");
				} else {
					array_push($result, $wordArray[$i]);
				}
				$i++;
			}
		}

		if ($lastWord != null) {
			for ($j = 0; $j < count($lastWord); $j++) {
				if ($lastWord[$j] != "_" && $lastWord[$j] != ".") {
					$result[$j] = $lastWord[$j];
				}
			}
		}

		return $result;
	}

	/**
	 * Check if word exist
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return boolean
	 */
	public function isWord($input) {
		$post = curl_init('https://languagetool.org/api/v2/check');
		curl_setopt($post, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($post, CURLOPT_POSTFIELDS, http_build_query(["text" => $input, "language" => "fr"]));
		$response = curl_exec($post);
		if (curl_errno($post)) {
			echo "API error: " . curl_error($post) . "\n";
		}
		curl_close($post);

		$result = json_decode($response, true);

		return empty($result['matches']) ? true : false;
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
