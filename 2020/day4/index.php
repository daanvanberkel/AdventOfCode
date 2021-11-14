<?php

declare(strict_types=1);

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);

$requiredFields = [
    'byr' => static fn (string $value): bool => ((int) $value) >= 1920 && ((int) $value) <= 2002,
    'iyr' => static fn (string $value): bool => ((int) $value) >= 2010 && ((int) $value) <= 2020,
    'eyr' => static fn (string $value): bool => ((int) $value) >= 2020 && ((int) $value) <= 2030,
    'hgt' => function (string $value): bool {
        $result = preg_match('/^([0-9]{2,3})(in|cm)$/', $value, $matches);
        if ($result !== 1 || count($matches) < 3) {
            return false;
        }
        $length = (int) $matches[1];

        if ($matches[2] === 'cm' && $length >= 150 && $length <= 193) {
            return true;
        }

        if ($matches[2] === 'in' && $length >= 59 && $length <= 76) {
            return true;
        }

        return false;
    },
    'hcl' => static fn (string $value): bool => preg_match('/^#[0-9a-f]{6}$/', $value) === 1,
    'ecl' => static fn (string $value): bool => in_array($value, ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']),
    'pid' => static fn (string $value): bool => preg_match('/^[0-9]{9}$/', $value) === 1,
];
$valid = 0;
$passports = [];
$passport = '';

foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '') {
        $passports[] = trim($passport);
        $passport = '';
        continue;
    }

    $passport .= ' ' . $line;
}

foreach ($passports as $passport) {
    $fields = explode(' ', $passport);
    $foundFields = [];

    foreach ($fields as $field) {
        [$key, $value] = explode(':', $field);
        $foundFields[$key] = $value;
    }

    foreach ($requiredFields as $requiredField => $validator) {
        if (!in_array($requiredField, array_keys($foundFields)) || !$validator($foundFields[$requiredField])) {
            continue 2;
        }
    }

    $valid++;
}

echo sprintf("Result: %s\n", $valid);
