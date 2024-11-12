<?php

namespace Motus;

enum Color : string {
	case RESET = "\033[0m";
	case RED = "\e[31m";
	case YELLOW = "\e[33m";
	case RED_BG = "\033[41m";
	case YELLOW_BG = "\033[43m";
	case BOLD = "\e[1m";
}

class Motus {
	private $board = [];
	private $word = "";

	/**
	 * Main motus object class
	 *
	 * @param string $word Motus's word
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return void
	 */
	public function __construct(string $word) {
		$this->word = $word;
	}

	/**
	 * Add user's input word to board
	 *
	 * @param string $input User's input word
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return void
	 */
	public function input(string $input) : void {
		array_push($this->board, $input);
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
	public function checkLength(string $input) : bool {
		return mb_strlen($input) == mb_strlen($this->word) ? true : false;
	}

	/**
	 * Check user's input word first letter
	 *
	 * @param string $input User's input word
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return boolean
	 */
	public function checkFirstLetter(string $input) : bool {
		return mb_strtoupper(mb_substr($input, 0, 1)) === mb_strtoupper(mb_substr($this->word, 0, 1)) ? true : false;
	}

	/**
	 * Check if board is empty
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return boolean
	 */
	public function isBoardEmpty() : bool {
		return empty($this->board) ? true : false;
	}

	/**
	 * Check if word exist
	 *
	 * @param string $input User's input word
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return boolean
	 */
	public function isWord(string $input) : bool {
		$post = curl_init("https://languagetool.org/api/v2/check");
		curl_setopt($post, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($post, CURLOPT_POSTFIELDS, http_build_query(["text" => $input, "language" => "fr"]));
		$response = curl_exec($post);
		if (curl_errno($post)) {
			echo "API error: " . curl_error($post) . "\n";
		}
		curl_close($post);

		$result = json_decode($response, true);

		return empty($result["matches"]) ? true : false;
	}

	/**
	 * Check for game end
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return boolean
	 */
	public function isFinish() : bool {
		return end($this->board) === $this->word ? true : false;
	}

	/**
	 * Display game's board
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return void
	 */
	public function display() : void {
		foreach ($this->board as $word) {
			echo " " . $this->translate($word) . "\n";
		}
		echo "\n";
	}

	/**
	 * Add game color to board's word
	 *
	 * @param string $word Board's word
	 *
	 * @author Erick Paoletti <erick.paoletti@gmail.com>
	 *
	 * @return string
	 */
	private function translate(string $word) : string {
		$result = "";
		$wordArray = mb_str_split($this->word);
		$tempWordArray = $wordArray;
		$lineArray = mb_str_split($word);

		$colorRed = $_ENV["BOLD"] ? Color::RED_BG->value : Color::RED->value;
		$colorYellow = $_ENV["BOLD"] ? Color::YELLOW_BG->value : Color::YELLOW->value;

		$result .= $colorRed . Color::BOLD->value . mb_strtoupper($wordArray[0]) . " ";
		unset($tempWordArray[0]);
		for ($i = 1; $i < count($wordArray); $i++) {
			if ($wordArray[$i] === $lineArray[$i]) {
				$result .= $colorRed . Color::BOLD->value . $wordArray[$i] . " ";
				unset($tempWordArray[array_search($lineArray[$i], $tempWordArray)]);
			} else {
				if (in_array($lineArray[$i], $tempWordArray)) {
					$result .= $colorYellow . Color::BOLD->value . $lineArray[$i] . " ";
					unset($tempWordArray[array_search($lineArray[$i], $tempWordArray)]);
				} else {
					$result .= Color::RESET->value . Color::BOLD->value . $lineArray[$i] . " ";
					unset($tempWordArray[array_search($lineArray[$i], $tempWordArray)]);
				}
			}
		}

		return $result . Color::RESET->value;
	}
}
