<?php

use BinaryConverter\BinaryConverter;
use BinaryConverter\Exceptions\InvalidArgumentException;

beforeEach(function () {
    $this->binaryConverter = new BinaryConverter();
    $this->reflection = new \ReflectionClass(get_class($this->binaryConverter));
});

describe('check if an input is an integer', function () {
    beforeEach(function () {
        $this->method = $this->reflection->getMethod('isInteger');
        $this->method->setAccessible(true);
    });

    it('should return true for 10 given', function () {
        expect($this->method->invoke($this->binaryConverter, 10))->toBeTrue();
    });

    it("should return true for '10' given", function () {
        expect($this->method->invoke($this->binaryConverter, '10'))->toBeTrue();
    });

    it('should return false for null given', function () {
        expect($this->method->invoke($this->binaryConverter, null))->toBeFalse();
    });

    it('should return false for [] given', function () {
        expect($this->method->invoke($this->binaryConverter, []))->toBeFalse();
    });
});

describe('check the type of an input', function () {
    beforeEach(function () {
        $this->method = $this->reflection->getMethod('detectInputType');
        $this->input = $this->reflection->getProperty('input');
        $this->input->setAccessible(true);
        $this->inputType = $this->reflection->getProperty('inputType');
        $this->inputType->setAccessible(true);
    });

    it('should return int for 10 given', function () {
        $this->input->setValue($this->binaryConverter, 10);
        expect($this->method->invoke($this->binaryConverter, 10))->toBe('int');
    });

    it("should return int for '10' given", function () {
        $this->input->setValue($this->binaryConverter, '10');
        expect($this->method->invoke($this->binaryConverter, '10'))->toBe('int');
    });

    it('should return hex for a given', function () {
        $this->input->setValue($this->binaryConverter, 'a');
        expect($this->method->invoke($this->binaryConverter, 'a'))->toBe('hex');
    });

    it("should return binary for '1010' given", function () {
        $this->input->setValue($this->binaryConverter, '1010');
        $this->inputType->setValue($this->binaryConverter, 'binary');
        expect($this->method->invoke($this->binaryConverter, '1010'))->toBe('binary');
    });
});

it('may return 0 for 0 given', function () {
    expect(BinaryConverter::from(0)->toBinary())->toBe('0');
});

it('may return 1 for 1 given', function () {
    expect(BinaryConverter::from('1')->toBinary())->toBe('1');
});

it('may return 11111101000 for 2024 given', function () {
    expect(BinaryConverter::from(2024)->toBinary())->toBe('11111101000');
});

it("may return 11111101000 for '2024' given", function () {
    expect(BinaryConverter::from('2024')->toBinary())->toBe('11111101000');
});

it('may return 7e8 for 2024 given', function () {
    expect(BinaryConverter::from(2024)->toHex())->toBe('7e8');
});

it('may return 2024 for 7e8 given', function () {
    expect(BinaryConverter::from('7e8')->toDecimal())->toBe(2024);
});

it('may return 1010 for 10 given', function () {
    expect(BinaryConverter::from(10)->toBinary())->toBe('1010');
});

it('may return 1001 for 9 given', function () {
    expect(BinaryConverter::from(9)->toBinary())->toBe('1001');
});

it('may return 1111 for 15 given', function () {
    expect(BinaryConverter::from(15)->toBinary())->toBe('1111');
});

it('may return 10000 for 16 given', function () {
    expect(BinaryConverter::from(16)->toBinary())->toBe('10000');
});

it('may return a for 10 given', function () {
    expect(BinaryConverter::from(10)->toHex())->toBe('a');
});

it('may return f for 15 given', function () {
    expect(BinaryConverter::from(15)->toHex())->toBe('f');
});

it('may return 10 for 16 given', function () {
    expect(BinaryConverter::from(16)->toHex())->toBe('10');
});

it('may return 10 for a given', function () {
    expect(BinaryConverter::from('a')->toDecimal())->toBe(10);
});

it('may return 15 for f given', function () {
    expect(BinaryConverter::from('f')->toDecimal())->toBe(15);
});

it("should throw an InvalidArgumentException for 'z' given", function () {
    BinaryConverter::from('z')->toDecimal();
})->throws(InvalidArgumentException::class);

it("should throw an InvalidArgumentException for 'zz' given", function () {
    BinaryConverter::from('z')->toBinary();
})->throws(InvalidArgumentException::class);

it("should throw an InvalidArgumentException for 'zzz' given", function () {
    BinaryConverter::from('z')->toHex();
})->throws(InvalidArgumentException::class, 'Invalid input');
