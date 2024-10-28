<?php

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
