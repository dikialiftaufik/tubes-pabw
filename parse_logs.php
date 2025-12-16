<?php
$logFile = 'storage/logs/laravel.log';
$lines = file($logFile);
$debugLines = [];

foreach ($lines as $line) {
    if (strpos($line, 'RoleMiddleware') !== false) {
        $debugLines[] = trim($line);
    }
}

// Get last 20 entries
$lastEntries = array_slice($debugLines, -20);


file_put_contents('debug_clean.txt', implode("\n", $lastEntries));
echo "Extracted " . count($lastEntries) . " lines to debug_clean.txt";
