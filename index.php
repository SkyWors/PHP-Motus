<?php

require __DIR__ . "/vendor/autoload.php";

use
	Motus\Motus,
	Motus\Utils,
	Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__)->load();

enum Color : string {
	case RESET = "\033[0m";
	case RED = "\e[31m";
	case YELLOW = "\e[33m";
	case GREEN = "\e[32m";
	case CYAN = "\e[36m";
	case RED_BG = "\033[41m";
	case BOLD = "\e[1m";
}

if ($_ENV["WORD"] == "list") {
	$words = json_decode(file_get_contents(__DIR__ . "/data/words.json"), false);
	$word = $words[array_rand($words)];
} else {
	$word = Utils::randomWord("fr");
}

$motus = new Motus(word: $word);

$try = 1;
while (true) {
	Utils::clear();

	if (isset($message)) {
		echo $message;
		unset($message);
	}

	echo Color::CYAN->value . "  Essai " . Color::YELLOW->value . $try . "/" . $_ENV["TRY"] . "\n\n" . Color::RESET->value;

	if ($motus->isFinish()) {
		Utils::clear();
		$motus->display();
		echo Color::GREEN->value . "\nLe mot \"$word\" a été trouvé en " . $try -1 . " essai" . Utils::plural($try) . " !\n\n" . Color::RESET->value;
		exit;
	}

	if ($try === $_ENV["TRY"] +1) {
		Utils::clear();
		$motus->display();
		echo Color::RED->value . "\nLe mot \"$word\" n'a pas été trouvé.\n\n" . Color::RESET->value;
		exit;
	}

	$motus->display();

	if ($motus->isBoardEmpty()) {
		$color = $_ENV["BOLD"] ? Color::RED_BG->value : Color::RED->value;
		echo " " . $color . Color::BOLD->value . mb_strtoupper(mb_substr($word, 0, 1)) . " " . Color::RESET->value;
		for ($i = 1; $i < mb_strlen($word); $i++) {
			echo "_ ";
		}
		echo "  (" . mb_strlen($word) . ")\n";
	}

	echo Color::CYAN->value . "\nMerci de proposer un mot :\n" . Color::RESET->value;
	$line = strtolower(str_replace(" ", "", trim(fgets(STDIN))));

	Utils::clear();

	if (!$motus->checkLength(input: $line)) {
		$message = Color::CYAN->value . "Le nombre de charactère ne correspond pas.\n\n" . Color::RESET->value;
		continue;
	}
	if (!$motus->checkFirstLetter(input: $line)) {
		$message = Color::CYAN->value . "Le mot saisi ne commence pas par la lettre \"" . mb_strtoupper(mb_substr($word, 0, 1)) . "\".\n\n" . Color::RESET->value;
		continue;
	}
	if (!$motus->isWord(input: $line)) {
		$message = Color::CYAN->value . "L'entrée saisie n'est pas un mot valide.\n\n" . Color::RESET->value;
		continue;
	}

	$motus->input(input: $line);

	$try++;
}
