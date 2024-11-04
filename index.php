<?php

include __DIR__ . "/utils/clear.php";
include __DIR__ . "/class/Motus.php";

$words = json_decode(file_get_contents(__DIR__ . "/words.json"), false);
$word = $words[array_rand($words)];
$motus = new Motus($word);

$try = 1;
while (1) {
	echo "Essai $try/6\n";
	$motus->display();

	if ($motus->isFinish()) {
		echo "Le mot \"$word\" a été trouvé !\n";
		exit;
	}

	if ($try > 5) {
		echo "Le mot \"$word\" n'a pas été trouvé.\n";
		exit;
	}

	$line = strtolower(trim(fgets(STDIN)));

	clear();

	if (!$motus->checkLength($line)) {
		echo "Le nombre de charactère ne correspond pas.\n";
	} else {
		if ($motus->isWord($line)) {
			$motus->check($line);
			$try++;
		} else {
			echo "L'entrée saisie n'est pas un mot valide.\n";
		}
	}
}
