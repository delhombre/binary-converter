<p align="center">
    <img src="https://raw.githubusercontent.com/delhombre/binary-converter/main/art/example.png" width="600" alt="BinaryConverter PHP">
    <p align="center">
        <a href="https://github.com/delhombre/binary-converter/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/delhombre/binary-converter/tests.yaml?branch=main&label=tests&style=round-square"></a>
        <a href="https://packagist.org/packages/delhombre/binary-converter"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/delhombre/binary-converter"></a>
        <a href="https://packagist.org/packages/delhombre/binary-converter"><img alt="Latest Version" src="https://img.shields.io/packagist/v/delhombre/binary-converter"></a>
        <a href="https://packagist.org/packages/delhombre/binary-converter"><img alt="License" src="https://img.shields.io/github/license/delhombre/binary-converter"></a>
    </p>
</p>

---

**BinaryConverter** is a PHP library that converts binary numbers to decimal numbers and vice versa. It also supports hexadecimal conversion.

## Get Started

> **Requires [PHP 8.1+](https://php.net/releases/)**

First, install BinaryConverter via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require delhombre/binary-converter
```

Then, interact with OpenAI's API:

```php
$converter = BinaryConverter::from(2024);

$bin = $converter->toBinary();

dd($bin); // "11111101000"
```

You can pass the input as a string or as an integer.

```php
dd(BinaryConverter::from('2024')->toBinary()); // "11111101000"
```

But sometimes you may want to convert a binary number to a decimal number. You can do it by passing the inputType parameter like this:

```php
dd(BinaryConverter::from('11111101000', 'binary')->toDecimal()); // 2024
```

---

BinaryConverter PHP is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
