<?php

declare(strict_types=1);

namespace BinaryConverter;

use BinaryConverter\Exceptions\InvalidArgumentException;

final class BinaryConverter
{
    /**
     * @var array<string, string>
     */
    public const array Type = [
        'INT' => 'int',
        'HEX' => 'hex',
        'BINARY' => 'binary',
    ];

    private int|string $input;

    private ?string $inputType = null;

    /**
     * @param  value-of<BinaryConverter::Type>  $inputType
     */
    public static function from(int|string $input, ?string $inputType = null): BinaryConverter
    {
        $binaryConverter = new self();

        $binaryConverter->input = $input;

        if (isset($inputType)) {
            if (! in_array($inputType, ['int', 'hex', 'binary'])) {
                throw new InvalidArgumentException('Invalid input type. Allowed types are int, hex and binary.');
            }
            $binaryConverter->inputType = $inputType;
        }

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
        if ($this->inputType !== null) {
            return $this->inputType;
        }

        if ($this->isInteger($this->input)) {
            return 'int';
        }
        if (ctype_xdigit($this->input)) {
            return 'hex';
        }
        if (preg_match('/^[01]+$/', (string) $this->input)) {
            return 'binary';
        }

        return 'unknown';
    }

    private function isInteger(mixed $value): bool
    {
        return is_numeric($value) && is_int($value + 0);
    }
}
