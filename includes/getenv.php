<?php
if(!file_exists(__DIR__ . "/../.env")) {
    exit;
}

$lines = file(__DIR__ . "/../.env", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (str_starts_with(trim($line), '#')) continue;

    list($key, $value) = explode('=', $line, 2);
    $key = trim($key);
    $value = trim($value);

    $value = trim($value, '"\'');
        
    $_ENV[$key] = $value;
}