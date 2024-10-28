<?php

function check($word, $wordArray, $inputArray) {
	$result = array();
	for ($i = 0; $i < count($wordArray); $i++) {
		array_push($result, 0);
	}

	for ($i = 0; $i < count($wordArray); $i++) {
		if (str_contains($word, $inputArray[$i])) {
			$result[$i] = 1;
		}

		if ($wordArray[$i] == $inputArray[$i]) {
			$result[$i] = 2;
		}
	}

	return $result;
}
