<?php

include __DIR__ . "/utils/clear.php";
include __DIR__ . "/class/Motus.php";

$words = json_decode(file_get_contents(__DIR__ . "/words.json"), false);
$word = strtoupper($words[array_rand($words)]);
$motus = new Motus($word);

while (1) {
	$motus->display();

	if ($motus->isFinish()) {
		echo "Le mot \"$word\" a été trouvé !\n";
		exit;
	}

	$input = fopen("php://stdin","r");
	$line = strtoupper(fgets($input));
	$line = preg_replace('/[^A-Z\-]/', '', $line);

	clear();

	if (!$motus->checkLength($line)) {
		echo "Le nombre de charactère ne correpond pas.\n";
	} else {
		$motus->check($line);
	}
}
