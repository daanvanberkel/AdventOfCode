<?php

declare(strict_types=1);

$input = file_get_contents(sprintf('%s/input.txt', __DIR__));
$lines = explode(PHP_EOL, $input);
$highestId = 0;
$ids = [];

foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '') {
        continue;
    }

    echo sprintf("%s\n", $line);

    $instructions = str_split($line);
    $rowInstructions = array_slice($instructions, 0, 7);
    $seatInstructions = array_slice($instructions, 7);
    $rows = [];
    $seats = [];

    for ($i = 0; $i < 128; $i++) {
        $rows[] = $i;
    }

    for ($i = 0; $i < 8; $i++) {
        $seats[] = $i;
    }

    foreach ($rowInstructions as $rowInstruction) {
        $totalRows = count($rows);

        if ($rowInstruction === 'F') {
            $rows = array_slice($rows, 0, $totalRows / 2);
        }

        if ($rowInstruction === 'B') {
            $rows = array_slice($rows, $totalRows / 2);
        }
    }

    echo sprintf("\tRow: %s\n", implode(', ', $rows));

    foreach ($seatInstructions as $seatInstruction) {
        $totalSeats = count($seats);

        if ($seatInstruction === 'L') {
            $seats = array_slice($seats, 0, $totalSeats / 2);
        }

        if ($seatInstruction === 'R') {
            $seats = array_slice($seats, $totalSeats / 2);
        }
    }

    echo sprintf("\tSeat: %s\n", implode(', ', $seats));

    $id = ($rows[0] * 8) + $seats[0];

    if ($id > $highestId) {
        $highestId = $id;
    }

    $ids[] = $id;

    echo sprintf("\t%s\n", $id);
}

asort($ids);
$ids = array_values($ids);

for ($i = 0; $i < count($ids); $i++) {
    if ($i + 1 === count($ids)) {
        continue;
    }

    if ($ids[$i + 1] === $ids[$i] + 2) {
        echo sprintf("Result: %s\n", $ids[$i] + 1);
    }
}
