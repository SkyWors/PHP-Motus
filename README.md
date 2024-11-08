# ⭐ PHP-Motus

> [!NOTE]
> This is an incredible reproduction of the famous french TV game called "Motus"!

## 📌 How to play?

1. <u>Run the game</u>

Use ``php index.php`` on any terminal open in project's root folder.

2. <u>Input a word</u>

Input a word and press enter.

> Word can be format with any upper or lower case, make sure to <u>correctly write potential accents</u> according to french dictionnary.

```
Example: search word is "Hôpital"

	✅ Input "hôpital" will be correct,
	✅ Input "HôpItAL" will be correct,
	✅ Input "  H ô  pi tal" will be correct.
	❌ Input "Hopital" will be incorrect.
```

3. <u>Understand display</u>

- Red letter: letter is in searched word and correctly placed,
- Yellow letter: letter is in searched word but incorrectly placed,
- White letter: letter is not in searched word.

## 🤔 Requirements

- [PHP](https://www.php.net/) >=8.3
- [Composer](https://getcomposer.org/) Latest

## 🔧 Installation

1. <u>Modules</u>

> [!WARNING]
> Make sure to have the [correct PHP version](#-requirements).

Use `composer install` on any terminal open in project's root folder.

2. <u>Parameters</u>

Rename `.env.example` to `.env`

> *See [Settings](#️-settings) for more explanations*.

## ⚙️ Settings

### 📝 Word

- List : Use the integrated word's list located at ``data/words.json`` to pickup random words
- API : Use external API to pickup random words, ⚠️ harder difficulty!

### 👤 Try

How many try should player got?

### 👾 Background

Choose between simple *(BOLD = 0)* or complex *(BOLD = 1)*

![image](https://github.com/user-attachments/assets/a88b3228-0ccc-4812-80b6-101fe4cc086e)
![image](https://github.com/user-attachments/assets/298af059-3b54-474f-a0b7-78e54d8cfaff)

### 🚧 Development

Enable DEBUG key to display some usefull logs.

## Unit tests

> [!WARNING]
> Make sure to have [composer](#-requirements) installed and [initialized](#-installation).

Use ``composer test`` on any terminal open in project's root folder to test program's functions.

