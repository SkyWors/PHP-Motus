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
	echo Color::CYAN->value . "  Essai $try/" . $_ENV["TRY"] . "\n\n" . Color::RESET->value;

	$motus->display();

	if ($try === $_ENV["TRY"] +1) {
		echo Color::RED->value . "Le mot \"$word\" n'a pas été trouvé.\n\n";
		exit;
	}

	if ($motus->isBoardEmpty()) {
		$color = $_ENV["BOLD"] ? Color::RED_BG->value : Color::RED->value;
		echo "\n " . $color . Color::BOLD->value . mb_strtoupper(mb_substr($word, 0, 1)) . " " . Color::RESET->value;
		for ($i = 1; $i < mb_strlen($word); $i++) {
			echo "_ ";
		}
		echo "  (" . mb_strlen($word) . ")\n\n";
	}

	$line = strtolower(trim(fgets(STDIN)));

	if ($motus->checkLength(input: $line)) {
		if ($motus->checkFirstLetter(input: $line)) {
			if ($motus->isWord(input: $line)) {
				$motus->input(input: $line);

				Utils::clear();

				if ($motus->isFinish()) {
					$motus->display();

					echo Color::GREEN->value . "Le mot \"$word\" a été trouvé en $try essai" . Utils::plural($try) . " !\n\n" . Color::RESET->value;
					exit;
				}
				$try++;
			} else {
				Utils::clear();
				echo Color::CYAN->value . "L'entrée saisie n'est pas un mot valide.\n\n" . Color::RESET->value;
			}
		} else {
			Utils::clear();
			echo Color::CYAN->value . "Le mot saisi ne commence pas par la lettre \"" . mb_strtoupper(mb_substr($word, 0, 1)) . "\".\n\n" . Color::RESET->value;
		}
	} else {
		Utils::clear();
		echo Color::CYAN->value . "Le nombre de charactère ne correspond pas.\n\n" . Color::RESET->value;
	}
}
