<?php

include __DIR__ . "/utils/check.php";
include __DIR__ . "/utils/clear.php";
include __DIR__ . "/utils/display.php";

$words = json_decode(file_get_contents(__DIR__ . "/words.json"), false);
$word = strtoupper($words[array_rand($words)]);
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
		exit;
	}

	do {
		$input = fopen("php://stdin","r");
		$line = strtoupper(fgets($input));
		$line = preg_replace('/[^A-Za-z0-9\-]/', '', $line);
	} while (strlen($line) != strlen($word));

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
