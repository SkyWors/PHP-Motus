<?php

$word = "ecran";
$wordArray = str_split($word);

$resultArray = array();

$display = $wordArray[0];
for ($i = 1; $i < count($wordArray); $i++) {
	$display .= "0";
}
array_push($resultArray, $display);

while (1) {
	clear();

	display($resultArray);

	if (end($resultArray) == $word) {
		echo "finish.";
		exit;
	}

	echo "\n\n";
	do {
		$input = fopen("php://stdin","r");
		$line = fgets($input);
		$line = preg_replace('/[^A-Za-z0-9\-]/', '', $line);
	} while (strlen($line) != strlen($word));

	if ($line == $word) {
		echo "finish.";
		exit;
	}

	$lineArray = str_split($line);

	$check = check($word, $wordArray, $lineArray);

	for ($i = 0; $i < count($check); $i++) {
		if ($check[$i] === 2) {
			$check[$i] = $wordArray[$i];
		}
	}

	$last = str_split(end($resultArray));
	for ($i = 0; $i < count($last); $i++) {
		if ($last[$i] != 0 && $last[$i] != 1 && $last[$i] != 2) {
			$check[$i] = $last[$i];
		}
	}

	array_push($resultArray, join($check));
}

function display($resultArray) {
	foreach ($resultArray as $value) {
		foreach (str_split($value) as $letter) {
			if ($letter == 0) {
				echo "_";
			}
			elseif ($letter == 1) {
				echo ".";
			} else {
				echo $letter;
			}
		}
		echo "\n";
	}
}

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

function clear() {
	for ($i = 0; $i < 3; $i++) {
		echo "\n";
	}
}
