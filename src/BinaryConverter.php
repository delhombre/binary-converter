<?php

declare(strict_types=1);

namespace BinaryConverter;

use BinaryConverter\Exceptions\InvalidArgumentException;

final class BinaryConverter
{
    private int|string $input;

    public static function from(int|string $input): BinaryConverter
    {
        $binaryConverter = new self();

        $binaryConverter->input = $input;

        return $binaryConverter;
    }

    public function toBinary(): string
    {
        $inputType = $this->detectInputType();

        return match ($inputType) {
            'int' => decbin((int) $this->input),
            'hex' => decbin((int) hexdec((string) $this->input)),
            'binary' => (string) $this->input,
            default => throw new InvalidArgumentException('Invalid input'),
        };
    }

    public function toDecimal(): int
    {
        $inputType = $this->detectInputType();

        return match ($inputType) {
            'int' => (int) $this->input,
            'hex' => (int) hexdec((string) $this->input),
            'binary' => (int) bindec((string) $this->input),
            default => throw new InvalidArgumentException('Invalid input'),
        };
    }

    public function toHex(): string
    {
        $inputType = $this->detectInputType();

        return match ($inputType) {
            'int' => dechex((int) $this->input),
            'hex' => (string) $this->input,
            'binary' => dechex((int) bindec((string) $this->input)),
            default => throw new InvalidArgumentException('Invalid input'),
        };
    }

    private function detectInputType(): string
    {
        if ($this->isInteger($this->input)) {
            return 'int';
        }
        if (ctype_xdigit($this->input)) {
            return 'hex';
        }
        if (preg_match('/^[01]+$/', (string) $this->input)) {
            return 'binary';
        }
        if (preg_match('/^\d+$/', (string) $this->input)) {
            return 'dec';
        }

        return 'unknown';
    }

    private function isInteger(mixed $value): bool
    {
        return is_numeric($value) && is_int($value + 0);
    }
}
