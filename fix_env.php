<?php
$file = '.env';
$content = file_get_contents($file);

// Detect if UTF-16 LE (common with PowerShell redirect)
if (substr($content, 0, 2) === "\xFF\xFE") {
    $content = iconv("UTF-16LE", "UTF-8", $content);
}

$lines = explode("\n", $content);
$cleanLines = [];

foreach ($lines as $line) {
    $line = trim($line);
    if (empty($line)) {
        continue;
    }
    // Remove null bytes
    $line = str_replace("\0", "", $line);

    // Check if line looks valid (key=value or comment)
    if ($line[0] === '#' || strpos($line, '=') !== false) {
        $cleanLines[] = $line;
    }
}

// Ensure proper session driver line exists once
$cleanLines = array_filter($cleanLines, function ($l) {
    return strpos($l, 'SESSION_DRIVER=') === false;
});
$cleanLines[] = 'SESSION_DRIVER=cookie'; // Add our desired config

file_put_contents($file, implode("\n", $cleanLines) . "\n");

echo "Cleaned .env file. Lines: " . count($cleanLines);
